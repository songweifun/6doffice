<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/12/13
 * Time: 下午8:33
 */
namespace Admin\Controller;
use Think\Controller;
class SystemManageController extends CommonController{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->cate=CONTROLLER_NAME;
    }

    /**
     * 全局参数
     */
    public function dd(){
        $this->menu = ACTION_NAME;//分配小栏目
        $dd = D('Dd');
        $action=I('get.action');
        if($action=='order'){

            //order排序
            $order = $_POST['list_order'];
            $group = $_POST['list_group'];
            $dd_id = intval($_GET['dd_id']);
            if(empty($order)){
                exit;
            }
            try{
                $dd->orderBy($order,$dd_id);
                $dd->groupBy($group,$dd_id);
                $this->success('排序成功',U('dd').'/action/edit/dd_id/' . $dd_id);
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
            exit;

        }elseif($action=='edit'){
            $this->action='edit';
            $_GET['dd_id'] = $_GET['dd_id'] ? $_GET['dd_id'] : $_POST['dd_id'];
            if ($_POST) {
                //添加编辑项
                try {
                    if ($_GET['dd_id']==1){
                        $dd->saveDd2($_POST);
                    }else{
                        $dd->saveDd($_POST);
                    }
                } catch (Exception $e) {
                    $this->error($e->getMessage(),U('dd').'/action/edit/dd_id/' . $_GET['dd_id']);
                }
            }
            if ($_GET['di_id']) {
                //取编辑项信息
                $diInfo = $dd->getDiInfo($_GET['di_id']);
                $this->assign('diInfo', $diInfo);
            }

            $class=$dd->getArea();
            $this->assign("class", $class);
            $this->assign('dd_id', $_GET['dd_id']);
            $this->assign('list', $dd->getItemList($_GET['dd_id']));
            $this->assign('list1', $dd->getItemList(1));

        }elseif($action=='delete'){

            //  删除
            if ($_POST['dds']) {
                $dd->deleteInfo($_POST['dds']);
            }
            $this->success('删除成功',U('dd').'/action/edit/dd_id/' . $_GET['dd_id']);
            exit;

        }else{
            $this->assign('list', $dd->getList());
        }
        $this->display();

    }

    /**
     * 房源预约刷新
     */
    public function appointment(){
        $this->menu = ACTION_NAME;//分配小栏目
        $appomuch=D('Appomuch');

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $appTime = is_numeric($_POST['appTime'])?$_POST['appTime']:1;
            $appNum = is_numeric($_POST['appNum'])?$_POST['appNum']:1;
            $appCountNum = is_numeric($_POST['appCountNum'])?$_POST['appCountNum']:1;
            $appInterest = is_array($_POST['appInterest'])?serialize($_POST['appInterest']):serialize(array(0));

            $appomuch->updateapp($appTime,'appTime');
            $appomuch->updateapp($appNum,'appNum');
            $appomuch->updateapp($appCountNum,'appCountNum');
            $appomuch->updateapp($appInterest,'appInterest');


            echo '<script>alert("更新成功！")</script>';
        }

        $arr=$appomuch->select();
        foreach($arr as $k=>$v){

            if($v['appo_name']=='appInterest'){
                $v['appo_value'] = unserialize($v['appo_value']);
            }

            $result[$v['appo_name']]=$v['appo_value'];

        }

        $this->assign('appo',$result);




        $this->display();
    }

    /**
     * 计划任务执行
     */
    public function crontab(){
        $this->menu = ACTION_NAME;//分配小栏目
        $config=D('WebConfig');
        $action=I('get.action');
        if ($action=='save') {
            $_POST['webConfig']['borough_avg_time'] = $_POST['webConfig']['borough_avg_time']*24*60*60;
            $_POST['webConfig']['member_num_time'] = $_POST['webConfig']['member_num_time']*24*60*60;
            $_POST['webConfig']['broker_integral_time'] = $_POST['webConfig']['broker_integral_time']*24*60*60;
            $_POST['webConfig']['broker_active_Rate_time'] = $_POST['webConfig']['broker_active_Rate_time']*24*60*60;
            $_POST['webConfig']['statistics_time'] = $_POST['webConfig']['statistics_time']*24*60*60;
            $_POST['webConfig']['borough_pic_num_time'] = $_POST['webConfig']['borough_pic_num_time']*24*60*60;
            $_POST['webConfig']['house_invalid_time'] = $_POST['webConfig']['house_invalid_time']*24*60*60;

            $config->saveConf($_POST['webConfig']);
            $this->success('保存成功',U('crontab'));
            exit;
        }else{
            
            $webConfig = $config->getInfo(1,'*');
            $webConfig['borough_avg_time'] = $webConfig['borough_avg_time']/60/60/24;
            $webConfig['member_num_time'] = $webConfig['member_num_time']/60/60/24;
            $webConfig['broker_integral_time'] = $webConfig['broker_integral_time']/60/60/24;
            $webConfig['broker_active_Rate_time'] = $webConfig['broker_active_Rate_time']/60/60/24;
            $webConfig['statistics_time'] = $webConfig['statistics_time']/60/60/24;
            $webConfig['borough_pic_num_time'] = $webConfig['borough_pic_num_time']/60/60/24;
            $webConfig['house_invalid_time'] = $webConfig['house_invalid_time']/60/60/24;
            $this->assign('webConfig', $webConfig);
        }
        $this->display();
    }

    /**
     * 积分规则
     */
    public function integrationRule(){

        $this->menu = ACTION_NAME;//分配小栏目
        import('Class.Dd',APP_PATH);

        $integral = D('IntegralRule');
        $action=I('get.action');
        if($action=='add'){
            $rule_class = \Dd::getArray('integral_ruleclass');
            $this->assign('rule_class', $rule_class);

            $id = intval($_GET['id']);
            if($id){
                $dataInfo=$integral->getInfo($id);
                $this->assign('dataInfo', $dataInfo);
            }
            $this->display('integralEdit');
            exit;

        }elseif($action=='save'){
            try{
                $integral->saveIntergraRule($_POST);
                $this->success('保存成功',U('integrationRule'));
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
            exit;

        }elseif($action=='status'){
            $ids = $_POST['ids'];
            $status=intval($_GET['status']);
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择删除条目');
            }

            try{
                //删除自己的条目
                $integral->changeStatus($ids,$status);

                $this->success('操作成功',U('integrationRule'));
            }catch (Exception $e){
                $this->error($e->getMessage());
            }

            exit;

        }elseif($action=='delete'){
            $ids = $_POST['ids'];
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择删除条目');
            }

            try{
                //删除自己的条目
                $integral->deleteRule($ids);

                $this->success('删除成功',U('integrationRule'));
            }catch (Exception $e){
                $this->error($e->getMessage());
            }

            exit;

        }else{
            $rule_class = \Dd::getArray('integral_ruleclass');
            $this->assign('rule_class', $rule_class);
            $where=' 1=1 ';
            $Page = new \Think\Page($integral->getCount($where), 10);
            $Page->setConfig('header', '共%TOTAL_ROW%条');
            $Page->setConfig('first', '首页');
            $Page->setConfig('last', '共%TOTAL_PAGE%页');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('link', 'indexpagenumb');//pagenumb 会替换成页码
            $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

            $pageLimit = $Page->firstRow . ',' . $Page->listRows;
            $dataList = $integral->getList($pageLimit,'*',$where,'rule_class asc,id asc');
            //p($dataList);die;
            foreach ($dataList as $key=>$item){
                $dataList[$key]['rule_class'] = $rule_class[$item['rule_class']];
            }
            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $Page->show());//分页条
        }
        $this->display();

    }

    /**
     * 自动站内信规则
     */
    public function MessageRule(){

        $this->menu = ACTION_NAME;//分配小栏目
        import('Class.Dd',APP_PATH);

        $messageRule = D('MessageRule');
        $action=I('get.action');
        if($action=='add'){
            $rule_class = \Dd::getArray('message_ruleclass');
            $this->assign('rule_class', $rule_class);


            $id = intval($_GET['id']);
            if($id){
                $dataInfo=$messageRule->getInfo($id);
                $this->assign('dataInfo', $dataInfo);
            }
            $this->display('MessageEdit');
            exit;

        }elseif($action=='save'){
            try{
                $messageRule->saveMessageRule($_POST);
                $this->success('保存成功',U('MessageRule'));
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
            exit;

        }elseif($action=='status'){
            $ids = $_POST['ids'];
            $status=intval($_GET['status']);
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择删除条目');
            }

            try{
                //删除自己的条目
                $messageRule->changeStatus($ids,$status);

                $this->success('操作成功',U('MessageRule'));
            }catch (Exception $e){
                $this->error($e->getMessage());
            }

            exit;

        }elseif($action=='delete'){
            $ids = $_POST['ids'];
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择删除条目');
            }

            try{
                //删除自己的条目
                $messageRule->deleteRule($ids);

                $this->success('删除成功',U('integrationRule'));
            }catch (Exception $e){
                $this->error($e->getMessage());
            }

            exit;

        }else{
            $rule_class = \Dd::getArray('integral_ruleclass');
            $this->assign('rule_class', $rule_class);
            $where=' 1=1 ';
            $Page = new \Think\Page($messageRule->getCount($where), 10);
            $Page->setConfig('header', '共%TOTAL_ROW%条');
            $Page->setConfig('first', '首页');
            $Page->setConfig('last', '共%TOTAL_PAGE%页');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('link', 'indexpagenumb');//pagenumb 会替换成页码
            $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

            $pageLimit = $Page->firstRow . ',' . $Page->listRows;
            $dataList = $messageRule->getList($pageLimit,'*',$where,'rule_class asc,id asc');
            foreach ($dataList as $key=>$item){
                $dataList[$key]['rule_class'] = $rule_class[$item['rule_class']];
            }
            $this->assign('dataList', $dataList);
            $this->assign('pagePanel', $Page->show());//分页条
        }
        $this->display();

    }


}