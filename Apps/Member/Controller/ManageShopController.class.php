<?php
/**
 * 店铺管理控制器
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/10
 * Time: 下午2:01
 */
namespace Member\Controller;
use Think\Controller;
class ManageShopController extends CommonController{
    /**
     * 店铺资料
     */
    public function shopProfile(){
        $page=$this;
        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $this->assign('member_id',$member_id);
        $shop = D('Shop');
        $action=I('get.action');
        $shop_name=I('shop_name');
        $shop_notice=I('shop_notice');
        $broker_id = $member_id;

        if($action == 'save'){
            try{
                if($shop->where(array('broker_id'=>$broker_id))->find()){
                    $updateField = array(
                        'shop_name'=>$shop_name,
                        'shop_notice'=>$shop_notice,
                    );
                    $broker_id=$shop->where(array('broker_id'=>$broker_id))->save($updateField);
                }else{
                    $insertField = array(
                        'broker_id'=>$broker_id,
                        'shop_name'=>$shop_name,
                        'shop_notice'=>$shop_notice,
                        'shop_style'=>'shopStyleDefault.css',
                        'created'=>time()
                    );
                    $broker_id=$shop->add($insertField);
                }

                jsurlto('保存成功',U(MODULE_NAME.'/ManageShop/shopProfile'));
            }catch (Exception $e){
                $this->error('保存出错');
            }

        }else{
            $shopConf = $shop->where(array('broker_id'=>$broker_id))->find();
            $this->assign('dataInfo',$shopConf);
        }
        $this->display();

    }

    /**
     * 店铺diy
     */
    public function shopDiy(){
        $page=$this;
        $member=D('MemberView');
        $member_id=$member->getAuthInfo('id');
        $action=I('get.action');
        $banner=I('banner');
        $background=I('background');
        if($action == 'save') {
            try {
                if ($banner) {

                    //D('MemberRelation')->relation(true)->where(array('id'=>$member_id))->save(array('broker_info'=>array('banner'=>$banner)));
                    M('broker_info')->where(array('id'=>$member_id))->save(array('banner'=>$banner));
                }
                if ($background) {
                    //D('MemberRelation')->relation(true)->where(array('id'=>$member_id))->save(array('broker_info'=>array('background'=>$background)));
                    M('broker_info')->where(array('id'=>$member_id))->save(array('background'=>$background));

                }
                jsurlto('上传成功',U(MODULE_NAME.'/ManageShop/shopDiy'));
            } catch (Exception $e) {
                $this->error("上传失败");
            }
            exit;
        }else{
            $memberInfo = $member->getInfo($member_id,'*',true);
            $this->assign('memberInfo',$memberInfo);
        }
        $this->display();

    }

    /**
     * webupload框架
     */
    public function webuploader(){
        $this->display();
    }

    /**
     * 商铺管理上传
     */
    public function upload(){
        $action = $_GET['action'];
        $to=I('get.to');

        if($action==""){
            $action = "form";
        }
        if($action=="doupload") {


            $store_info = explode('|', $to);
            $js_func = $store_info[0];
            //p($js_func);die;

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

		</script>";
            }
            echo '</body>';
            echo '</html>';


        }elseif($action=="form"){
            //$this->to=$to;
            //$this->display('webuploader');
            echo '<html>';
            echo '<head>';
            echo "<script src='".__ROOT__."/Public/js/jquery.min.js'></script>";
            echo "<script src='".__ROOT__."/Public/js/webupload/webuploader.js'></script>";
            echo "<link rel=\"stylesheet\" type=\"text/css\" href='".__ROOT__."/Public/js/webupload/webuploader.css'/>";

            echo '<title>上传文件</title>';
            echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
            echo '</head>';
            echo "<body leftmargin=\"0\" topmargin=\"0\">";
            echo '<div id="uploader-demo">';
            echo "<div id=\"fileList\" class=\"uploader-list\"></div>";
            echo "<div id=\"filePicker\">多张上传</div>";
            echo "</div>";
            echo "<script>
            var uploader = WebUploader.create({
                auto: true,
                swf:'".__ROOT__."/Public/js/webupload/Uploader.swf',
                server: '".U(MODULE_NAME.'/HouseRent/upload')."/action/doupload/to/".$to."',
                pick: '#filePicker',
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }

            });

            uploader.on( 'fileQueued', function( file ) {
                var li = $(
                                '<div id=\"' + file.id + '\" class=\"file-item thumbnail\">' +
                                '</div>'
                        )


                var list=$('#fileList');
                list.append( li );


            });

            uploader.on( 'uploadProgress', function( file, percentage ) {
                var li = $( '#'+file.id ),
                        percent = li.find('.progress span');

                if ( !percent.length ) {
                    percent = $('<p class=\"progress\"><span class=\"progress-bar\"></span></p>')
                            .appendTo( li )
                            .find('span');
                }

                percent.css( 'width', percentage * 100 + '%' );
            });
            uploader.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).remove();
            });





