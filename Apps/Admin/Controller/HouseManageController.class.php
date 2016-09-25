<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午3:24
 */
namespace Admin\Controller;
use Think\Controller;
class HouseManageController extends CommonController{
    public function _initialize()
    {
        $this->cate=CONTROLLER_NAME;  //分配栏目
    }
    /**
     * 出售管理
     */
    public function sell(){
        import('Class.Dd',APP_PATH);
        $config = D('WebConfig');
        $housesell=D('Housesell');
        $action=I('get.action');
        if($action=='search'){
            $keyword = $_REQUEST['q']=='请输入房源编号'?"":trim($_REQUEST['q']);
            $cityarea_id = intval($_REQUEST['cityarea']);
            $check = intval($_GET['check']);
            $where = "";
            if($cityarea_id){
                $where .= " and cityarea_id =".$cityarea_id;
            }
            if($keyword){
                $where .= " and (house_no like '%".$keyword."%')";
            }

            $areaLists = \Dd::getArray('cityarea');
            $this->assign('areaLists', $areaLists);
            $houseTypeList = \Dd::getArray('house_type');
            $Page=new \Think\Page($housesell->getCount($check,$where),10);
            $Page -> setConfig('header','共%TOTAL_ROW%条');
            $Page -> setConfig('first','首页');
            $Page -> setConfig('last','共%TOTAL_PAGE%页');
            $Page -> setConfig('prev','上一页');
            $Page -> setConfig('next','下一页');
            $Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
            $Page -> setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

            $pageLimit = $Page->firstRow.','.$Page->listRows;
            $housesellList = $housesell->getList($pageLimit,'*',$check,$where,'created desc ');
            foreach ($housesellList as $key => $value){
                $housesellList[$key]['cityarea_id'] = $areaLists[$value['cityarea_id']];
                $housesellList[$key]['house_pic'] = $housesell->getImgList($value['id']);
                $housesellList[$key]['real_name'] = M('broker_info')->where(array('id'=>$value['broker_id']))->getField('realname');

                $housesellList[$key]['house_type'] = $houseTypeList[$value['house_type']];
                if($value['broker_id']==0){
                    $housesellList[$key]['consigner_name'] = M('broker_info')->where(array('id'=>$value['consigner_id']))->getField('realname');
                }

            }
            $this->assign('cityarea', $cityarea_id);
            $this->assign('q', $keyword);
            $this->assign('dataList', $housesellList);
            $this->assign('pagePanel', $Page->show());//分页条



        }else{




        $webConfig = $config->getInfo(1,'*');
        $check = intval($_GET['check']);
        $where = " and (status =0 or status =1  or status = 2 or status =3 or status = 4 or status =7)";

        $areaLists = \Dd::getArray('cityarea');
        $houseTypeList = \Dd::getArray('house_type');

        $this->assign('areaLists', $areaLists);
        $Page=new \Think\Page($housesell->getCount($check,$where),10);
        $Page -> setConfig('header','共%TOTAL_ROW%条');
        $Page -> setConfig('first','首页');
        $Page -> setConfig('last','共%TOTAL_PAGE%页');
        $Page -> setConfig('prev','上一页');
        $Page -> setConfig('next','下一页');
        $Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
        $Page -> setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        $pageLimit = $Page->firstRow.','.$Page->listRows;
        $housesellList = $housesell->getList($pageLimit,'*',$check,$where,'created desc ');
        $member = D('Member');
        $today = date("Y-m-d", time());
        $yestoday = date("Y-m-d", strtotime("-1 day"));
        foreach ($housesellList as $key => $value){
            $housesellList[$key]['yestoday_click'] = intval($housesell->getClick($value['id'], $yestoday));
            $housesellList[$key]['today_click'] = intval($housesell->getClick($value['id'], $today));
            $housesellList[$key]['cityarea_id'] = $areaLists[$value['cityarea_id']];
            $housesellList[$key]['house_type'] = $houseTypeList[$value['house_type']];
            $housesellList[$key]['house_pic'] = $housesell->getImgList($value['id']);
            $housesellList[$key]['real_name'] = M('broker_info')->where(array('id'=>$value['broker_id']))->getField('realname');

        }
        //p($housesellList);die;
        $this->assign('dataList', $housesellList);
        $this->assign('pagePanel', $Page->show());//分页条
        }




        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 出租管理
     */
    public function rent(){


        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 求购管理
     */
    public function buy(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 求租管理
     */
    public function hold(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 委托出售
     */
    public function consign(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 虚假举报
     */
    public function report(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }

}
