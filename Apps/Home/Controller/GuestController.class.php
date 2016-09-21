<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/20
 * Time: 下午10:16
 */
namespace Home\Controller;
use Think\Controller;
class GuestController extends CommonController{
    /**
     * 个人发布出售
     */
    public function houseSale(){
        if($this->guest==2){
            $this->error('网站未开通游客发布功能',U(MODULE_NAME.'/Index/index'));
        }
        //#######此处应该判断用户是否登录#############
        $houseSell = M('housesell');
        $action=I('get.action');
        if($action=='save'){
            //通过手机号判断发布房源数量
            $phone = $houseSell->where('(is_checked = 0 or is_checked = 1 ) and owner_phone='.$_POST['owner_phone'])->count();
            if(empty($_POST['id'])){  //如果为编辑房源则跳过条数判断
                if($phone>=3){
                    $this->error('您的手机号码发布次数超过3条',U(MODULE_NAME.'/Guest/houseSale'));
                }
            }
            $member_id = getAuthInfo('id');
            $broker_id=$member_id;
            $creater=getAuthInfo('username');
            $company_id=getAuthInfo('company_id');//将房源和公司联系起来
            $borough_id=I('borough_id',0,'intval');
            $borough_name=I('borough_name');
            $borough =D('Borough');
            if(!$borough_id){
                $borough_id=D('Borough')->getInfo(array('borough_name'=>$borough_name),'id');
                //没有找到该小区
                if(! $borough_id){
                    $this->error('没有搜索到相关的小区，请确认你的小区名称');
                }
                $cityarea_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea_id');
                $cityarea2_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea2_id');
            }else{
                $cityarea_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea_id');
                $cityarea2_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea2_id');
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
                'house_toward'=>I('house_toward',0,'intval'),
                'house_fitment'=>I('house_fitment'),
                'house_feature'=>$house_feature,
                'house_desc'=>I('house_desc'),
                'borough_id'=>$borough_id,
                'borough_name'=>$borough_name,
                'broker_id'=>$broker_id,
                'belong'=>I('belong',0,'intval'),
                'owner_name'=>I('owner_name'),
                'owner_phone'=>I('owner_phone'),
                'owner_notes'=>I('owner_notes'),//管理密码
                'is_vexation' =>I('vexation',0,'intval'),//加急
                'company_id' =>$company_id,
            );

            //当不是编辑时 * 减少加急房源条数
            if ( !I('id') && I('vexation') == 1 )
            {
                M('member')->where(array('id'=>$broker_id))->setDec('vexation',1);
            }

            //取图片第一张作为房源缩略图
            $house_picture_thumb=I('house_picture_thumb');
            if($house_picture_thumb[0]){
                $field_array['house_thumb'] =$house_picture_thumb[0];
            }

            $house_picture_url=I('house_picture_url');
            $house_picture_thumb=I('house_picture_thumb');
            $house_picture_desc=I('house_picture_desc');
            //保存
            try{
                if($_POST['id']){//编辑房源
                    $is_checked=0;
                    if($broker_id == 0){
                        $field_array['is_checked'] = $is_checked;
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
                    $field_array['house_drawing'] = I('house_drawing');
                    //插入房源图片
                    if(is_array($house_picture_url)){
                        $picarr=array();
                        foreach($house_picture_url as $key => $pic_url){
                            $imgField = array(
                                'pic_url'=>$pic_url,
                                'pic_thumb'=>$house_picture_thumb[$key],
                                'pic_desc'=>$house_picture_desc[$key],
                                'housesell_id'=>$house_id,
                                'creater'=>$creater,
                                'addtime'=>time(),
                            );
                            $picarr[]=$imgField;
                        }
                    }

                    $field_array['housesell_pic']=$picarr;
                    M('housesell_pic')->where(array('housesell_id'=>$house_id))->delete();//删除房源图片
                    $house_id=D('HouseSellRelation')->relation(true)->where(array('id'=>$house_id))->save($field_array);//关联模型一次性插入
                    $houseImg = M('housesell_pic')->where(array("housesell_id"=>$house_id))->count();
                    if($houseImg>=3){
                        //户型图超过3条为多图房源
                        M('housesell')->where(array('id'=>$house_id))->setField('is_more_pic',1);
                    }
                    if($houseImg<3){
                        //户型图少于3条取消多图房源
                        M('housesell')->where(array('id'=>$house_id))->setField('is_more_pic',0);
                    }
                    $this->success('编辑成功,重新进入审核',U(MODULE_NAME.'/Sell/detail',array('id'=>$house_id)));
                }else{//插入
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

                    //插入到房源审核中 将小区图片插入到待审核
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
                                'field_name'=>'borough_pic',
                                'old_value'=>$old_value,
                                'new_value'=>$newValue,
                                'broker_id'=>$broker_id,
                                'add_time'=>time(),
                            );
                            M('borough_update')->add($boroughUpdateField);
                        }
                    }//if is borough_url array


                    //统计买卖房源数加1
                    $statistics->where(array('stat_index'=>'sellNum'))->setInc('stat_value',1);
                    //对应小区中增加一个房源
                    D('Borough')->where(array('id'=>$borough_id))->setInc('sell_num',1);

                    //插入房源图片
                    $picarr=array();
                    if(is_array($house_picture_url)){
                        foreach($house_picture_url as $key => $pic_url){
                            $imgField = array(
                                'pic_url'=>$pic_url,
                                'pic_thumb'=>$house_picture_thumb[$key],
                                'pic_desc'=>$house_picture_desc[$key],
                                //'housesell_id'=>$house_id,
                                'creater'=>$creater,
                                'addtime'=>time(),
                            );
                            $picarr[]=$imgField;
                        }
                    }

                    $field_array['housesell_pic']=$picarr;

                    //关联模型插入 housesell housesell_pic
                    $house_id=D('HouseSellRelation')->relation(true)->add($field_array);
                    $houseImg = M('housesell_pic')->where(array("housesell_id"=>$house_id))->count();
                    if($houseImg>=3){
                        //户型图超过3条为多图房源
                        M('housesell')->where(array('id'=>$house_id))->setField('is_more_pic',1);
                    }
                    $this->success('发布成功等待管理员审核',U(MODULE_NAME.'/Sell/detail',array('id'=>$house_id)));

                }
            }catch ( Exception $e){
                $this->error('保存信息失败');
            }
            exit;

        }else{
            //房源类型
            $house_type_option = getArray('house_type');
            $this->assign('house_type_option', $house_type_option);
            //装修情况
            $house_fitment_option = getArray('house_fitment');
            $this->assign('house_fitment_option', $house_fitment_option);
            //房屋产权
            $belong_option = getArray('belong');
            $this->assign('belong_option', $belong_option);
            //房源特色
            $house_feature_option = getArrayGrouped('house_feature');
            $this->assign('house_feature_option', $house_feature_option);
            $house_feature_group = array(1=>"小区室内",2=>'地段周边',3=>'其它特色');
            $this->assign('house_feature_group', $house_feature_group);
            //区域，增加小区使用
            $cityarea_option = getArray('cityarea');
            $this->assign('cityarea_option', $cityarea_option);
            //小区物业类型
            $borough_type_option = getArray('borough_type');
            $this->assign('borough_type_option', $borough_type_option);
            $picture_num = 0;
            //房龄
            for($i = 1980; $i <= date('Y');$i++){
                $house_age_option[] = $i;
            }
            $this->assign('house_age_option', $house_age_option);
            //配套
            /*	$house_installation_option = getArray('house_installation');
                $this->assign('house_installation_option', $house_installation_option);*/
            //朝向
            $house_toward_option = getArray('house_toward');
            $this->assign('house_toward_option', $house_toward_option);
            $picture_num = 0;
            $dataInfo['house_feature'] = array();
            //编辑取数据
            if($_GET['id']){
                $id = intval($_GET['id']);
                $owner_notes = $houseSell->where(array('id'=>$id))->getField('owner_notes');

                if($_POST['deletePwd'] != $owner_notes){
                    $this->error('密码错误',U(MODULE_NAME.'/Sell/detail',array('id'=>$id)));
                }

                $dataInfo = $houseSell->where(array('id'=>$id))->find();
                //print_rr($dataInfo);
                $dataInfo['house_feature'] = explode(',',$dataInfo['house_feature']);
                array_remove_empty($dataInfo['house_feature'],true);
                //$dataInfo['house_installation'] = explode(',',$dataInfo['house_installation']);
                $dataInfo['house_pic'] = M('housesell_pic')->where(array('housesell_id'=>$id))->select();//没有用到关联模型
                $picture_num = count($dataInfo['house_pic']);
            }
            $this->assign('dataInfo', $dataInfo);
            $this->assign('to_url', $_SERVER['HTTP_REFERER']);
            $this->assign('picture_num', $picture_num);
            $this->display();
        }
    }

    /**
     * 游客发布出租
     */
    public function houseRent(){
        if($this->guest==2){
            $this->error('网站未开通游客发布功能',U(MODULE_NAME.'/Index/index'));
        }
        //#######此处应该判断用户是否登录#############
        $houseRent = M('houserent');
        $action=I('get.action');
        if($action=='save'){
            //通过手机号判断发布房源数量
            $phone = $houseRent->where('(is_checked = 0 or is_checked = 1 ) and owner_phone='.$_POST['owner_phone'])->count();
            if(empty($_POST['id'])){  //如果为编辑房源则跳过条数判断
                if($phone>=3){
                    $this->error('您的手机号码发布次数超过3条',U(MODULE_NAME.'/Guest/houseRent'));
                }
            }
            $member_id = getAuthInfo('id');
            $broker_id=$member_id;
            $creater=getAuthInfo('username');
            $company_id=getAuthInfo('company_id');//将房源和公司联系起来
            $borough_id=I('borough_id',0,'intval');
            $borough_name=I('borough_name');
            $borough =D('Borough');
            if(!$borough_id){
                $borough_id=D('Borough')->getInfo(array('borough_name'=>$borough_name),'id');
                //没有找到该小区
                if(! $borough_id){
                    $this->error('没有搜索到相关的小区，请确认你的小区名称');
                }
                $cityarea_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea_id');
                $cityarea2_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea2_id');
            }else{
                $cityarea_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea_id');
                $cityarea2_id=D('Borough')->getInfo(array("id"=>$borough_id),'cityarea2_id');
            }
            //房源特色，前后加，号便于搜索匹配
            if(I('house_feature')){
                $house_feature = ','.implode(',',I('house_feature')).',';
            }
            if(I('house_support')){
                $house_support = ','.implode(',',I('house_support')).',';
            }

            $field_array  = array(
                'house_title'=>I('house_title'),
                'cityarea_id'=>$cityarea_id,
                'cityarea2_id'=>$cityarea2_id,
                'house_type'=>I('house_type'),
                'house_price'=>I('house_price',0,'intval'),
                'house_deposit'=>I('house_deposit',0,'intval'),//付款方式

                'house_totalarea'=>I('house_totalarea',0,'intval'),
                'house_room'=>I('house_room',0,'intval'),
                'house_hall'=>I('house_hall',0,'intval'),
                'house_toilet'=>I('house_toilet',0,'intval'),
                'house_veranda'=>I('house_veranda',0,'intval'),//阳台
                'video'=>I('video'),
                'house_topfloor'=>I('house_topfloor',0,'intval'),
                'house_floor'=>I('house_floor',0,'intval'),
                'house_age'=>I('house_age'),
                'house_toward'=>I('house_toward',0,'intval'),
                'house_fitment'=>I('house_fitment'),
                'house_support'=>$house_support,//配套出售没有

                'house_feature'=>$house_feature,
                'house_desc'=>I('house_desc'),
                'borough_id'=>$borough_id,
                'borough_name'=>$borough_name,
                'broker_id'=>$broker_id,
                'owner_name'=>I('owner_name'),
                'owner_phone'=>I('owner_phone'),
                'owner_notes'=>I('owner_notes'),//管理密码
                'company_id' =>$company_id,
            );

            //当不是编辑时 * 减少加急房源条数
            if ( !I('id') && I('vexation') == 1 )
            {
                M('member')->where(array('id'=>$broker_id))->setDec('vexation',1);
            }

            //取图片第一张作为房源缩略图
            $house_picture_thumb=I('house_picture_thumb');
            if($house_picture_thumb[0]){
                $field_array['house_thumb'] =$house_picture_thumb[0];
            }

            $house_picture_url=I('house_picture_url');
            $house_picture_thumb=I('house_picture_thumb');
            $house_picture_desc=I('house_picture_desc');
            //保存
            try{
                if($_POST['id']){//编辑房源
                    $is_checked=0;
                    if($broker_id == 0){
                        $field_array['is_checked'] = $is_checked;
                    }
                    $field_array['updated']=time();
                    $house_id= I('id',0,'intval');
                    $houseInfo=M('houserent')->field('house_drawing,created')->where(array('id'=>$house_id))->find();
                    //编辑今天的房源计算时间
                    $today = mktime(0,0,0,date('m'),date('d'),date('Y'));
                    if($houseInfo['created']>$today){
                        $field_array['update_order']=time()+14400;
                    }else{
                        $field_array['update_order']=time();
                    }
                    $field_array['house_drawing'] = I('house_drawing');
                    //插入房源图片
                    if(is_array($house_picture_url)){
                        $picarr=array();
                        foreach($house_picture_url as $key => $pic_url){
                            $imgField = array(
                                'pic_url'=>$pic_url,
                                'pic_thumb'=>$house_picture_thumb[$key],
                                'pic_desc'=>$house_picture_desc[$key],
                                'houserent_id'=>$house_id,
                                'creater'=>$creater,
                                'addtime'=>time(),
                            );
                            $picarr[]=$imgField;
                        }
                    }

                    $field_array['houserent_pic']=$picarr;
                    M('houserent_pic')->where(array('houserent_id'=>$house_id))->delete();//删除房源图片
                    $house_id=D('HouseRentRelation')->relation(true)->where(array('id'=>$house_id))->save($field_array);//关联模型一次性插入
                    $houseImg = M('houserent_pic')->where(array("houserent_id"=>$house_id))->count();
                    if($houseImg>=3){
                        //户型图超过3条为多图房源
                        M('houserent')->where(array('id'=>$house_id))->setField('is_more_pic',1);
                    }
                    if($houseImg<3){
                        //户型图少于3条取消多图房源
                        M('houserent')->where(array('id'=>$house_id))->setField('is_more_pic',0);
                    }
                    $this->success('编辑成功,重新进入审核',U(MODULE_NAME.'/Rent/detail',array('id'=>$house_id)));
                }else{//插入
                    $statistics=M('statistics');
                    $house_no=$statistics->where(array('stat_index'=>'houserent_no'))->getField('stat_value');
                    $house_no = $house_no+1;
                    $field_array['house_no']='451'.sprintf("%07d",$house_no);//451为citycode
                    $statistics->where(array('stat_index'=>'houserent_no'))->setInc('stat_value',1);
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

                    //插入到房源审核中 将小区图片插入到待审核
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
                                'field_name'=>'borough_pic',
                                'old_value'=>$old_value,
                                'new_value'=>$newValue,
                                'broker_id'=>$broker_id,
                                'add_time'=>time(),
                            );
                            M('borough_update')->add($boroughUpdateField);
                        }
                    }//if is borough_url array


                    //统计买卖房源数加1
                    $statistics->where(array('stat_index'=>'rentNum'))->setInc('stat_value',1);
                    //对应小区中增加一个房源
                    D('Borough')->where(array('id'=>$borough_id))->setInc('rent_num',1);

                    //插入房源图片
                    $picarr=array();
                    if(is_array($house_picture_url)){
                        foreach($house_picture_url as $key => $pic_url){
                            $imgField = array(
                                'pic_url'=>$pic_url,
                                'pic_thumb'=>$house_picture_thumb[$key],
                                'pic_desc'=>$house_picture_desc[$key],
                                //'houserent_id'=>$house_id,
                                'creater'=>$creater,
                                'addtime'=>time(),
                            );
                            $picarr[]=$imgField;
                        }
                    }

                    $field_array['houserent_pic']=$picarr;

                    //关联模型插入 houserent houserent_pic
                    $house_id=D('HouseRentRelation')->relation(true)->add($field_array);
                    $houseImg = M('houserent_pic')->where(array("houserent_id"=>$house_id))->count();
                    if($houseImg>=3){
                        //户型图超过3条为多图房源
                        M('houserent')->where(array('id'=>$house_id))->setField('is_more_pic',1);
                    }
                    $this->success('发布成功等待管理员审核',U(MODULE_NAME.'/Rent/detail',array('id'=>$house_id)));

                }
            }catch ( Exception $e){
                $this->error('保存信息失败');
            }
            exit;

        }else{
            //压付方式
            $rent_deposittype_option =getArray('rent_deposittype');
            $this->assign('rent_deposittype_option', $rent_deposittype_option);
            //房源类型
            $house_type_option = getArray('house_type');
            $this->assign('house_type_option', $house_type_option);
            //装修情况
            $house_fitment_option = getArray('house_fitment');
            $this->assign('house_fitment_option', $house_fitment_option);
            //房屋产权
            $belong_option = getArray('belong');
            $this->assign('belong_option', $belong_option);
            //房源特色
            $house_feature_option = getArrayGrouped('house_feature');
            $this->assign('house_feature_option', $house_feature_option);
            $house_feature_group = array(1=>"小区室内",2=>'地段周边',3=>'其它特色');
            $this->assign('house_feature_group', $house_feature_group);
            //区域，增加小区使用
            $cityarea_option = getArray('cityarea');
            $this->assign('cityarea_option', $cityarea_option);
            //小区物业类型
            $borough_type_option = getArray('borough_type');
            $this->assign('borough_type_option', $borough_type_option);
            $picture_num = 0;
            //房龄
            for($i = 1980; $i <= date('Y');$i++){
                $house_age_option[] = $i;
            }
            $this->assign('house_age_option', $house_age_option);
            //配套
            /*	$house_installation_option = getArray('house_installation');
                $this->assign('house_installation_option', $house_installation_option);*/
            //朝向
            $house_toward_option = getArray('house_toward');
            $this->assign('house_toward_option', $house_toward_option);
            $picture_num = 0;
            $dataInfo['house_feature'] = array();
            //编辑取数据
            if($_GET['id']){
                $id = intval($_GET['id']);
                $owner_notes = $houseRent->where(array('id'=>$id))->getField('owner_notes');

                if($_POST['deletePwd'] != $owner_notes){
                    $this->error('密码错误',U(MODULE_NAME.'/Rent/detail',array('id'=>$id)));
                }

                $dataInfo = $houseRent->where(array('id'=>$id))->find();
                //print_rr($dataInfo);
                $dataInfo['house_feature'] = explode(',',$dataInfo['house_feature']);
                array_remove_empty($dataInfo['house_feature'],true);
                //$dataInfo['house_installation'] = explode(',',$dataInfo['house_installation']);
                $dataInfo['house_pic'] = M('houserent_pic')->where(array('houserent_id'=>$id))->select();//没有用到关联模型
                $picture_num = count($dataInfo['house_pic']);
            }
            $this->assign('dataInfo', $dataInfo);
            $this->assign('to_url', $_SERVER['HTTP_REFERER']);
            $this->assign('picture_num', $picture_num);
            $this->display();
        }
    }
    /**
     *
     * 游客房源管理
     */
    public function guestManage(){
        $houseSell = M('housesell');
        $houseRent = M('houserent');
        $action=I('get.action');
        if($action=='search'){
            if(empty($_GET['mobile'])){
                $this->error('请输入手机号码');
            }
            //获取出售列表
            $dataList = $houseSell->where('(is_checked = 0 or is_checked = 1 ) and owner_phone='.$_GET['mobile'])->select();
            //$dataList = $houseSell->getList('','*','3',' and owner_phone = '.$_GET['mobile'],'');
            $this->assign('dataList',$dataList);
            //获取出租列表
            $dataList1 = $houseRent->where('(is_checked = 0 or is_checked = 1 ) and owner_phone='.$_GET['mobile'])->select();

            //$dataList1 = $houseRent->getList('','*','3',' and owner_phone = '.$_GET['mobile'],'');
            $this->assign('dataList1',$dataList1);

        }

        $this->title = $this->titlec.' 个人出租出售房源管理';
        $this->display();

    }

    /**
     * 委托房源
     */
    public function consignSale(){
        $consignSale = M('consign_sale');
        $action=I('get.action');
        if($action == 'save'){
            try{
                $field_array  = array(
                    'borough_name'=>I('borough_name'),
                    'house_floor'=>I('house_floor',0,'intval'),
                    'house_topfloor'=>I('house_topfloor',0,'intval'),
                    'house_room'=>I('house_room',0,'intval'),
                    'house_hall'=>I('house_hall',0,'intval'),
                    'house_price'=>I('house_price',0,'intval'),
                    'house_desc'=>I('house_desc',0,'intval'),
                    'owner_name'=>I('owner_name',0,'intval'),
                    'owner_phone'=>I('owner_phone',0,'intval'),
                    'house_area'=>I('house_area',0,'intval'),
                    'time'=>time(),

                );

                $house_id = $consignSale->add($field_array);
                $this->success('委托成功',U(MODULE_NAME.'/Guest/consignSale'));

            }catch ( Exception $e){
                $this->error('保存信息失败,联系管理员');
            }
            exit;

        }  $this->display();

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

    /**
     * webupload框架
     */
    public function webuploader(){
        $this->display();
    }



    /**
     * 发布出租上传
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


}