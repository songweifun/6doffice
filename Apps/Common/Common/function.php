<?php

/**
 * ���ô�ӡ����
 * @param $arr
 */
function p($arr){
	echo '<pre>';
	print_r($arr);
}




/**
 * ת��URL,����ʾ��Ϣ
 * @param string $url URL
 * @param string $msg ��ʾ��Ϣ
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
 * cookie���봦��
 * @param string $string Ҫ������ַ���
 * @param string $operation ����ENCODE���룬DECODE����
 * @param string $key hashֵ
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
 * ȡ��ǰ�û���Ϣcookie�е�
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
 * ͨ������������ȼ�����
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
		//�������һ��
		return $a_level[$field];
	}
}


/**
 * ȡ�ֵ�������
 * @param string $name �ֵ���
 * @access public
 * @return array
 */
function getArray($name) {
	return require('./Conf/dd/' . $name . '.php');
}

/**
 * ȡ�ֵ�������
 * @param string $name �ֵ���
 * @param string $value ֵ
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
 * ȡ�ֵ������� ����
 * @param string $name �ֵ���
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
 * ת���뺯��
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
 * ��������ɾ���հ׵�Ԫ�أ�����ֻ�пհ��ַ���Ԫ�أ�
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