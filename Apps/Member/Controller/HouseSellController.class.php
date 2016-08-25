<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/24
 * Time: 下午2:03
 */
namespace Member\Controller;
use Think\Controller;
class HouseSellController extends CommonController{
    //出售管理
    public function index(){

    }

    //发布出售
    public function addSell(){
        $this->name = 'houseSale';
        //获得保存在cookie中的用户id
        $member_id = getAuthInfo('id');
        //关联查询
        $memberInfo=D('MemberRelation')->getInfo($member_id,'*',true);
        $this->assign('memberInfo',$memberInfo);
        //p($memberInfo);die;
        if($memberInfo['mobile']==""){
            $this->redirect(MODULE_NAME.'/',"请先完善你的资料，以便于购房者能够联系你");
        }
        if($page->memberOpen==2){
            if($memberInfo['status']=="1"){
                $this->redirect(MODULE_NAME.'/Index/index',"您的账户尚未开通");
            }
        }
        if(!$_GET['id']) {
                //取用户的分数
                $scores = getAuthInfo('scores');
                //根据分数来得出可发布的买卖房源
                $sellnum = getNumByScore($scores, C('RANK'), 'sell_num');

                //取用户已发房源
                $where = ' and broker_id = ' . $member_id;
                $where .= " and status =1 ";
                $sellCount = D('houseSellView')->getCount(1, $where);


                //比较房源数量
                if (getAuthInfo('vip') == 1) {
                    if ($page->vip1SaleNum <= $sellCount) {
                        $this->error('你正在出售的房源已经超过了' . $page->vip1SaleNum . '条，请把无效的房源删除后再发布新房源！');
                    }
                } elseif (getAuthInfo('vip') == 2) {
                    if ($page->vip2SaleNum <= $sellCount) {
                        $this->error('你正在出售的房源已经超过了' . $page->vip2SaleNum . '条，请把无效的房源删除后再发布新房源！');
                    }
                } else {
                    if ($sellnum + getAuthInfo('addsale') <= $sellCount) {//addsale是什么
                        $page->back('你正在出售的房源已经超过了' . $sellnum . '条，请把无效的房源下架后再发布新房源！');
                    }
                }
        }

        //房源类型
        $house_type_option =getArray('house_type');
        $this->assign('house_type_option', $house_type_option);
        //装修情况
        $house_fitment_option =getArray('house_fitment');
        $this->assign('house_fitment_option', $house_fitment_option);
        //房屋产权
        $belong_option =getArray('belong');
        $this->assign('belong_option', $belong_option);
        //房源特色
        $house_feature_option =getArrayGrouped('house_feature');
        $this->assign('house_feature_option', $house_feature_option);
        $house_feature_group = array(1=>"小区室内",2=>'地段周边',3=>'其它特色');
        $this->assign('house_feature_group', $house_feature_group);

        //区域，增加小区使用
        $cityarea_option =getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);
        //小区物业类型
        $borough_type_option =getArray('borough_type');
        $this->assign('borough_type_option', $borough_type_option);

        //房龄
        for($i = 1980; $i <= date('Y');$i++){
            $house_age_option[] = $i;
        }
        $this->assign('house_age_option', $house_age_option);

        //朝向
        $house_toward_option =getArray('house_toward');
        $this->assign('house_toward_option', $house_toward_option);

        $picture_num = 0;
        $dataInfo['house_feature'] = array();
        //编辑取数据
        if($_GET['id']){
            $id = intval($_GET['id']);
            $dataInfo=M('housesell')->where(array('id'=>$id))->find();
            //print_rr($dataInfo);
            $dataInfo['house_feature'] = explode(',',$dataInfo['house_feature']);
            array_remove_empty($dataInfo['house_feature'],true);
            //$dataInfo['house_installation'] = explode(',',$dataInfo['house_installation']);
            $dataInfo['house_pic']=M('housesell_pic')->where(array('housesell_id'=>$id))->select();
            $picture_num = count($dataInfo['house_pic']);
        }

        $this->assign('dataInfo', $dataInfo);
        $this->assign('to_url', $_SERVER['HTTP_REFERER']);
        $this->assign('picture_num', $picture_num);


        //p($dataInfo);die;
        $this->display();
    }

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
            echo '<html>';
            echo '<head>';
            echo '<title>上传成功</title>';
            echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=gb2312\">";
            echo '</head>';

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
                    try{

                        $upload->rootPath = $this_config['rootPath']; // 设置附件上传根目录
                        $upload->savePath = $this_config['originalPath']; // 设置附件上传（子）目录
                        $upload->saveName = $this_config['saveName'];//保存名称
                        $upload->autoSub = $this_config['autoSub'];//是否开启子目录



                        $info = $upload->uploadOne($a_file);
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
                        //回传参数
                        echo "<script>
					var parentForm;
					if(window.opener){
						parentForm = window.opener;
					}else{
						parentForm = window.parent;
					}
					parentForm.".$js_func."('".$f_path['url']."','".$f_path['name']."','".$thumb_path."');
				</script>";

                    }catch(Exception $e){
                        $this->error( $e->getMessage());
                    }
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
            echo "<form action='".U(MODULE_NAME.'/HouseSell/upload')."/to/".$to."/action/doupload"."' method='post' enctype='multipart/form-data'>";
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
     * 添加
     */
    public function save(){
        p($_POST);
    }






}