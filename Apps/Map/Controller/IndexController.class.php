<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/18
 * Time: 下午10:04
 */
namespace Map\Controller;
use Think\Controller;
class IndexController extends Controller{
    public function rent(){
        $this->display();
    }
    public function marker(){
        $markers=M('borough')->field('id,lat,lng,borough_address,borough_name,rent_num')->select();
        //p($markers);die;
        $this->ajaxReturn($markers);
    }

    public function getHouseRent(){
        //import('Class.Dd',APP_PATH);
        $houseFitmentList = getArray('house_fitment');

        $id=I('get.bid');
        $Page=new \Think\Page(M('houserent')->where(array('borough_id'=>$id))->count(),5);
        $Page -> setConfig('header','共%TOTAL_ROW%条');
        $Page -> setConfig('first','首页');
        $Page -> setConfig('last','共%TOTAL_PAGE%页');
        $Page -> setConfig('prev','上一页');
        $Page -> setConfig('next','下一页');
        $Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
        $Page -> setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        $pageLimit = $Page->firstRow.','.$Page->listRows;
        $houserent=M('houserent')->where(array('borough_id'=>$id))->limit($pageLimit)->select();
        foreach($houserent as $k=>$v){
            $houserent[$k]['house_fitment']=$houseFitmentList[$v['house_fitment']];
            $houserent[$k]['house_title']=mb_substr($houserent[$k]['house_title'],0,14,'utf-8')."....";

        }
        $this->ajaxReturn($houserent);
    }
}