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
        $page=$this;
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
            //echo $sellCount;die;


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
                        $this->error('你正在出售的房源已经超过了' . $sellnum . '条，请把无效的房源下架后再发布新房源！');
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
                //echo $pic_thumb;
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





        }//if
    }


    /**
     * 添加小区
     */
    public function addBorough(){

        header('content-Type: text/html; charset=utf8');

        $member_id =getAuthInfo('id');
        $borough = M('borough');
        $page->$this;
        $action=I('action');

        if($action == 'save'){
            //保存在ajax页面
        }else{
            $page->name = 'addBorough';
            //区域，增加小区使用
            $cityarea_option =getArray('cityarea');
            $this->assign('cityarea_option', $cityarea_option);
            //小区物业类型
            $borough_type_option = getArray('borough_type');
            $this->assign('borough_type_option', $borough_type_option);
        }


        $this->display();
    }


    /**
     * 添加
     */
    public function save(){
        $member_id = getAuthInfo('id');
        $data=array();
        $broker_id=$member_id;
        $creater=getAuthInfo('username');
        $company_id=getAuthInfo('company_id');//将房源和公司联系起来
        $borough_id=I('borough_id',null,'intval');
        $borough_name=I('borough_name');
        //特殊处理,只转递过来小区名字没有小区ID，那是由于用户直接输入小区名字没有选择下拉列表
        if(!$borough_id){
            $borough_id=D('Borough')->getInfo(array('borough_name'=>$borough_name),'id');
            if(!$borough_id) $this->error('没有搜索到相关的小区，请确认你的小区名称');
            $cityarea_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea_id');
            $cityarea2_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea2_id');

        }else{
            $cityarea_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea_id');
            $cityarea2_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea2_id');
            //echo $cityarea_id;

        }

        //房源特色，前后加，号便于搜索匹配
        if(I('house_feature')){
            $house_feature = ','.implode(',',I('house_feature')).',';
        }
        $field_array  = array(
            'house_title'=>I('house_title'),
            'cityarea_id'=>$cityarea_id,
            'cityarea2_id'=>$cityarea2_id,
            'house_type'=>I('house_type'),
            'house_price'=>I('house_price',0,'intval'),
            'house_totalarea'=>I('house_totalarea',0,'intval'),
            'house_room'=>I('house_room',0,'intval'),
            'house_hall'=>I('house_hall',0,'intval'),
            'house_toilet'=>I('house_toilet',0,'intval'),
            'house_veranda'=>I('house_veranda',0,'intval'),//阳台
            'video'=>I('video'),
            'house_topfloor'=>I('house_topfloor',0,'intval'),
            'house_floor'=>I('house_floor',0,'intval'),
            'house_age'=>I('house_age'),
            'house_toward'=>I('house_toward'),
            'house_fitment'=>I('house_fitment'),
            'house_feature'=>I('house_feature'),
            'house_desc'=>I('house_desc'),
            'borough_id'=>$borough_id,
            'borough_name'=>$borough_name,
            'broker_id'=>$broker_id,
            'belong'=>I('belong',0,'intval'),
            'owner_name'=>I('owner_name'),
            'owner_phone'=>I('owner_phone'),
            'owner_notes'=>I('owner_notes'),
            'is_vexation' =>I('vexation'),
            'company_id' =>$company_id,
        );
        //当不是编辑时 * 减少加急房源条数
        if ( !I('id') && I('vexation') == 1 )
        {
            //M('member')->where(array('id'=>$broker_id))->setDec('vexation',1);
        }

        //取图片第一张作为房源缩略图
        $house_picture_thumb=I('house_picture_thumb');
        if($house_picture_thumb[0]){
            $field_array['house_thumb'] =$house_picture_thumb[0];
        }

        if(I('id')){
            //编辑
            //$field_array['drawing_id'] = I('drawing_id');
            if($broker_id == 0){
                $field_array['is_checked'] = I('is_checked');
            }
            $field_array['updated']=time();
            $house_id= I('id',0,'intval');
            $houseInfo=M('housesell')->field('house_drawing,created')->where(array('id'=>$house_id))->find();
            //编辑今天的房源计算时间
            $today = mktime(0,0,0,date('m'),date('d'),date('Y'));
            if($houseInfo['created']>$today){
                $field_array['update_order']=time()+14400;
            }else{
                $field_array['update_order']=time();
            }

            /*
            if($houseInfo['house_drawing'] != $fileddata['house_drawing']){
                //把户型图插入到小区中去
                $insert_drawing = array(
                    'pic_url'=>$fileddata['house_drawing'],
                    'pic_thumb'=>$fileddata['house_drawing_thumb'],
                    'pic_desc'=>$fileddata['house_drawing_desc'],
                    'borough_id'=>$fileddata['borough_id'],
                    'creater'=>$fileddata['creater'],
                    'addtime'=>$cfg['time'],
                );
                $field_array['drawing_id'] = $borough->insertDrawing($insert_drawing);
                $field_array['house_drawing'] = $fileddata['house_drawing'];
            }
            */
            $field_array['house_drawing'] = I('house_drawing');

            //$this->db->update($this->tName,$field_array,'id = '.$house_id);
            //$this->db->execute('delete from '.$this->tNamePic.' where housesell_id ='.$house_id);
            //插入房源图片
            $house_picture_url=I('house_picture_url');
            $house_picture_thumb=I('house_picture_thumb');
            $house_picture_desc=I('house_picture_desc');
            if(is_array($house_picture_url)){
                foreach($house_picture_url as $key => $pic_url){
                    $imgField = array(
                        'pic_url'=>$pic_url,
                        'pic_thumb'=>$house_picture_thumb[$key],
                        'pic_desc'=>$house_picture_desc[$key],
                        'housesell_id'=>$house_id,
                        'creater'=>$creater,
                        'addtime'=>time(),
                    );
                    $this->db->insert($this->tNamePic,$imgField);
                }
            }

        }else{
            //增加
            $statistics=M('statistics');
            $house_no=$statistics->where(array('stat_index'=>'housesell_no'))->getField('stat_value');
            $house_no = $house_no+1;
            $field_array['house_no']='451'.sprintf("%07d",$house_no);//451为citycode
            $statistics->where(array('stat_index'=>'housesell_no'))->setInc('stat_value',1);
            $field_array['created']=time();
            $field_array['updated']=time();
            //新发房源有4个小时的优先显示
            $field_array['update_order']=time()+14400;
            //游客发布进入未审核状态
            if($broker_id==0){
                $field_array['is_checked'] =0;
            }
            $field_array['status']=I('status')?I('status'):1;
            $field_array['house_drawing'] = I('house_drawing');

            //插入到房源审核中
            $borough_picture_url=I('borough_picture_url');
            $borough_picture_desc=I('borough_picture_desc');
            $borough_picture_thumb=I('borough_picture_thumb');

            if(is_array($borough_picture_url)){
                $pic_list = D('Borough')->getImgList($borough_id,0);

                if($pic_list){
                    $picList = array();
                    foreach ($pic_list as $item){
                        $picList[] = $item['pic_url'];
                    }
                    $old_value = implode('|',$picList);
                }
                foreach($borough_picture_url as $key => $pic_url){
                    $newValue = $borough_picture_desc[$key]."|".$pic_url."|".$borough_picture_thumb[$key];
                    $boroughUpdateField = array(
                        'borough_id'=>$borough_id,
                        'id'=>'borough_pic',
                        'old_value'=>$old_value,
                        'value'=>$newValue,
                        'broker_id'=>$broker_id,
                    );
                    //$borough_update->save($boroughUpdateField);
                }
            }//if is array


        }//else


        p($_POST);
    }






}