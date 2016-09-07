<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/6
 * Time: 下午5:56
 */
namespace Member\Controller;
use Think\Controller;
class HouseRentController extends CommonController{
    /**
     * 租赁列表
     */
    public function index(){

    }

    /**
     * 发布租赁
     */
    public function addRent(){

        $page=$this;//引入page配置项
        $member_id = getAuthInfo('id');
        $houseRent = D('HouseRentRelation');
        $member=D('MemberView');
        //判断用户是不是通过认证等
        $memberInfo = $member->getInfo($member_id,'*',true);
        //p($memberInfo);die;
        $this->assign('memberInfo',$memberInfo);
        if($memberInfo['mobile']==""){
            $this->error("请先完善你的资料，以便于购房者能够联系你");
        }

        if($page->memberOpen==2){//是否开通免费经纪人注册 1：是  2：不是
            if($memberInfo['status']=="1"){
                $this->error("您的账户尚未开通！");
            }
        }

        //新增加的，判断是否超过了 数量
        if(!$_GET['id']){
            //取用户的分数
            $scores = $member->getAuthInfo('scores');
            //取积分配置情况
            $rent_num = getNumByScore($scores, C('RANK'), 'rent_num');
            //取用户已发房源
            $where = ' and broker_id = '.$member_id;
            $where .=" and status = 1";
            $rentCount = D('HouseRentView')->getCount(1,$where);
            //比较房源数量
            if($member->getAuthInfo('vip')==1){
                if($page->vip1RentNum <= $rentCount ){
                    $this->error('你正在出租的房源已经超过了'.$page->vip1RentNum.'条，请把无效的房源删除后再发布新房源！');
                }
            }elseif($member->getAuthInfo('vip')==2){
                if($page->vip2RentNum <= $rentCount ){
                    $this->error('你正在出租的房源已经超过了'.$page->vip2RentNum.'条，请把无效的房源删除后再发布新房源！');
                }
            }else{
                if($rent_num+$member->getAuthInfo('addrent') <= $rentCount ){
                    $this->error('你正在出租的房源已经超过了'.$rent_num.'条，请把无效的房源下架后再发布新房源！');
                }
            }
        }//if id end

        //房源类型
        $house_type_option = getArray('house_type');
        $this->assign('house_type_option', $house_type_option);

        //装修情况
        $house_fitment_option =getArray('house_fitment');
        $this->assign('house_fitment_option', $house_fitment_option);
        //压付方式
        $rent_deposittype_option =getArray('rent_deposittype');
        $this->assign('rent_deposittype_option', $rent_deposittype_option);
        //房源特色
        $house_feature_option = getArrayGrouped('rent_feature');
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

        //配套
        $house_installation_option = getArray('house_installation');
        $this->assign('house_installation_option', $house_installation_option);
        //朝向
        $house_toward_option = getArray('house_toward');
        $this->assign('house_toward_option', $house_toward_option);

        $picture_num = 0;
        $dataInfo['house_feature'] = array();
        $dataInfo['house_support'] = array();

        //编辑取数据
        if($_GET['id']){
            $id = I('id',0,'intval');
            $dataInfo=M('houserent')->where(array('id'=>$id))->find();
            $dataInfo['house_feature'] = explode(',',$dataInfo['house_feature']);
            array_remove_empty($dataInfo['house_feature'],true);
            $dataInfo['house_support'] = explode(',',$dataInfo['house_support']);
            array_remove_empty($dataInfo['house_support'],true);
            $dataInfo['house_pic'] = M('houserent_pic')->where(array('houserent_id'=>$id))->select();
            $picture_num = count($dataInfo['house_pic']);
        }

        $this->assign('dataInfo', $dataInfo);
        $this->assign('to_url', $_SERVER['HTTP_REFERER']);
        $this->assign('picture_num', $picture_num);




        $this->display();

    }


    /**
     * 百度编辑器上传
     */
    public function ueditorUpload()
    {
        date_default_timezone_set("Asia/chongqing");
        error_reporting(E_ERROR);
        header("Content-Type: text/html; charset=utf-8");

        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("./Data/Ueditor/php/config.json")), true);
        $action = $_GET['action'];
        switch ($action) {
            case 'config':
                $result =  json_encode($CONFIG);
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */


                //载入所有上传和图形处理类的配置文件
                $upload_conf = C('UPLOADCONF');
                import('Class.FileSystem',APP_PATH);
                $this_config = (array)$upload_conf['ueditor']['rent'];
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


                        if($info = $upload->uploadOne($a_file)) {
                            $fileName = $info['savename'];// 文件保存名称
                            $f_path['url'] = $this_config['originalPath'] . $fileName;
                            $f_path['name'] = $a_file['name'];//原文件名称

                            if (!$this_config['noResize']) {
                                //先缩略到指定大小
                                $image = new \Think\Image();
                                $image->open('./Uploads/' . $this_config['originalPath'] . $fileName);
                                $image->thumb($this_config['width'], $this_config['height'], $this_config['resizeType'])->save('./Uploads/' . $this_config['originalPath'] . $fileName);
                                //加水印
                                if ($this_config['watermark']) {
                                    $image = new \Think\Image();
                                    $image->open('./Uploads/' . $this_config['originalPath'] . $fileName);
                                    $image->water($this_config['watermarkPic'], $this_config['watermarkPos'])->save('./Uploads/' . $this_config['originalPath'] . $fileName);
                                }
                                //如果需要再生成缩略图
                                if ($this_config['thumb']) {
                                    $image = new \Think\Image();
                                    $image->open('./Uploads/' . $this_config['originalPath'] . $fileName);
                                    $image->thumb($this_config['thumbWidth'], $this_config['thumbHeight'], $this_config['thumbResizeType']);
                                    if ($this_config['originalPath'] == $this_config['thumbDir']) {
                                        //防止存储目录相同时覆盖原有的图片，不存储缩略图直接设置 thumb 属性为空
                                        $image->save('./Uploads/' . $this_config['thumbDir'] . \FileSystem::getBasicName($fileName, false) . '_thumb' . \FileSystem::fileExt($fileName, true));
                                        $thumb_path = $this_config['thumbDir'] . \FileSystem::getBasicName($fileName, false) . '_thumb' . \FileSystem::fileExt($fileName, true);
                                    } else {
                                        $image->save('./Uploads/' . $this_config['thumbDir'] . $fileName);
                                        $thumb_path = $this_config['thumbDir'] . $fileName;
                                    }
                                }
                            }

                            $result=json_encode(array(
                                "state"=>"SUCCESS",
                                "url"=>__ROOT__.'/Uploads/'.$thumb_path,
                                'title'=>$fileName,
                                'original'=>$f_path['name'],
                                'type'=>\FileSystem::fileExt($f_path['name']),
                                'size'=>$info['size'],
                            ));
                        }else{

                            $result=json_encode(array(
                                'state'=>$upload->getError()
                            ));

                        }

                    }

                }


                break;
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = include("action_upload.php");
                break;

            /* 列出图片 */
            case 'listimage':
                $result = include("action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
                $result = include("action_list.php");
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = include("action_crawler.php");
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         * */
    }

    public function save(){
        p($_POST);
    }
}