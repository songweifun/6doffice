<?php
	/* Note: This thumbnail creation script requires the GD PHP Extension.  
		If GD is not installed correctly PHP does not render this page correctly
		and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
	 */	
	 // Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}

	session_start();
	ini_set("html_errors", "0");
	
require('../../../path.inc.php');
$to =$_GET['to'];
$action = $_GET['action'];
if($action==""){
	$action = "form";
}
	
	$store_info = explode('|',$to);
	$js_func = $store_info[0];

	/*  判断特殊字符 */
	if($store_info[1]){
		if(!ereg("^[A-Za-z]+$",$store_info[1])){
			exit;
		}
	}
	if($store_info[2]){
		if(!ereg("^[A-Za-z]+$",$store_info[2])){
			exit;
		}
	}

	$upload_conf = require($cfg['path']['conf'].'upload.cfg.php');
	
	$this_config = (array)$upload_conf[$store_info[1]][$store_info[2]];
	if(empty($this_config)){
		exit;
	}
	$upload = new UploadFile();//实例化上传对象
	//设置可以上传文件的类型
	$upload->setAllowFileType($this_config['allowType']);

	foreach ($_FILES as $a_file){
	
			try{
				$fileName = $upload->upload($a_file,$cfg['path']['root'].'upfile/'.$this_config['originalPath'], 1);

	
				$f_path['url'] = $this_config['originalPath'].$fileName;
				$f_path['name'] = $a_file['name'];
				$attach_file[] = $f_path;
				if(in_array(strtolower(FileSystem::fileExt($f_path['name'])),array('gif','jpeg','jpg','png')) && !$this_config['noResize']){
					//先缩略到指定大小
					$image = new Image($cfg['path']['root'].'upfile/'.$this_config['originalPath'].$fileName);
					$image->resizeImage($this_config['width'],$this_config['height'],$this_config['resizeType']);
					$image->save();
					//加水印
					if($this_config['watermark']){
						$image = new Image($cfg['path']['root'].'upfile/'.$this_config['originalPath'].$fileName);
						$image->waterMark($this_config['watermarkPic'],$this_config['watermarkPos']);
						$image->save();
					}
					//如果需要再生成缩略图
					if($this_config['thumb']){
						$image = new Image($cfg['path']['root'].'upfile/'.$this_config['originalPath'].$fileName);
						$image->resizeImage($this_config['thumbWidth'],$this_config['thumbHeight'],$this_config['thumbResizeType']);
						if($this_config['originalPath']==$this_config['thumbDir']){
							//防止存储目录相同时覆盖原有的图片，不存储缩略图直接设置 thumb 属性为空
							$image->save(2,$cfg['path']['root'].'upfile/'.$this_config['thumbDir'],'_thumb');
							$thumb_path = $this_config['thumbDir'].FileSystem::getBasicName($fileName, false).'_thumb'.FileSystem::fileExt($fileName, true);
						}else{
							$image->save(1,$cfg['path']['root'].'upfile/'.$this_config['thumbDir']);
							$thumb_path = $this_config['thumbDir'].$fileName;
						}
					}
				}

				// Check the upload

	if (!isset($_SESSION["file_info"])) {
		$_SESSION["file_info"] = array();
	}
	
	$fileName = md5($fileName) . ".jpg";
	$file_id = md5(rand()*10000000);
	$_SESSION["file_info"][$file_id] = $fileName;					//回传参数

			}catch(Exception $e){
				$page->back( $e->getMessage());
			}
		
	}

	 echo "FILEID:" . $file_id."||".$f_path['url']."||".$f_path['name']."||".$thumb_path;
	
		// Return the file id to the script
	
?>