<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午4:34
 */
namespace Admin\Controller;
use Think\Controller;
class BoroughManageController extends CommonController{
    public function _initialize()
    {
        $this->cate=CONTROLLER_NAME;  //分配栏目
    }

    /**
     * 小区管理列表
     */
    public function index(){

        $this->menu = ACTION_NAME;//分配小栏目


        import('Class.Dd',APP_PATH);

        $borough=D('Borough');
        $action=I('get.action');
        if($action=='edit' || $action=='add'){

            //$page->addJs('FormValid.js');
            //字典
            $cityarea_option = \Dd::getArray('cityarea');
            $this->assign('cityarea_option', $cityarea_option);

            $borough_section_option = \Dd::getArray('borough_section');
            $this->assign('borough_section_option', $borough_section_option);
            $borough_type_option = \Dd::getArray('borough_type');
            $this->assign('borough_type_option', $borough_type_option);
            $borough_support_option = \Dd::getArray('borough_support');
            $this->assign('borough_support_option', $borough_support_option);
            $borough_sight_option = \Dd::getArray('borough_sight');
            $this->assign('borough_sight_option', $borough_sight_option);
            $picture_num = 0;
            $drawing_num = 0;

            if($_GET['id']){
                $id = intval($_GET['id']);
                $boroughInfo = $borough->getInfo($id,'*',1);
                $boroughInfo['boroughInfo']['borough_green'] = round($boroughInfo['boroughInfo']['borough_green'],2);
                $boroughInfo['boroughInfo']['borough_sight'] = explode(',',$boroughInfo['boroughInfo']['borough_sight']);
                $boroughInfo['boroughInfo']['borough_support'] = explode(',',$boroughInfo['boroughInfo']['borough_support']);
                $cityarea_option2 = \Dd::getArray('cityarea2');
                $boroughInfo['borough']['cityarea2_name'] = $cityarea_option2[$boroughInfo['borough']['cityarea2_id']];
                $boroughInfo['borough']['botough_picture'] = $borough->getImgList($id,0);
                $picture_num = count($boroughInfo['borough']['botough_picture']);
                $boroughInfo['borough']['botough_drawing'] = $borough->getImgList($id,1);
                $drawing_num = count($boroughInfo['borough']['botough_drawing']);

                $this->assign('boroughInfo', $boroughInfo['boroughInfo']);
                $this->assign('borough', $boroughInfo['borough']);
            }

            $this->assign('to_url', $_SERVER['HTTP_REFERER']);
            $this->assign('picture_num', $picture_num);
            $this->assign('drawing_num', $drawing_num);
            $this->display('boroughEdit');
        }elseif($action=="save"){
            $to_url = $_POST['to_url'];
            $_POST['creater'] = getAdminAuthInfo('username');
            if($borough->saveBorough($_POST)){
                $this->success('小区信息保存成功',$to_url);
            }else{
                $this->error('保存小区信息失败');
            }


        }elseif($action=="search"){

            if(isset($_GET['nofull'])){
                $where = " and isdel=0 and( borough_thumb is null or borough_address  is null )";
            }else{
                $keyword = $_REQUEST['q']=='请输入小区名称,小区地址'?"":trim($_REQUEST['q']);
                $cityarea_id = intval($_REQUEST['cityarea']);
                $where = " and isdel=0 ";
                if($cityarea_id){
                    $where .= " and cityarea_id =".$cityarea_id;
                }
                if($keyword){
                    $where .= " and (borough_name like '%".$keyword."%' or borough_letter like '%".$keyword."%' or borough_alias like '%".$keyword."%' or borough_address like '%".$keyword."%')";
                }
            }
            $areaLists = \Dd::getArray('cityarea');
            $this->assign('areaLists', $areaLists);
            $borough_section = \Dd::getArray('borough_section');

            $Page = new \Think\Page($borough->getCount(1, $where), 10);
            $Page->setConfig('header', '共%TOTAL_ROW%条');
            $Page->setConfig('first', '首页');
            $Page->setConfig('last', '共%TOTAL_PAGE%页');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('link', 'indexpagenumb');//pagenumb 会替换成页码
            $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

            $pageLimit = $Page->firstRow . ',' . $Page->listRows;
            $boroughList = $borough->getList($pageLimit, 1, $where, 'borough_name asc');
            foreach ($boroughList as $key => $value) {
                $boroughList[$key]['cityarea_id'] = $areaLists[$value['cityarea_id']];
                $boroughList[$key]['borough_section'] = $borough_section[$value['borough_section']];
            }
            $this->assign('cityarea', $cityarea_id);
            $this->assign('q', $keyword);
            $this->assign('boroughList', $boroughList);
            $this->assign('pagePanel', $Page->show());//分页条
            $this->display();

        }elseif($action=="delete"){
            $back_to = $_SERVER['HTTP_REFERER'];
            $ids = $_POST['ids'];
            //p($ids);die;
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择删除条目');
            }

            $status=$borough->deleteBorough($ids);
            //p($status);die;

            if($status){

                $this->success('删除小区成功',U('index'));
            }else{

                $this->error('删除失败,可能所选择的小区中还有房源');
            }

        }elseif($action=="combine"){
            //合并两个栏目


            $action =$_POST['fromaction'];
            $q =$_POST['q'];
            $cityarea =$_POST['cityarea'];
            $pageno =$_POST['pageno'];

            if(empty($_POST['fromId'])){
                $this->error("没有选择需要合并的小区");
            }
            if(empty($_POST['toId'])){
                $this->error("没有选择合并到哪个小区");
            }
            //剔除目标ID
            $fromId = array_diff($_POST['fromId'], $_POST['toId']);//比较两个数组的键值，并返回差集：


            $targetid = intval($_POST['toId'][0]);

            foreach ($fromId as $afromid){
                $afromid = intval($afromid);
                $add_field = array('old_id'=>$afromid,'new_id'=>$targetid);
                M('borough_log')->add($add_field);//更新日志
                //删除
                $update_field = array('isdel'=>1);
                $borough->where(array('id'=>$afromid))->save($update_field);//删除被合并的小区不物理删除
                //房源移动到新的小区
                $housesell = D('Housesell');
                $housesell->where(array('borough_id'=>$afromid))->save(array('borough_id'=>$targetid));
                $houserent = D('Houserent');
                $houserent->where(array('borough_id'=>$afromid))->save(array('borough_id'=>$targetid));
                $member = D('Member');
                M('broker_info')->where(array('borough_id'=>$afromid))->save(array('borough_id'=>$targetid));//小区专家
                //M('owner_info')->where(array('borough_id'=>$afromid))->save(array('borough_id'=>$targetid));
            }
            //echo 'index.php?action='.$action.'&q='.$q.'&cityarea='.$cityarea.'&pageno='.$pageno;
            //exit;
            $this->success('合并小区成功',U('index',array('action'=>$action,'q'=>$q,'cityarea'=>$cityarea,'p'=>$pageno)));

        }else {
            $areaLists = \Dd::getArray('cityarea');
            //p($areaLists);die;
            $this->assign('areaLists', $areaLists);
            $borough_section = \Dd::getArray('borough_section');

            $Page = new \Think\Page($borough->getCount(1, ' and isdel=0'), 10);
            $Page->setConfig('header', '共%TOTAL_ROW%条');
            $Page->setConfig('first', '首页');
            $Page->setConfig('last', '共%TOTAL_PAGE%页');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('link', 'indexpagenumb');//pagenumb 会替换成页码
            $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

            $pageLimit = $Page->firstRow . ',' . $Page->listRows;
            $boroughList = $borough->getList($pageLimit, 1, ' and isdel=0', 'borough_name asc');
            foreach ($boroughList as $key => $value) {
                $boroughList[$key]['cityarea_id'] = $areaLists[$value['cityarea_id']];
                $boroughList[$key]['borough_section'] = $borough_section[$value['borough_section']];
            }

            $this->assign('boroughList', $boroughList);
            $this->assign('pagePanel', $Page->show());//分页条
            $this->display();
        }

    }
    /**
     * 小区审核
     */
    public function check(){
        $this->menu=ACTION_NAME;//分配小栏目
        import('Class.Dd',APP_PATH);

        $borough=D('Borough');
        $action=I('get.action');
        if($action=='combine'){

        }elseif($action=='delete'){

        }elseif($action=='check'){

        }else{
            $where = ' and isdel=0';
            $areaLists = \Dd::getArray('cityarea');
            $this->assign('areaLists', $areaLists);
            $borough_section = \Dd::getArray('borough_section');
            $Page = new \Think\Page($borough->getCount(5, $where), 10);
            $Page->setConfig('header', '共%TOTAL_ROW%条');
            $Page->setConfig('first', '首页');
            $Page->setConfig('last', '共%TOTAL_PAGE%页');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('link', 'indexpagenumb');//pagenumb 会替换成页码
            $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

            $pageLimit = $Page->firstRow . ',' . $Page->listRows;
            $boroughList = $borough->getList($pageLimit,5,$where,'created desc');
            foreach ($boroughList as $key => $value){
                $boroughList[$key]['cityarea_id'] = $areaLists[$value['cityarea_id']];
                $boroughList[$key]['borough_section'] = $borough_section[$value['borough_section']];
            }

            $this->assign('boroughList', $boroughList);
            $this->assign('pagePanel', $Page->show());//分页条

        }
        $this->display();

    }
    /**
     * 小区更新审核
     */
    public function updateCheck(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 评估价更新
     */
    public function evaluate(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }

    /**
     * 评估系数管理
     */
    public function pingguDd(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }

}