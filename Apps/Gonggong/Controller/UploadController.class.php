<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 上午10:13
 */
namespace Gonggong\Controller;
use Think\Controller;
class UploadController extends Controller{
    /**
     * 文件上传
     */
    public function upload(){

        $to = $_GET["to"];
        $action = $_GET['action'];
        if($action==""){
            $action = "form";
        }
        if($action=="doupload") {


            $store_info = explode('|', $to);
            $js_func = $store_info[0];

            /*  判断特殊字符 */
            if ($store_info[1]) {
                if (!ereg("^[A-Za-z]+$", $store_info[1])) {
                    exit;
                }
            }
            if ($store_info[2]) {
                if (!ereg("^[A-Za-z]+$", $store_info[2])) {
                    exit;
                }
            }
            //载入所有上传和图形处理类的配置文件
            $upload_conf = C('UPLOADCONF');
            $this_config = (array)$upload_conf[$store_info[1]][$store_info[2]];
            if(empty($this_config)){
                exit;
            }

            $upload = new \Think\Upload();// 实例化上传类
            $upload->exts=$this_config['exts'];

            foreach ($_FILES as $a_file){
                if($a_file['error']!=UPLOAD_ERR_NO_FILE) {


                    $upload->rootPath = $this_config['rootPath']; // 设置附件上传根目录
                    $upload->savePath = $this_config['originalPath']; // 设置附件上传（子）目录
                    $upload->saveName = $this_config['saveName'];//保存名称
                    $upload->autoSub = $this_config['autoSub'];//是否开启子目录



                    if($info = $upload->uploadOne($a_file)){
                        //echo "<script> alert('上传成功!'); </script>";
                    }else{
                        echo "<script> alert('".$upload->getError()."'); history.back();</script>";
                    }
                    $fileName=$info['savename'];
                    $f_path['url'] = $this_config['originalPath'].$fileName;
                    $f_path['name'] = $a_file['name'];
                    $attach_file[] = $f_path;
                    import('Class.FileSystem',APP_PATH);
                    //require('./Apps/Class/FileSystem.class.php');
                    $parm=in_array(strtolower(\FileSystem::fileExt($f_path['name'])),array('gif','jpeg','jpg','png'));
                    //var_dump($parm);die;
                    if( $parm && !$this_config['noResize']){
                        //先缩略到指定大小
                        $image = new \Think\Image();
                        $image->open('./Uploads/'.$this_config['originalPath'].$fileName);
                        $image->thumb($this_config['width'], $this_config['height'],$this_config['resizeType'])->save('./Uploads/'.$this_config['originalPath'].$fileName);
                        //加水印
                        if($this_config['watermark']){
                            $image = new \Think\Image();
                            $image->open('./Uploads/'.$this_config['originalPath'].$fileName);
                            $image->water($this_config['watermarkPic'],$this_config['watermarkPos'])->save('./Uploads/'.$this_config['originalPath'].$fileName);
                        }
                        //如果需要再生成缩略图
                        if($this_config['thumb']){
                            $image = new \Think\Image();
                            $image->open('./Uploads/'.$this_config['originalPath'].$fileName);
                            $image->thumb($this_config['thumbWidth'], $this_config['thumbHeight'],$this_config['thumbResizeType']);
                            if($this_config['originalPath']==$this_config['thumbDir']){
                                //防止存储目录相同时覆盖原有的图片，不存储缩略图直接设置 thumb 属性为空
                                $image->save('./Uploads/'.$this_config['thumbDir'].\FileSystem::getBasicName($fileName, false).'_thumb'.\FileSystem::fileExt($fileName, true));
                                $thumb_path = $this_config['thumbDir'].\FileSystem::getBasicName($fileName, false).'_thumb'.\FileSystem::fileExt($fileName, true);
                            }else{
                                $image->save('./Uploads/'.$this_config['thumbDir'].$fileName);
                                $thumb_path = $this_config['thumbDir'].$fileName;
                            }
                        }
                    }
                    if($js_func=='uploadHousePicture'){
                        $file_id = md5(rand()*10000000);
                        echo "FILEID:" . $file_id."||".$f_path['url']."||".$f_path['name']."||".$thumb_path;
                        return;

                    }
                    echo '<html>';
                    echo '<head>';
                    echo '<title>上传成功</title>';
                    echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=gb2312\">";
                    echo '</head>';
                    //回传参数
                    echo "<script>
					var parentForm;
					if(window.opener){
						parentForm = window.opener;
					}else{
						parentForm = window.parent;
					}
					parentForm." . $js_func . "('" . $f_path['url'] . "','" . $f_path['name'] . "','" . $thumb_path . "');
				</script>";



                }else{
                    echo "<script>
					alert('请先浏览文件后点击上传');
					history.back();
			</script>";
                    exit;
                }
                echo "<script>
			/*if(window.opener){
				window.close();
			}else{
				history.back();
			}*/
			history.back();
		</script>";
            }
            echo '</body>';
            echo '</html>';


        }elseif($action=="form"){
            echo '<html>';
            echo '<head>';
            echo '<title>上传文件</title>';
            echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
            echo '</head>';
            echo "<body leftmargin=\"0\" topmargin=\"0\">";
            echo "<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" height=\"100%\" align=\"left\">";
            echo "<form action='".U(MODULE_NAME.'/Upload/upload')."/to/".$to."/action/doupload"."' method='post' enctype='multipart/form-data'>";
            echo "<tr ><td  valign='middle'>";
            echo "<input type='file' name='uploadfile'>";
            echo "<input name='submit' type='submit' value='上传'>";
            echo "</td></tr>";
            echo "</form>";
            echo "</table";
            echo "</body>";
            echo '</html>';
        }





    }
    /**
     * ajax查询数据
     */
    public function ajax(){
        //echo "[a,b,c,d,e,fa,jac]";
        $member_id = getAuthInfo('id');
        if(I('action')=='getBoroughList'){
            $borough = M('borough');
            $_GET["q"] = charsetIconv($_GET["q"]);
            $q = strtolower($_GET["q"]);
            if (!$q) return;
            $where['borough_name']=array('like','%'.$q.'%');
            $where['borough_letter']=array('like','%'.$q.'%');
            $where['borough_alias']=array('like','%'.$q.'%');
            $where['_logic'] = 'OR';
            $map['_complex']=$where;
            $map['isdel']=array('neq',1);
            $datalist=$borough->field('id,borough_name,borough_address')->where($map)->select();
            //$this->ajaxReturn($datalist,'jsonp');
            //p($datalist);
            $str = "";
            foreach ($datalist as $key=>$value) {
                $boroughImageList = D('Borough')->getImgList($value['id'],1);//获取小区户型图
                //p($boroughImageList);
                foreach ($boroughImageList as $k=>$v) {
                    $datalist[$key]['info'][$k]['pic_thumb']=$v['pic_thumb'];
                    $datalist[$key]['info'][$k]['pic_url']=$v['pic_url'];
                    $datalist[$key]['info'][$k]['pic_desc']=$v['pic_desc'];
                }
                //echo $pic_thumb;没用
                if($value['borough_alias']){
                    //$str .= $value['borough_name'].'('.$value['borough_alias'].')'."|".$value['id']."|".$value['borough_address']."\n";
                    $str .= $value['borough_name']."|".$value['id']."|".$value['borough_address']."|".$pic_thumb."|".$pic_url."|".$pic_desc."\n";
                }else{
                    $str .= $value['borough_name']."|".$value['id']."|".$value['borough_address']."|".$pic_thumb."|".$pic_url."|".$pic_desc."\n";
                }
            }

            $str .= "我要创建新小区|addBorough|addBorough\n";
            //echo $str;
            //p($datalist);
            $datalist[]['borough_name']='我要创建新小区';
            //p($datalist);die();
            $this->ajaxReturn($datalist,'jsonp');





        }elseif(I('action')=='getMemberList'){
            $member=D('MemberView');
            $_GET["q"] = charsetIconv($_GET["q"]);
            $q = strtolower($_GET["q"]);
            if (!$q) return;
            $where['username']=array('like','%'.$q.'%');
            $where['email']=array('like','%'.$q.'%');
            $where['realname']=array('like','%'.$q.'%');
            $where['mobile']=array('like','%'.$q.'%');
            $where['_logic'] = 'OR';
            $map['_complex']=$where;
            $map['status']=array('eq',0);
            $datalist=$member->field('id,realname')->where($map)->select();
            $this->ajaxReturn($datalist,'jsonp');


        }//else if
    }

    /**
     * 添加小区
     */
    public function addBorough(){

        header('content-Type: text/html; charset=utf8');

        $member_id =getAuthInfo('id');
        $borough = M('borough');
        $action=I('action');

        if($action == 'save'){
            //保存在ajax页面
        }else{
            //区域，增加小区使用
            $cityarea_option =getArray('cityarea');
            $this->assign('cityarea_option', $cityarea_option);
            //小区物业类型
            $borough_type_option = getArray('borough_type');
            $this->assign('borough_type_option', $borough_type_option);
        }


        $this->display();
    }
}