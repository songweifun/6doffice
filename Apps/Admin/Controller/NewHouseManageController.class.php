<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/11/20
 * Time: 下午2:19
 */
namespace Admin\Controller;
use Think\Controller;
class NewHouseManageController extends CommonController{
    public function _initialize()
    {
        $this->cate=CONTROLLER_NAME;  //分配栏目
    }

    public function index(){

        $this->menu = ACTION_NAME;//分配小栏目
        import('Class.Dd',APP_PATH);


        $borough = D('Borough');

        $check = intval($_GET['check']);
        $keyword = $_REQUEST['q']=='请输入小区名称,小区地址'?"":trim($_REQUEST['q']);
        $cityarea_id = intval($_REQUEST['cityarea']);
        $where = ' and isnew =1 and isdel=0 ';
        if($cityarea_id){
            $where .= " and cityarea_id =".$cityarea_id;
        }
        if($keyword){
            $where .= " and (borough_name like '%".$keyword."%' or borough_address like '%".$keyword."%')";
        }

        $areaLists = \Dd::getArray('cityarea');
        $this->assign('areaLists', $areaLists);
        $borough_section = \Dd::getArray('borough_section');
        $Page = new \Think\Page($borough->getCount($check, $where), 10);
        $Page->setConfig('header', '共%TOTAL_ROW%条');
        $Page->setConfig('first', '首页');
        $Page->setConfig('last', '共%TOTAL_PAGE%页');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('link', 'indexpagenumb');//pagenumb 会替换成页码
        $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        $pageLimit = $Page->firstRow . ',' . $Page->listRows;
        $dataList = $borough->getList($pageLimit,$check,$where,'created desc');
        foreach ($dataList as $key => $value){
            $dataList[$key]['cityarea_id'] = $areaLists[$value['cityarea_id']];
            $dataList[$key]['borough_section'] = $borough_section[$value['borough_section']];
        }

        $this->assign('cityarea', $cityarea_id);
        $this->assign('q', $keyword);
        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条



        $this->display();


    }

    /**
     * 添加新盘
     */

    public function add(){
        $this->menu = ACTION_NAME;//分配小栏目
        import('Class.Dd',APP_PATH);
        $borough = D('Borough');


        //字典
        $cityarea_option = \Dd::getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);
        $borough_section_option = \Dd::getArray('borough_section');
        $this->assign('borough_section_option', $borough_section_option);

        $properties_option = \Dd::getArray('borough_properties');
        $this->assign('properties_option', $properties_option);

        $borough_type_option = \Dd::getArray('borough_type');
        $this->assign('borough_type_option', $borough_type_option);
        $borough_support_option = \Dd::getArray('borough_support');
        $this->assign('borough_support_option', $borough_support_option);
        $borough_sight_option = \Dd::getArray('borough_sight');
        $this->assign('borough_sight_option', $borough_sight_option);
        $borough_developer_option = \Dd::getArray('borough_developer');
        $this->assign('borough_developer_option', $borough_developer_option);
        $picture_num = 0;
        $drawing_num = 0;

        if($_GET['id']){
            $this->assign('action','edit');
            $id = intval($_GET['id']);
            $boroughInfo = $borough->getInfo($id,'*',1);
            $boroughInfo['boroughInfo']['borough_green'] = round($boroughInfo['boroughInfo']['borough_green'],2);
            $boroughInfo['boroughInfo']['borough_sight'] = explode(',',$boroughInfo['boroughInfo']['borough_sight']);
            $boroughInfo['boroughInfo']['borough_support'] = explode(',',$boroughInfo['boroughInfo']['borough_support']);

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

        $this->display();
    }

    /**
     * 保存新盘
     */
    public function save(){
        //p($_POST);die;
        $user=D('Users');
        $borough=D('Borough');
        $to_url = $_POST['to_url'];
        $_POST['creater'] = $user->getAuthInfo('username');
        $_POST['borough']['isnew'] = 1;
        if($borough->saveBorough($_POST)){
            $this->success('添加/编辑新盘成功',$to_url);
        }else{
            $this->error('添加/编辑新盘失败');
        }
    }

    /**
     * 意向
     */
    public function intention(){
        $borough=D('Borough');
        $id = intval($_GET['id']);
        $boroughName = $borough->getInfo($id,'borough_name',0,false)['borough_name'];
        $linktype = intval($_GET['linktype']);
        $where = "borough_id = ".$id;
        if($linktype == 1){
            $q="参加团购";
            $where .= " and link_type like '%".$q."%'";
        }
        if($linktype == 2){
            $q="邮寄楼书发我";
            $where .= " and link_type like '%".$q."%'";
        }
        if($linktype == 3){
            $q="登记现场看房";
            $where .= " and link_type like '%".$q."%'";
        }
        if($linktype == 4){
            $q="通过电子邮件联系";
            $where .= " and link_type like '%".$q."%'";
        }
        if($linktype == 5){
            $q="通过电话联系";
            $where .= " and link_type like '%".$q."%'";
        }
        $intentionList = $borough->getIntentionList($where,'addtime desc ');
        $this->assign('intentionList', $intentionList);
        $this->assign('id', $id);
        $this->assign('boroughName', $boroughName);
        $this->display();
    }

    /**
     * 删除意向
     */
    public function intentionDelete(){
        $borough=D('Borough');

        $ids = $_POST['ids'];
        $to_url = $_SERVER['HTTP_REFERER'];
        if(!is_array($ids) || empty($ids)){
            $this->error('没有选择删除条目');
        }
        if($borough->intentionDelete($ids)){
            $this->success('删除意向成功',$to_url);
        }else{
            $this->error('删除意向失败');
        }

        exit;
    }

    /**
     * 动态
     */
    public function news(){
        $borough=D('Borough');

        $boroughId = $_GET['id'];
        $boroughNewsList = $borough->getNewsList($boroughId);
        //p($boroughNewsList);die;
        $this->assign('boroughNewsList', $boroughNewsList);

        $this->display();

    }

    /**
     * 动态保存
     */
    public function newsSave(){
        $borough=D('Borough');

        $to_url = $_SERVER['HTTP_REFERER'];
        $borough->saveNews($_POST);
        $this->success('添加成功', $to_url);
    }

    /**
     * 删除动态
     */
    public function deleteNews(){
        $borough=D('Borough');

        $ids = $_POST['ids'];
        $to_url = $_SERVER['HTTP_REFERER'];
        if(!is_array($ids) || empty($ids)){
            $this->error('没有选择删除条目');
        }

        if($borough->deleteNews($ids)){
            $this->success('删除成功', $to_url);
        }else{
            $this->error('删除失败');
        }
    }

}