</script>";
            echo "</body>";
            echo '</html>';

        }
    }

    /**
     * 店铺出售推荐
     */
    public function shopSaleRec(){
        //$page=$this;
        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $houseSell = D("HouseSellView");
        $houseRent = D("HouseRentView");

        $where = ' and broker_id = '.$member_id;
        $where .=" and status = 1";
        $where .=" and is_promote = 1";
        $houseNum = $houseSell->getCount(0,$where);//几条推荐房源
        $this->assign('houseNum',$houseNum);//总共多少条
        $allowNum = 4;
        $houseLeft= $allowNum -$houseNum;
        $this->assign('houseLeft',$houseLeft);
        $action=I('get.action');

        if($action=='promote'){//推荐到橱窗
            if($houseLeft <=0){
                $this->error("橱窗已满");
            }

            $ids = I('id',0,'intval');
            if(!is_array($ids)) $ids=array($ids);//此处用不到为批量做准备
            //p($ids);die;
            foreach($ids as $id){
                if($houseLeft <=0){
                    $this->error("橱窗已满");
                }
                $houseSell->where(array('id'=>$id))->setField('is_promote',1);
                $houseLeft--;
            }
            $this->redirect(MODULE_NAME.'/ManageShop/shopSaleRec');
        }elseif($action=='cancel'){//取消橱窗推荐

            $ids = I('id',0,'intval');
            if(!is_array($ids)) $ids=array($ids);
            foreach($ids as $id){
                $houseSell->where(array('id'=>$id))->setField('is_promote',2);
            }
            $this->redirect(MODULE_NAME.'/ManageShop/shopSaleRec');


        }else{//模板

            //判断是否认证
            $memberInfo = $member->getInfo($member_id,'*',true);
            $this->assign('memberInfo',$memberInfo);
            $where = ' and broker_id = '.$member_id;
            //这里显示状态为1（正在出售）的房源
            $where .=" and status = 1";
            $q = $_GET['q']=='输入房源编号或小区名称'?"":trim($_GET['q']);
            if($q){
                $borough =D('BoroughView');
                $search_bid = $borough->getFields('id',' borough_name like \'%'.$q.'%\'');
                if($search_bid){
                    $search_bid = implode(',',$search_bid);
                    $where .= " and (borough_name like '%".$q."%' or house_no like '%".$q."%' or borough_id in (".$search_bid."))";
                }else{
                    $where .= " and (borough_name like '%".$q."%' or house_no like '%".$q."%')";
                }
            }
            $this->assign('q', $q);
            if($_GET['is_promote']){
                $is_promote = intval($_GET['is_promote']);
                $where .= " and is_promote = ".$is_promote;
            }

            $count=$houseSell->getCount(0, $where);
            $Page = new \Think\Page($count,5);//分页类
            //分页样式
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $show = $Page->show();// 分页显示输出
            $dataList=D('HouseSellRelation')->relation(true)->where('1=1'.$where)->limit($Page->firstRow.','.$Page->listRows)->order('created desc')->select();
            foreach ($dataList as $key => $value){
                //echo date("Y-m-d" ,$value['created']);
                $dataList[$key]['day_left'] = intval(($value['created'] - time() )/86400+90);
            }

            $this->assign('to_url', $_SERVER['REQUEST_URI']);
            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $show);//分页条
        }


        $this->display();
    }

    /**
     * 店铺出租推荐
     */
    public function shopRentRec(){

        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $houseSell = D("HouseSellView");
        $houseRent = D("HouseRentView");

        $where = ' and broker_id = '.$member_id;
        $where .=" and status = 1";
        $where .=" and is_promote = 1";
        $houseNum = $houseRent->getCount(0,$where);//几条推荐房源
        $this->assign('houseNum',$houseNum);//总共多少条
        $allowNum = 4;
        $houseLeft= $allowNum -$houseNum;
        $this->assign('houseLeft',$houseLeft);
        $action=I('get.action');

        if($action=='promote'){//推荐到橱窗
            if($houseLeft <=0){
                $this->error("橱窗已满");
            }

            $ids = I('id',0,'intval');
            if(!is_array($ids)) $ids=array($ids);//此处用不到为批量做准备
            //p($ids);die;
            foreach($ids as $id){
                if($houseLeft <=0){
                    $this->error("橱窗已满");
                }
                $houseRent->where(array('id'=>$id))->setField('is_promote',1);
                $houseLeft--;
            }
            $this->redirect(MODULE_NAME.'/ManageShop/shopRentRec');
        }elseif($action=='cancel'){//取消橱窗推荐

            $ids = I('id',0,'intval');
            if(!is_array($ids)) $ids=array($ids);
            foreach($ids as $id){
                $houseRent->where(array('id'=>$id))->setField('is_promote',2);
            }
            $this->redirect(MODULE_NAME.'/ManageShop/shopRentRec');


        }else{//模板

            //判断是否认证
            $memberInfo = $member->getInfo($member_id,'*',true);
            $this->assign('memberInfo',$memberInfo);
            $where = ' and broker_id = '.$member_id;
            //这里显示状态为1（正在出售）的房源
            $where .=" and status = 1";
            $q = $_GET['q']=='输入房源编号或小区名称'?"":trim($_GET['q']);
            if($q){
                $borough =D('BoroughView');
                $search_bid = $borough->getFields('id',' borough_name like \'%'.$q.'%\'');
                if($search_bid){
                    $search_bid = implode(',',$search_bid);
                    $where .= " and (borough_name like '%".$q."%' or house_no like '%".$q."%' or borough_id in (".$search_bid."))";
                }else{
                    $where .= " and (borough_name like '%".$q."%' or house_no like '%".$q."%')";
                }
            }
            $this->assign('q', $q);
            if($_GET['is_promote']){
                $is_promote = intval($_GET['is_promote']);
                $where .= " and is_promote = ".$is_promote;
            }

            $count=$houseRent->getCount(0, $where);
            $Page = new \Think\Page($count,5);//分页类
            //分页样式
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $show = $Page->show();// 分页显示输出
            $dataList=D('HouseRentRelation')->relation(true)->where('1=1'.$where)->limit($Page->firstRow.','.$Page->listRows)->order('created desc')->select();
            foreach ($dataList as $key => $value){
                //echo date("Y-m-d" ,$value['created']);
                $dataList[$key]['day_left'] = intval(($value['created'] - time() )/86400+90);
            }

            $this->assign('to_url', $_SERVER['REQUEST_URI']);
            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $show);//分页条
        }

        $this->display();

    }
}