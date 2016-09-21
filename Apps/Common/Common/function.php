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
 * 取字典项数组
 * @param string $name 字典名
 * @access public
 * @return array
 */
function getArrayAssessment($name) {
	return require('./Conf/pinggu/' . $name . '.php');
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

function substrs($content, $length){
	if($length && strlen($content)>$length){
		if($db_charset!='utf-8'){
			$retstr='';
			for($i = 0; $i < $length - 2; $i++) {
				$retstr .= ord($content[$i]) > 127 ? $content[$i].$content[++$i] : $content[$i];
			}
			return $retstr;
		}else{
			return utf8_trim(substr($content,0,$length*3));
		}
	}
	return $content;
}

/**
 * 将一个二维数组转换为 hashmap
 *
 * 如果省略 $valueField 参数，则转换结果每一项为包含该项所有数据的数组。
 *
 * @param array $arr
 * @param string $keyField
 * @param string $valueField
 *
 * @return array
 */
function array_to_hashmap(& $arr, $keyField, $valueField = null)
{
	$ret = array();
	if ($valueField) {
		foreach ($arr as $row) {
			$ret[$row[$keyField]] = $row[$valueField];
		}
	} else {
		foreach ($arr as $row) {
			$ret[$row[$keyField]] = $row;
		}
	}
	return $ret;
}

/**
 * 把浏览过的房源写入cookies
 * @param id
 * @return null
 *
 */
function cookiesmy($id)
{
	$TempNum = 5;
	//setcookie("RecentlyGoods", "12,31,90,39");
	//RecentlyGoods 最近商品RecentlyGoods临时变量
	if (isset($_COOKIE['RecentlyGoods'])) {
		$RecentlyGoods = $_COOKIE['RecentlyGoods'];
		$RecentlyGoodsArray = explode(",", $RecentlyGoods);
		$RecentlyGoodsNum = count($RecentlyGoodsArray); //RecentlyGoodsNum 当前存储的变量个数
	}
	if ($id != "") {
		if (strstr($RecentlyGoods, (string)$id)) {

		} else {
			if ($RecentlyGoodsNum < $TempNum) //如果COOKIES中的元素小于指定的大小，则直接进行输入COOKIES
			{
				if ($RecentlyGoods == "") {
					setcookie("RecentlyGoods", $id, time() + 432000, "/");
				} else {
					$RecentlyGoodsNew = $RecentlyGoods . "," . $id;
					setcookie("RecentlyGoods", $RecentlyGoodsNew, time() + 432000, "/");
				}
			} else{//如果大于了指定的大小后，将第一个给删去，在尾部再加入最新的记录。
				$pos = strpos($RecentlyGoods, ",") + 1; //第一个参数的起始位置
				$FirstString = substr($RecentlyGoods, 0, $pos); //取出第一个参数
				$RecentlyGoods = str_replace($FirstString, "", $RecentlyGoods); //将第一个参数删除
				$RecentlyGoodsNew = $RecentlyGoods . "," . $id; //在尾部加入最新的记录
				setcookie("RecentlyGoods", $RecentlyGoodsNew, time() + 432000, "/");
			}
		}
	}
}


/**
 * 把浏览过的房源写入cookies
 * @param id
 * @return null
 *
 */
function cookiesmyrent($id)
{
	$TempNum = 5;
	//setcookie("RRecentlyGoods", "12,31,90,39");
	//RRecentlyGoods 最近商品RRecentlyGoods临时变量
	if (isset($_COOKIE['RRecentlyGoods'])) {
		$RRecentlyGoods = $_COOKIE['RRecentlyGoods'];
		$RRecentlyGoodsArray = explode(",", $RRecentlyGoods);
		$RRecentlyGoodsNum = count($RRecentlyGoodsArray); //RRecentlyGoodsNum 当前存储的变量个数
	}
	if ($id != "") {
		if (strstr($RRecentlyGoods, (string)$id)) {

		} else {
			if ($RRecentlyGoodsNum < $TempNum) //如果COOKIES中的元素小于指定的大小，则直接进行输入COOKIES
			{
				if ($RRecentlyGoods == "") {
					setcookie("RRecentlyGoods", $id, time() + 432000, "/");
				} else {
					$RRecentlyGoodsNew = $RRecentlyGoods . "," . $id;
					setcookie("RRecentlyGoods", $RRecentlyGoodsNew, time() + 432000, "/");
				}
			} else{//如果大于了指定的大小后，将第一个给删去，在尾部再加入最新的记录。
				$pos = strpos($RRecentlyGoods, ",") + 1; //第一个参数的起始位置
				$FirstString = substr($RRecentlyGoods, 0, $pos); //取出第一个参数
				$RRecentlyGoods = str_replace($FirstString, "", $RRecentlyGoods); //将第一个参数删除
				$RRecentlyGoodsNew = $RRecentlyGoods . "," . $id; //在尾部加入最新的记录
				setcookie("RRecentlyGoods", $RRecentlyGoodsNew, time() + 432000, "/");
			}
		}
	}
}


	/**
	 * 将时间戳转换为固定格式字符串
	 * @param $time
	 * @return string
	 */
	function time2Units($time){
		$year = floor($time / 60 / 60 / 24 / 365);
		$time -= $year * 60 * 60 * 24 * 365;
		$month = floor($time / 60 / 60 / 24 / 30);
		$time -= $month * 60 * 60 * 24 * 30;
		$week = floor($time / 60 / 60 / 24 / 7);
		$time -= $week * 60 * 60 * 24 * 7;
		$day = floor($time / 60 / 60 / 24);
		$time -= $day * 60 * 60 * 24;
		$hour = floor($time / 60 / 60);
		$time -= $hour * 60 * 60;
		$minute = floor($time / 60);
		$time -= $minute * 60;
		$second = $time;
		$elapse = '';
		$unitArr = array('年' =>'year', '个月'=>'month', '周'=>'week', '天'=>'day', '小时'=>'hour', '分钟'=>'minute', '秒'=>'second');
		foreach ( $unitArr as $cn => $u ) {
			if ( $$u > 0 ) {
				$elapse = $$u . $cn;
				break;
			}
		}
		return $elapse;
	}

/**
 * 将一个二维数组按照指定列进行排序，类似 SQL 语句中的 ORDER BY
 * @param $rowset
 * @param $args
 * @return mixed
 */
function array_sortby_multifields($rowset, $args)
{
	$sortArray = array();
	$sortRule = '';
	foreach ($args as $sortField => $sortDir) {
		foreach ($rowset as $offset => $row) {
			$sortArray[$sortField][$offset] = $row[$sortField];
		}
		$sortRule .= '$sortArray[\'' . $sortField . '\'], ' . $sortDir . ', ';
	}
	if (empty($sortArray) || empty($sortRule)) { return $rowset; }
	eval('array_multisort(' . $sortRule . '$rowset);');
	return $rowset;
}

?>