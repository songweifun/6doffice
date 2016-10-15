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
        if($action=='add'){

        }elseif($action=='edit'){
            //$page->name = 'boroughEdit'; //页面名字,和文件名相同
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

        }elseif($action=="search"){

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