<?php

/**
 * 常用打印函数
 * @param $arr
 */
function p($arr){
	echo '<pre>';
	print_r($arr);
}




/**
 * 转到URL,并提示信息
 * @param string $url URL
 * @param string $msg 提示信息
 * @access public
 * @return void
 */
function jsurlto($msg=NULL,$url) {
	echo "<script language='JavaScript' type='text/javascript'>";

	echo "alert('".$msg."');";

	echo 'document.location="' . $url . '";';
	echo "</script>";
}


/**
 * cookie编码处理
 * @param string $string 要编码的字符串
 * @param string $operation 操作ENCODE编码，DECODE解码
 * @param string $key hash值
 * @return string
 */
function authcode($string, $operation, $key = '') {
	$coded = '';
	$keylength = strlen($key);
	$string = $operation == 'DECODE' ? base64_decode($string) : $string;
	for($i = 0; $i < strlen($string); $i += $keylength) {
		$coded .= substr($string, $i, $keylength) ^ $key;
	}
	$coded = $operation == 'ENCODE' ? str_replace('=', '', base64_encode($coded)) : $coded;
	return $coded;
}

/**
 * 取当前用户信息cookie中的
 * @access public
 * @return array
 */
function getAuthInfo($field=NULL) {
	$authInfo = authcode($_COOKIE['AUTH_MEMBER_STRING'], 'DECODE', C('AUTH_KEY'));
	$authInfo = explode("\t",$authInfo);
	$result['id'] = $authInfo[0];
	$result['passwd'] = $authInfo[1];
	$result['user_type'] = $authInfo[2];
	if ($_COOKIE['AUTH_MEMBER_NAME']) {
		$result['username'] = $_COOKIE['AUTH_MEMBER_NAME'];
	}
	if ($_COOKIE['AUTH_MEMBER_REALNAME']) {
		$result['realname'] = $_COOKIE['AUTH_MEMBER_REALNAME'];
	}

	if ($field) {
		if ($result[$field]) {
			return $result[$field];
		} else {
			$userInfo = M('member')->find($result['id']);
			$detailInfo = M('broker_info')->find($result['id']);
			$info= array_merge((array)$userInfo,(array)$detailInfo);
			return $info[$field];
		}
	}
	return $result;
}

/**
 * 通过分数来计算等级函数
 * @param $score
 * @param $array
 * @param string $field
 * @return mixed
 */
function getNumByScore($score,$array,$field ='sell_num'){

	foreach($array as $a_level){
		if($score < $a_level['score']){
			return $a_level[$field];
		}else{
			continue;
		}
		//返回最后一个
		return $a_level[$field];
	}
}


/**
 * 取字典项数组
 * @param string $name 字典名
 * @access public
 * @return array
 */
function getArray($name) {
	return require('./Conf/dd/' . $name . '.php');
}

/**
 * 取字典项名称
 * @param string $name 字典名
 * @param string $value 值
 * @access public
 * @return array
 */
function getCaption($name, $value) {
	if($value ==''){
		return '';
	}
	$array =getArray($name);
	if (strpos($value,',')===false) {
		return $array[$value];
	} else {
		$values = explode(',',$value);
		$result = '';
		foreach ($values as $v) {
			if ($v) {
				$result .= $array[$v] . ' ';
			}
		}
	}
	return $result;
}

/**
 * 取字典项数组 分组
 * @param string $name 字典名
 * @access public
 * @return array
 */
function getArrayGrouped($dd_name) {
	$dd_idarr=M('dd')->where(array('dd_name'=>$dd_name))->find();
	$dd_id=$dd_idarr['dd_id'];
	$dd_array=M('dd_item')->where(array('dd_id'=>$dd_id))->order('list_order')->select();
	//p($dd_array);die();

	if(is_array($dd_array)){
		foreach ($dd_array as $a_dditem){
			$grouped_array[$a_dditem['list_group']][$a_dditem['di_value']] = $a_dditem['di_caption'];
		}
		ksort($grouped_array);
	}
	//p($grouped_array);die();
	return $grouped_array;

}

/**
 * 转编码函数
 * @param $vars
 * @param string $from
 * @param string $to
 * @return array|string
 */
function charsetIconv($vars,$from='utf-8',$to='utf8') {
	if (is_array($vars)) {
		$result = array();
		foreach ($vars as $key => $value) {
			$result[$key] = charsetIconv($value);
		}
	} else {
		$result = iconv($from,$to, $vars);
	}
	return $result;
}

/**
 * 从数组中删除空白的元素（包括只有空白字符的元素）
 *
 * @param array $arr
 * @param boolean $trim
 */
function array_remove_empty(& $arr, $trim = true)
{
	foreach ($arr as $key => $value) {
		if (is_array($value)) {
			array_remove_empty($arr[$key]);
		} else {
			$value = trim($value);
			if ($value == '') {
				unset($arr[$key]);
			} elseif ($trim) {
				$arr[$key] = $value;
			}
		}
	}
}

?>