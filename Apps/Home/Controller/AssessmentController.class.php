<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午10:01
 */
namespace Home\Controller;
use Think\Controller;
class AssessmentController extends CommonController{
    public function index(){
        //页面标题
        $this->title = '房产价格评估 - '.$this->titlec;
        $action=I('get.action');

        if($action=='save'){
            //p($_POST);
            $borough_id=I('borough_id',0,'intval');
            $borough_name=I('borough_name');
            $pinggu = M('pinggu');
            $id=I('post.id');//修改的id

            if(!$borough_id){
                $borough=M('borough');
                $borough_id = $borough->where(array('borough_name'=>$borough_name))->getField('id');
                //没有找到该小区
                if(!$borough_id){
                    $this->error('没有搜索到相关的小区，请确认你的小区名称');
                }
            }
            //echo $borough_id;die;
            if($_COOKIE['AUTH_MEMBER_STRING']){
                $member = D('MemberView');
                $creater = $member->getAuthInfo('id');
            }else{
                $creater = I('post.creater');
            }



            try{
                $pinggu_id=$id;
                if($id){//更新
                    //编辑

                    $field_array  = array(
                        'house_type'=>I('house_type',0,'intval'),
                        'borough_id'=>I('borough_id',0,'intval'),
                        'borough_name'=>I('borough_name'),
                        'home_no'=>I('home_no',0,'intval'),
                        'room_no'=> I('room_no',0,'intval'),
                        'house_totalarea'=>I('house_totalarea'),
                        'house_room'=>I('house_room',0,'intval'),
                        'house_hall'=>I('house_hall',0,'intval'),
                        'house_toilet'=>I('house_toilet',0,'intval'),
                        'house_topfloor'=>I('house_topfloor',0,'intval'),
                        'house_floor'=>I('house_floor',0,'intval'),
                        'house_toward'=>I('house_toward',0,'intval'),
                        'has_lift'=>I('has_lift',0,'intval'),
                        'has_empty'=>I('has_empty',0,'intval'),
                    );
                    $pinggu->where(array('id'=>$id))->save($field_array);

                }else{
                    //增加
                    $field_array  = array(
                        'house_type'=>I('house_type',0,'intval'),
                        'borough_id'=>I('borough_id',0,'intval'),
                        'borough_name'=>I('borough_name'),
                        'home_no'=>I('home_no',0,'intval'),
                        'room_no'=> I('room_no',0,'intval'),
                        'house_totalarea'=>I('house_totalarea'),
                        'house_room'=>I('house_room',0,'intval'),
                        'house_hall'=>I('house_hall',0,'intval'),
                        'house_toilet'=>I('house_toilet',0,'intval'),
                        'house_topfloor'=>I('house_topfloor',0,'intval'),
                        'house_floor'=>I('house_floor',0,'intval'),
                        'house_toward'=>I('house_toward',0,'intval'),
                        'has_lift'=>I('has_lift',0,'intval'),
                        'has_empty'=>I('has_empty',0,'intval'),
                        'creater'=>$creater,
                        'add_time'=>time(),
                    );

                    $pinggu_id =$pinggu->add($field_array);

                }
                //p($pinggu_id);die;
                D('Assessment')->refreshPrice($pinggu_id);//成功后进行自动评估
                $this->redirect("more",array('id'=>$pinggu_id));


            }catch ( Exception $e){
                $this->error('保存信息失败');
            }
            exit;
        }

        //字典
        $house_type_option = getArrayAssessment('house_type');
        $this->assign('house_type_option', $house_type_option);

        //特色
        $house_toword_option = getArrayAssessment('house_toward');
        $this->assign('house_toword_option', $house_toword_option);
        if($_GET['id']){
            //修改
            $id = intval($_GET['id']);
            $pinggu = M('pinggu');
            $dataInfo = $pinggu->where(array('id'=>$id))->find();
            $this->assign('dataInfo', $dataInfo);
        }
        //右边的优质房源列表
        $house = M('housesell');
        $bestList=$house->where(array('is_checked=1 and status =1'))->order('order_weight desc')->limit(4)->select();
        $this->assign('bestList', $bestList);
        $this->display();
    }

