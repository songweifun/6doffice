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


}