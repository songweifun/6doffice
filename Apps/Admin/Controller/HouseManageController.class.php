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
        parent::_initialize();
        $this->cate=CONTROLLER_NAME;  //分配栏目
    }
    /**
     * 出售管理
     */
    public function sell(){
        import('Class.Dd',APP_PATH);
        $config = D('WebConfig');
        $housesell=D('Housesell');
        $return_to = $_SERVER['HTTP_REFERER'];
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



        }else if($action =="dateDel"){
//p($_POST);die;
           if($housesell->dateDel($_POST['dateDel'])){
                echo '<script>alert("删除成功");location.href="'.U(MODULE_NAME.'/HouseManage/sell',array('check'=>0)).'"</script>';
            }else{
                echo '<script>alert("删除失败");location.href='.U(MODULE_NAME.'/HouseManage/sell',array('check'=>0)).'</script>';
            }



        }elseif($action=='delete'){

            $ids = I('ids');
            //p($ids);die;
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择删除条目');
            }

            $member =D('Member');
            $messageRule = D('MessageRule');
            $innernote = D('Innernote');
            try{

                foreach ($ids as $id){
                    $housesell->deleteSell($id);
                }
                jsurlto('删除房源成功',U(MODULE_NAME.'/HouseManage/sell',array('check'=>0)));
            }catch (Exception $e){
                $this->error('删除失败，',$e->getMessage());
            }
            exit;


        }elseif($action=='isindex'){//首页推荐
            $ids = $_POST['ids'];
            $status = intval($_GET['status']);
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择推荐条目');
            }
            $isIndex = $housesell->getCount(5,'');
            //p($isIndex);die;
            if($isIndex>6 && $status ==1){
                $this->error('推荐条数超过6条，请删除之后在推荐');
            }

            try{
                $housesell->update($ids,'is_index',$status);
                $this->success('操作成功');
            }catch (Exception $e){
                $this->error($e->getMessage());
            }

            exit;

        }elseif($action=='islike'){//猜你喜欢
            $ids = $_POST['ids'];
            $status = intval($_GET['status']);
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择推荐条目');
            }
            $isLike = $housesell->getCount(11,'');
            if($isLike>6 && $status ==1){
                $this->error('推荐条数超过6条，请删除之后在推荐');
            }
            try{
                $housesell->update($ids,'is_like',$status);
                $this->success('操作成功',$return_to);
            }catch (Exception $e){
                $this->error($e->getMessage());
            }

            exit;

        }elseif($action=='isthemes'){//主体推荐
            $ids = $_POST['ids'];

            $status = intval($_GET['status']);
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择推荐条目');
            }
            $isThemes = $housesell->getCount(12,'');
            //p($isThemes);die;
            if($isThemes>6 && $status ==1){
                $this->error('推荐条数超过6条，请删除之后在推荐');
            }
            try{
                $housesell->update($ids,'is_themes',$status);
                $this->success('操作成功',$return_to);
            }catch (Exception $e){
                $this->error($e->getMessage());
            }

            exit;


        }elseif($action=="docheck"){//游客审核

            $ids = $_POST['ids'];
            $status = intval($_GET['status']);
            if(!is_array($ids) || empty($ids)){
                $this->error('没有选择审核条目');
            }
            try{
                $housesell->check($ids,$status);
                $integral = D('IntegralRule');
                $member =D('Member');
                $messageRule = D('MessageRule');
                $innernote = D('Innernote');
                foreach ($ids as $id){
                    $dataInfo = $housesell->getInfo($id);
                    if($status == 1){
                        //通过，增加积分
                        if($dataInfo['broker_id']){
                            //发布一条增加5分
                            $integral->add($dataInfo['broker_id'],7);
                            $houseImg = $housesell->getImgNum($id);
                            if($houseImg>=5){
                                $integral->add($dataInfo['broker_id'],11);
                            }
                            if($dataInfo['drawing_id'] || $dataInfo['house_drawing'] ){
                                $integral->add($dataInfo['broker_id'],12);
                            }
                        }
                    }else{
                        //没通过，发送自动站内信
                        if($dataInfo['broker_id']){
                            $message = $messageRule->getInfo(1,'rule_remark')['rule_remark'];
                            $real_name = $member->getRealName($dataInfo['broker_id'],1);
                            $username = $member->getInfo($dataInfo['broker_id'],'username')['username'];
                            $message = sprintf($message,$real_name,U('Home/Sell/index'),$dataInfo['id'],$dataInfo['house_no']);
                            $innernote->send('系统',$username,'系统消息',$message);
                        }
                    }
                }
                $this->success('审核房源成功',$return_to);
        }catch (Exception $e){
            $this->error($e->getMessage());
        }

	exit;



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
        $houseWanted = D('HouseWanted');
        $return_to = $_SERVER['HTTP_REFERER'];


        $where =" wanted_type = 1 ";

        if(isset($_GET['status'])){
            $where .= ' and status ='.intval($_GET['status']);
        }

        $Page=new \Think\Page($houseWanted->getCount($where),10);
        $Page -> setConfig('header','共%TOTAL_ROW%条');
        $Page -> setConfig('first','首页');
        $Page -> setConfig('last','共%TOTAL_PAGE%页');
        $Page -> setConfig('prev','上一页');
        $Page -> setConfig('next','下一页');
        $Page -> setConfig('link','indexpagenumb');//pagenumb 会替换成页码
        $Page -> setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        $pageLimit = $Page->firstRow.','.$Page->listRows;
        $houseWantedList = $houseWanted->getList($pageLimit,'*',$where,'add_time desc');
        $member = D('Member');
        foreach ($houseWantedList as $key => $value){
            if($value['expert_id']){
                $tmp = explode(',',$value['expert_id']);
                array_remove_empty($tmp);
                foreach($tmp as $item){
                    $houseWantedList[$key]['expert'][] = $member->getInfo($item,'*',true);
                }
            }
        }

        $this->assign('dataList', $houseWantedList);
        $this->assign('pagePanel', $Page->show());//分页条


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

    /**
     * 房源图片管理
     */
    public function managePic(){

        $this->title =  $this->title.' - 管理房源图片';

        $house_id = intval($_GET['house_id']);
        if(!$house_id){
            exit;
        }
        if($_GET['cls'] == 'sell'){
            $house = D('Housesell');
        }elseif ($_GET['cls'] == 'rent'){
            $house = D('Houserent');
        }else{
            exit;
        }
        $borough = D('Borough');
        $action=I('get.action');
        if($action=='getBoroughImg'){
            //删除房源图片 Ajax
            $houseInfo = $house->getInfo($house_id);
            if($_GET['tp'] == 'pic'){
                $boroughImgList = $borough->getImgList($houseInfo['borough_id'],false);
            }else{
                $boroughImgList = $borough->getImgList($houseInfo['borough_id'],true);
            }
            $str = '';
            foreach ($boroughImgList as $item){
                $str .= '<div style="float:left;width:80px;">
					<img src="'.__ROOT__.'/Uploads/'.$item['pic_url'].'" width="80" height="60">
				</div>';
            }
            echo $str;
            exit;

        }elseif($action=='delImg'){
            //删除房源图片 Ajax
            $ids = explode(',',$_POST['picid']);
            if($_GET['tp'] == 'pic'){
                if(is_array($ids)){
                    array_remove_empty($ids);
                    foreach ($ids as $id){
                        $house->delHousePic($id);
                    }
                    $house_img = $house->getImgList($house_id,'*');
                    if($house_img){
                        $house->update($house_id,'house_thumb',$house_img[0]['pic_url']);
                    }else{
                        $house->update($house_id,'house_thumb','');
                    }
                }
            }else{
                //echo $house_id;
                $house->delHouseDraw($house_id);
            }
            echo 1;

            exit;

        }elseif($action=='moveToBorough'){

            $ids = explode(',',$_POST['picid']);
            $houseInfo = $house->getInfo($house_id);
            if($_GET['tp'] == 'pic'){
                if(is_array($ids)){
                    array_remove_empty($ids);
                    foreach ($ids as $id){
                        //存入小区图片
                        $imgInfo = $house->getImgInfo($id);
                        $fieldData = array(
                            'pic_url'=>$imgInfo['pic_url'],
                            'pic_thumb'=>$imgInfo['pic_thumb'],
                            'pic_desc'=>$imgInfo['pic_desc'],
                            'borough_id'=>$houseInfo['borough_id'],
                            'creater'=>$imgInfo['creater'],
                            'addtime'=>$imgInfo['addtime'],
                        );
                        $borough->insertPic($fieldData);
                        //删除
                        $house->delHousePic($id);
                    }
                    $house_img = $house->getImgList($house_id,'*');
                    if($house_img){
                        $house->update($house_id,'house_thumb',$house_img[0]['pic_url']);
                    }
                }
            }else{
                $member = D('Member');
                $houseInfo['broker_id'] = $houseInfo['broker_id']? $houseInfo['broker_id']:$houseInfo['consigner_id'];
                if($houseInfo['broker_id']){
                    $creater = $member->getInfo($houseInfo['broker_id'],'username')['username'];
                }
                $fieldData = array(
                    'pic_url'=>$houseInfo['house_drawing'],
                    'pic_thumb'=>$houseInfo['house_drawing'],
                    'pic_desc'=>$houseInfo['borough_name'],
                    'borough_id'=>$houseInfo['borough_id'],
                    'creater'=>$creater,
                    'addtime'=>$houseInfo['created'],
                );
                $borough->insertDrawing($fieldData);
                //$house->delHouseDraw($house_id);
            }
            echo 1;
            exit;

        }else{

            $houseInfo = $house->getInfo($house_id,'*');
            if($_GET['tp'] == 'pic'){
                $houseImgList = $house->getImgList($house_id,'*');
            }else{
                $houseImgList[0]['pic_url'] = $houseInfo['house_drawing'];
            }
            $this->assign('houseImgList',$houseImgList);

            if(!$houseInfo['borough_id']){
                $this->error("没有选择小区");
            }
            if($_GET['tp'] == 'pic'){
                $boroughImgList = $borough->getImgList($houseInfo['borough_id'],false);
            }else{
                $boroughImgList = $borough->getImgList($houseInfo['borough_id'],true);
            }
            $this->assign('boroughImgList',$boroughImgList);
        }

        $this->display();

    }

}
