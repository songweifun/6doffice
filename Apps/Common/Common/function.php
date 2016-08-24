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

?>