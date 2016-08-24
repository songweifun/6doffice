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

?>