    /**
     * 详细评估
     */
    public function more(){
        $this->title = '详细的房产价格评估 - '.$this->titlec;
        $house = M('housesell');
        $pinggu = D('Assessment');
        $borough = D('BoroughView');
        $action=I('get.action');

        if($action == "save"){
            if($_POST['house_quality']){
                $_POST['house_quality'] = ",".implode(',',$_POST['house_quality']).",";
            }
            try{

                    //编辑
                    $pinggu_id = I('post.id');
                    $field_array  = array(
                        'house_fitment'=>I('house_fitment',0,'intval'),
                        'fitment_price'=>I('fitment_price',0,'intval'),
                        'fitment_year'=>I('fitment_year',0,'intval'),
                        'house_place'=>I('house_place',0,'intval'),
                        'house_view'=>I('house_view',0,'intval'),
                        'house_light'=>I('house_light',0,'intval'),
                        'house_noise'=>I('house_noise',0,'intval'),
                        'house_quality'=>I('house_quality',0,'intval'),
                        'is_detail'=>1,
                    );
                   M('pinggu')->where(array('id'=>$pinggu_id))->save($field_array);
                    $pinggu->refreshPrice($pinggu_id);

                $this->redirect("report",array('id'=>$pinggu_id));
            }catch ( Exception $e){
                $this->error($e->getMessage());
            }
            exit;
        }

        $id=I('get.id');
        if(!$id){
            $this->redirect('index');
        }
        $dataInfo = $pinggu->where(array('id'=>$id))->find();
        if(!$dataInfo){
            $this->redirect('index');
        }

        $dataInfo['house_type'] = $pinggu->getCaption('house_type',$dataInfo['house_type']);
        $dataInfo['house_toward'] = $pinggu->getCaption('house_toward',$dataInfo['house_toward']);

        $dataInfo['borough_info'] = $borough->where(array('id'=>$dataInfo['borough_id']))->find();
        $dataInfo['borough_info']['cityarea_name'] = $pinggu->getCaption('cityarea',$dataInfo['borough_info']['cityarea_id']);

        $this->assign('dataInfo', $dataInfo);
        //字典
        $house_fitment_option = getArrayAssessment('house_fitment');
        $this->assign('house_fitment_option', $house_fitment_option);
        $fitment_quotiety_option = $pinggu->getItemListByName('house_fitment');
        $fitment_quotiety_option = array_to_hashmap($fitment_quotiety_option,'di_value','di_quotiety');
        $this->assign('fitment_quotiety_option', $fitment_quotiety_option);

        $house_place_option = getArrayAssessment('house_place');
        $this->assign('house_place_option', $house_place_option);

        $house_view_option = getArrayAssessment('house_view');
        $this->assign('house_view_option', $house_view_option);

        $house_light_option = getArrayAssessment('house_light');
        $this->assign('house_light_option', $house_light_option);

        $house_noise_option = getArrayAssessment('house_noise');
        $this->assign('house_noise_option', $house_noise_option);

        $house_quality_option = getArrayAssessment('house_quality');
        $this->assign('house_quality_option', $house_quality_option);

        //右边的优质房源列表
        $bestList=$house->where('is_checked=1 and status =1')->order('order_weight desc')->limit(5)->select();
        $this->assign('bestList', $bestList);


        $this->display();

    }

    /**
     * 评估报告
     */
    public function report(){
        //页面标题
        $page->title = '房产价格评估报告 - '.$page->titlec;


        $house = M('housesell');
        $pinggu = D('Assessment');
        $borough = D('BoroughView');

        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect('index');
        }
        $dataInfo = $pinggu->where(array('id'=>$id))->find();
        if(!$dataInfo){
            $this->redirect('index');
        }


        $dataInfo['house_fitment'] = $pinggu->getCaption('house_fitment',$dataInfo['house_fitment']);
        $dataInfo['house_type'] = $pinggu->getCaption('house_type',$dataInfo['house_type']);
        $dataInfo['house_toward'] = $pinggu->getCaption('house_toward',$dataInfo['house_toward']);

        $dataInfo['house_light'] = $pinggu->getCaption('house_light',$dataInfo['house_light']);
        $dataInfo['house_place'] = $pinggu->getCaption('house_place',$dataInfo['house_place']);
        $dataInfo['house_view'] = $pinggu->getCaption('house_view',$dataInfo['house_view']);
        $dataInfo['house_noise'] = $pinggu->getCaption('house_noise',$dataInfo['house_noise']);
        if($dataInfo['house_quality']){
            $dataInfo['house_quality'] = $pinggu->getCaption('house_quality',$dataInfo['house_quality']);
        }else{
            $dataInfo['house_quality'] = "完好";
        }
        $dataInfo['borough_info'] = $borough->where(array('id'=>$dataInfo['borough_id']))->find();
        if($dataInfo['borough_info']['borough_avgprice']){
            if($dataInfo['borough_info']['borough_avgprice'] > $dataInfo['house_avgprice'] ){
                $price_compare = (1 - round($dataInfo['house_avgprice']/$dataInfo['borough_info']['borough_avgprice'],4))*100;
                $dataInfo['price_compare'] = "低" .$price_compare."%";
            }else{
                $price_compare = (round($dataInfo['house_avgprice']/$dataInfo['borough_info']['borough_avgprice'],4)-1)*100;
                $dataInfo['price_compare'] = "高" .$price_compare."%";
            }
        }

        $dataInfo['borough_info']['cityarea_name'] = getCaption('cityarea',$dataInfo['borough_info']['cityarea_id']);


        $this->assign('dataInfo', $dataInfo);

        //该小区价格相近房源
        $where = " and status =1 and (borough_id = ".$dataInfo['borough_id']." or borough_name = '".$dataInfo['borough_name']."')" ;
        $sameBorougHouse = $house->where('(is_checked=0 or is_checked=1)'.$where)->order('order_weight desc')->limit(3)->select();
        $this->assign('sameBorougHouse', $sameBorougHouse);

        //价格相近房源
        $where = " and status =1 and house_price*10000/house_totalarea > ".($dataInfo['house_avgprice']-200)." and house_price*10000/house_totalarea <".($dataInfo['house_avgprice']+200);
        $samePriceHouse = $house->where('(is_checked=0 or is_checked=1)'.$where)->order('order_weight desc')->limit(4)->select();
        $this->assign('samePriceHouse', $samePriceHouse);
        $this->display();

    }
}