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
 * ���ύ�����ݽ���html��ʽ����
 * @param array $array ���������
 * @param array $lists Ҫ�����������key������
 * @return array
 */
function specConvert (&$array, $lists) {
	foreach ($lists as $value) {
		$array[$value] = htmlspecialchars($array[$value],ENT_COMPAT,'gb2312');
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
function utf8_trim($str) {
	$len = strlen($str);
	for($i=strlen($str)-1;$i>=0;$i-=1){
		$hex .= ' '.ord($str[$i]);
		$ch   = ord($str[$i]);
		if(($ch & 128)==0)	return substr($str,0,$i);
		if(($ch & 192)==192)return substr($str,0,$i);
	}
	return($str.$hex);
}
function c_addslashes($string, $force = 0) {
	if(!$GLOBALS['magic_quotes_gpc'] || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = c_addslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}
function addslashes_mssql($string) {
	return str_replace('\'','\'\'',$string);
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
 * ȡ�������ĵ���·��
 * @return string
 */
function getRootPath() {
	$sRealPath = realpath('./');
	$sSelfPath = $_SERVER['PHP_SELF'];
	$sSelfPath = substr( $sSelfPath, 0, strrpos( $sSelfPath, '/' ));
	return substr($sRealPath, 0, strlen($sRealPath) - strlen($sSelfPath));
}

/**
 * ���ļ�·��ת����URL
 * @param string $path Ҫת����·��
 * @return string
 */
function pathToUrl($path) {
	$path = str_replace(getRootPath(),'',$path);
	$path = str_replace('\\','/',$path);
	$path = str_replace('//','/',$path);
	return $path;
}
function charsetIconv($vars,$from='utf-8',$to='gbk') {
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
function wap_go($msg,$url,$time)
{
	echo '<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<card title="go" ontimer="'.$url.'">
<timer value="'.$time.'"/>
<p>'.$msg.'</p>
</card>
</wml>';
	exit;
}
function wap_cv($msg){
	$msg = str_replace('<p>','',$msg);
	$msg = str_replace('</p>','<br /><br />',$msg);
	$msg = str_replace('&ldquo;','"',$msg);
	$msg = str_replace('&rdquo;','"',$msg);
	$msg = str_replace('&nbsp;',' ',$msg);
	$msg = str_replace('<br>','<br/> ',$msg);
	return $msg;
}
function StrCode($string,$action='ENCODE'){
	global $cfg;
	$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].$cfg['auth_key']),8,18);
	$string	= $action == 'ENCODE' ? $string : base64_decode($string);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($string); $i++){
		$k		= $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}
/*function Cookie($ck_Var,$ck_Value,$ck_Time = 'F'){
	$timestamp=time();
	$db_ckpath = '/';
	$db_ckdomain = '';
	$ck_Time = $ck_Time == 'F' ? $timestamp + 31536000 : ($ck_Value == '' && $ck_Time == 0 ? $timestamp - 31536000 : $ck_Time);
	$S		 = $_SERVER['SERVER_PORT'] == '443' ? 1:0;
	!$db_ckpath && $db_ckpath = '/';
	setCookie(CookiePre().'_'.$ck_Var,$ck_Value,$ck_Time,$db_ckpath,$db_ckdomain,$S);
}*/

function blogCookie($ck_Var,$ck_Value,$ck_Time='F'){
	$timestamp=time();
	$db_ckpath = '/';
	$db_ckdomain = '';
	if($_SERVER['HTTP_HOST']!='localhost' && !is_numeric(substr(strrchr($_SERVER['HTTP_HOST'],'.'),1))){
		$db_ckdomain = substr($_SERVER['HTTP_HOST'],strpos($_SERVER['HTTP_HOST'],'.')+1);
		$db_ckdomain = (strpos($db_ckdomain,'.')===false) ? '.'.$_SERVER['HTTP_HOST'] : '.'.$db_ckdomain;
	}
	$ck_Time = $ck_Time=='F' ? $timestamp+31536000 : ($ck_Value=='' && $ck_Time==0 ? $timestamp-31536000 : $ck_Time);
	!$db_ckpath && $db_ckpath='/';
	setCookie(CookiePre().'_'.$ck_Var,$ck_Value,$ck_Time,$db_ckpath,$db_ckdomain,GetSecure());
}

function CookiePre(){
	global $cfg;
	return substr(md5($cfg['auth_key']),0,5);
}

function checkpass($username,$password){
	global $cfg;
	include($cfg['path']['conf'].'db1.conf.php');
	$timestamp = time();
	$onlineip = $_SERVER['REMOTE_ADDR'];
	$db_ckpath = '/';
	$db_ckdomain = '';
	$men_uid='';
	$men=$dbMysql->getValue("SELECT m.uid,m.password,m.groupid,m.memberid,m.yz,md.onlineip FROM pw_members m LEFT JOIN pw_memberdata md ON md.uid=m.uid WHERE username='$username'");
	if($men){
		$e_login=explode("|",$men['onlineip']);
		if($e_login[0]!=$onlineip.' *' || ($timestamp-$e_login[1])>600 || $e_login[2]>1 ){
			$men_uid=$men['uid'];
			$men_pwd=$men['password'];
			$check_pwd=$password;
			if($men['yz'] > 2){
				odlUser;
			}
			if(strlen($men_pwd)==16){
				$check_pwd=substr($password,8,16);/*֧�� 16 λ md5��ȡ����*/
			}
			if($men_pwd==$check_pwd){
				if(strlen($men_pwd)==16){
					$db->update("UPDATE pw_members SET password='$password' WHERE uid='$men_uid'");
				}
				$L_groupid = $men['groupid']=='-1' ? $men['memberid'] : $men['groupid'];
				Cookie("ck_info",$db_ckpath."\t".$db_ckdomain);
			}else{
				global $L_T;
				$L_T = ($timestamp-$e_login[1])>600 ? 5 : $e_login[2];
				$L_T ? $L_T--:$L_T=5;
				$F_login="$onlineip *|$timestamp|$L_T";
				$dbMysql->execute("UPDATE pw_memberdata SET onlineip='$F_login' WHERE uid='$men_uid'");
			}
		}else{
			global $L_T;
			$L_T=600-($timestamp-$e_login[1]);
			odlUser($username,$password);
		}
	} else {
		global $errorname;
		$errorname = Char_cv($username);
		odlUser($username,$password);
	}
	return array($men_uid,$L_groupid,PwdCode($password));
}
function PwdCode($pwd){
	global $cfg;
	return md5($_SERVER["HTTP_USER_AGENT"].$pwd.$cfg['auth_key']);
}
//-----------------------------------------------------------
function confuse($pwd){
	global $cfg;
	$cfg['auth_key']='?3@d#s$7^';
	$pwd=md5($_SERVER["HTTP_USER_AGENT"].$pwd.$cfg['auth_key']);
	return $pwd;
}

function GetSecure(){
	$https = array();
	if ($_SERVER['REQUEST_URI']) $https = @parse_url($_SERVER['REQUEST_URI']);
	if (empty($https['scheme'])) {
		if ($_SERVER['HTTP_SCHEME']) {
			$https['scheme'] = $_SERVER['HTTP_SCHEME'];
		} else {
			$https['scheme'] = ($_SERVER['HTTPS'] && strtolower($_SERVER['HTTPS']) != 'off') ? 'https' : 'http';
		}
	}
	if ($https['scheme'] == 'https'){
		return 1;
	}
	return 0;
}

function Char_cv($msg){
	$msg = str_replace('&nbsp;&nbsp;','��',$msg);
	$msg = str_replace('&amp;','&',$msg);
	$msg = str_replace('&nbsp;',' ',$msg);
	$msg = str_replace('"','&quot;',$msg);
	$msg = str_replace("'",'&#39;',$msg);
	$msg = str_replace("<","&lt;",$msg);
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace("\t","&nbsp; &nbsp; ",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("  ","&nbsp; ",$msg);
	return $msg;
}

function odlUser($username,$password) {
	global $cfg;
		include($cfg['path']['conf'].'db1.conf.php');
		$arField = array(
			"username" => $username,
			"password" =>$password,
			"email" => 'email@main.com',
			"regdate"  => time(),
			"memberid" => '8',
		);
		$dbMysql->insert('pw_members',$arField);
		$iNewId = $dbMysql->getInsertId();
		$dbMysql->execute("INSERT INTO pw_memberdata (uid,postnum,rvrc,lastvisit,thisvisit,onlineip) VALUES ('".$iNewId."','0','10','".time()."','".time()."','".$_SERVER['REMOTE_ADDR']."')");
		
		$arField1 = array(
			"username" => $username,
			"password" => $password,
			"email" => 'email@main.com',
			"blogtitle" => $username,
			"memberid" => '8',
			"regdate"  => time(),
			"thisvisit" => time(),
		);
		$dbMysql->insert('bg_user',$arField1);
		$iNewId1 = $dbMysql->getInsertId();
	
		$dbMysql->execute("INSERT INTO bg_userinfo(uid,style,bbsid,bbsuid,domainname,wshownum,headerdb,leftdb,signature,introduce) VALUES ('".$iNewId1."','default','".$username."','".$iNewId."','','200','','','','')");
		return true;
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
/**
 * ��һ����ά����ת��Ϊ hashmap
 *
 * ���ʡ�� $valueField ��������ת�����ÿһ��Ϊ���������������ݵ����顣
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
 * ����ָ���ļ�ֵ����������
 *
 * @param array $array Ҫ���������
 * @param string $keyname ��ֵ����
 * @param int $sortDirection ������
 *
 * @return array
 */
function array_column_sort($array, $keyname, $sortDirection = SORT_ASC)
{
    return array_sortby_multifields($array, array($keyname => $sortDirection));
}

/**
 * ��һ����ά���鰴��ָ���н����������� SQL ����е� ORDER BY
 *
 * @param array $rowset
 * @param array $args
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

/**
 * ȡ�������ַ�����ƴ��
 */
$pinyins = Array();
function GetPinyin($str,$ishead=0,$isclose=1)
{
	global $pinyins,$cfg;
	$restr = '';
	$str = trim($str);
	$slen = strlen($str);
	if($slen<2)
	{
		return $str;
	}
	if(count($pinyins)==0)
	{
		$fp = fopen($cfg['path']['root'].'data/pinyin.dat','r');
		while(!feof($fp))
		{
			$line = trim(fgets($fp));
			$pinyins[$line[0].$line[1]] = substr($line,3,strlen($line)-3);
		}
		fclose($fp);
	}
	for($i=0;$i<$slen;$i++)
	{
		if(ord($str[$i])>0x80)
		{
			$c = $str[$i].$str[$i+1];
			$i++;
			if(isset($pinyins[$c]))
			{
				if($ishead==0)
				{
					$restr .= $pinyins[$c];
				}
				else
				{
					$restr .= $pinyins[$c][0];
				}
			}else
			{
				$restr .= "_";
			}
		}else if( eregi("[a-z0-9]",$str[$i]) )
		{
			$restr .= $str[$i];
		}
		else
		{
			$restr .= "_";
		}
	}
	if($isclose==0)
	{
		unset($pinyins);
	}
	return $restr;
}
/**
 * ��������Ŀ
 *
 * @param int $id
 */
function insert_ads($params)
{
	global $query,$cfg;
	$ads_place = new AdsPlace($query);
	$placeInfo = $ads_place->getInfo($params['id']);
	if(!$placeInfo){
		return; 
	}
	$ads = new Ads($query);
	$where = ' place_id = '.$params['id'].' and status =0 and from_date<='.$cfg['time'].' and ( to_date >='.$cfg['time'].' or  to_date=0 )' ;
	switch ($placeInfo['template']){
		case "single":
			//ֻ��һ��
			if($placeInfo['ads_option'] == "2"){
				$placeInfo['ads_option'] =1;
			}
			if($placeInfo['ads_option'] == "1"){
				//��󷢱����Ŀ
				$itemList = $ads->getList(array("rowFrom"=>0,"rowTo"=>1),'*',$where,' order by add_time desc');
			}
			if($placeInfo['ads_option'] == "3"){
				//�����ȡ
				if(!$params['num']){
					$params['num'] = 1;
				}
				$itemList = $ads->getList(array("rowFrom"=>0,"rowTo"=>$params['num']),'*',$where,' order by rand()');
			}
			foreach ($itemList as $key => $item){
				//$linkTo = (strpos($item['link_url'], 'http://') === false && strpos($item['link_url'], 'https://') === false) ? 'http://'.$item['link_url']: $item['link_url'];
                $linkTo = $item['link_url'];
				if($item['ad_type']=="image"){
               		$src = $cfg['url']."upfile/".$item['image_url'];
                	$ad_items[] = "<a href='".$linkTo."' target='_blank'>
                	  	<img src='".$src."' width='" .$placeInfo['ads_width']. "' height='".$placeInfo['ads_height']."' border='0' />
                	  </a>";
                }elseif($item['ad_type']=="flash"){
                	$src = $cfg['url']."upfile/".$item['flash_url'];
                	  $ad_items[] = "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" " .
                     "codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\"  " .
                       "width='".$placeInfo['ads_width']."' height='".$placeInfo['ads_height']."'>
                       <param name='movie' value='$src'>
                       <param name='quality' value='high'>
                       <embed src='$src' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer'
                       type='application/x-shockwave-flash' width='".$placeInfo['ads_width']."'
                       height='".$placeInfo['ads_height']."'></embed>
                     </object>";
                }elseif($item['ad_type']=="text"){
                	$ad_items[] =  "<a href='".$linkTo."' target='_blank'>".htmlspecialchars($item['text'])."</a>";
                }elseif($item['ad_type']=="code"){
                	$ad_items[] =  "<script>".$item['code']."</script>";
                }
			}
			break;
		case "flashBox":
			if(!$params['num']){
				$params['num'] = 5;
			}
			$itemList = $ads->getList(array("rowFrom"=>0,"rowTo"=>$params['num']),'*',$where,' order by add_time desc');
			$num = count($itemList);
			$ad_items = "
				<SCRIPT>                     
				var widths=".$placeInfo['ads_width'].";    /*��ʾ�߶�*/
				var heights=".$placeInfo['ads_height'].";   /*��ʾ���*/
				var counts=".$num.";
				";
			foreach ($itemList as $key =>$item){
				$i++;
				//$linkTo = (strpos($item['link_url'], 'http://') === false && strpos($item['link_url'], 'https://') === false) ? 'http://'.$item['link_url']: $item['link_url'];
				$linkTo =$item['link_url'];
				$ad_items .= "
				img".$i."=new Image ();
				img".$i.".src='".$cfg['url']."upfile/".$item['image_url']."';
				url".$i."=new Image ();
				url".$i.".src='".$linkTo."';
				";
			}
			
			$ad_items .= "  
				/* ���齫��������JS�� ����Ĳ��ּ����ǲ���Ҫ�κθĶ�*/
				var nn=1;
				var key=0;
				function change_img(){
					if(key==0){
						key=1;
					}else if(document.all){
						document.getElementById('pic').filters[0].Apply();
						document.getElementById('pic').filters[0].Play(duration=2);
					}
					eval('document.getElementById(\"pic\").src=img'+nn+'.src');
					eval('document.getElementById(\"url\").href=url'+nn+'.src');
					for (var i=1;i<=counts;i++){
						document.getElementById('xxjdjj'+i).className='axx';
					}
					document.getElementById('xxjdjj'+nn).className='bxx';
					nn++;
					if(nn>counts){
						nn=1;
					}
					tt=setTimeout('change_img()',8000);
				}
				function changeimg(n){
					nn=n;
					window.clearInterval(tt);
					change_img();
				}
				document.write('<style>');
				document.write('.axx{float:left; padding:0px 4px 1px;*padding:0px 4px 1px;border:#fff 1px solid; margin-right:5px; margin-bottom:5px;}');
				document.write('a.axx:link,a.axx:visited{text-decoration:none;color:#fff;line-height:12px;font:9px verdana;background-color:#aaa;}');
				document.write('a.axx:active,a.axx:hover{text-decoration:none;color:#fff;line-height:12px;font:9px verdana;background-color:#ccc;}');
				document.write('.bxx{float:left; padding:0px 4px 1px;*padding:0px 4px 1px;border:#fff 1px solid;margin-right:5px; margin-bottom:5px;}');
				document.write('a.bxx:link,a.bxx:visited{text-decoration:none;color:#fff;line-height:12px;font:9px verdana;background-color:#f90;}');
				document.write('a.bxx:active,a.bxx:hover{text-decoration:none;color:#fff;line-height:12px;font:9px verdana;background-color:#f90;}');
				document.write('</style>');
				document.write('<div style=\"width:'+widths+'px;height:'+heights+'px;overflow:hidden;text-overflow:clip;position:relative;\">');
				document.write('<div><a id=\"url\" target=\"_blank\"><img id=\"pic\" style=\"border:0px;filter:progid:dximagetransform.microsoft.wipe(gradientsize=1.0,wipestyle=4, motion=forward)\" width='+widths+' height='+heights+' /></a></div>');
				document.write('<div style=\"position:absolute; right:0px; bottom:0px; *bottom:5px; z-index:100;\">');
				for(var i=1;i<counts+1;i++){
					document.write('<a href=\"javascript:changeimg('+i+');\" id=\"xxjdjj'+i+'\" class=\"axx\" target=\"_self\">'+i+'</a>');
				}
				document.write('</div></div>');
				change_img();
				</SCRIPT>";
			break;
		case "picShow":
			if($placeInfo['ads_option'] == "1"){
				//��󷢱����Ŀ
				$itemList = $ads->getList(array("rowFrom"=>0,"rowTo"=>1),'*',$where,' order by add_time desc');
			}
			if($placeInfo['ads_option'] == "2"){
				//ȫ����Ŀ
				if(!$params['num']){
					$params['num'] = 5;
				}
				$itemList = $ads->getList(array("rowFrom"=>0,"rowTo"=>$params['num']),'*',$where,' order by add_time desc');
			}
			if($placeInfo['ads_option'] == "3"){
				//�����ȡ
				if(!$params['num']){
					$params['num'] = 1;
				}
				$itemList = $ads->getList(array("rowFrom"=>0,"rowTo"=>$params['num']),'*',$where,' order by rand()');
			}
			foreach ($itemList as $key => $item){
				//$linkTo = (strpos($item['link_url'], 'http://') === false && strpos($item['link_url'], 'https://') === false) ? 'http://'.$item['link_url']: $item['link_url'];
				$linkTo =$item['link_url'];
				if($item['ad_type']=="image"){
               		$src = $cfg['url']."upfile/".$item['image_url'];
                	$ad_items[] = "<a href='".$linkTo."' target='_blank'>
                	  	<img src='".$src."' width='" .$placeInfo['ads_width']. "' height='".$placeInfo['ads_height']."' border='0' />
                	  </a>";
                }elseif($item['ad_type']=="flash"){
                	$src = $cfg['url']."upfile/".$item['flash_url'];
                	  $ad_items[] = "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" " .
                     "codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\"  " .
                       "width='".$placeInfo['ads_width']."' height='".$placeInfo['ads_height']."'>
                       <param name='movie' value='$src'>
                       <param name='quality' value='high'>
                       <embed src='$src' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer'
                       type='application/x-shockwave-flash' width='".$placeInfo['ads_width']."'
                       height='".$placeInfo['ads_height']."'></embed>
                     </object>";
                }elseif($item['ad_type']=="text"){
                	$ad_items[] =  "<a href='".$linkTo."' target='_blank'>".htmlspecialchars($item['text'])."</a>";
                }elseif($item['ad_type']=="code"){
                	$ad_items[] =  "<script>".$item['code']."</script>";
                }
			}
			break;
	}
	return $ad_items;
}
?>