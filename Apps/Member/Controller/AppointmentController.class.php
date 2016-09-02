<?php
/**
 * 预约刷新控制器
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/2
 * Time: 下午7:54
 */
namespace Member\Controller;
use Think\Controller;
class AppointmentController extends CommonController{

    public function index(){
        /**
         * 预约刷新配置
         * @author 房产
         */
        $apparr=M('appomuch')->select();
        foreach($apparr as $rel){
            if ($rel['appo_name'] == 'appInterest') {
                $rel['appo_value'] = unserialize($rel['appo_value']);
            }
            $appoMuth[$rel['appo_name']] = $rel['appo_value'];
        }

        $action=I('get.action');

        $member_id =getAuthInfo('id');
        $site = $_REQUEST['site'];
        if($site=='rent'){
            $houseRent = M('houserent');
        }elseif($site=='sale'){
            $houseRent = M('housesell');
        }else{
            $this->error('您没有权限查看此页面！',U(MODULE_NAME.'/Index/index'));
        }

        $to_url = $_POST['to_url'];
        if (!in_array(getAuthInfo('vip'), $appoMuth['appInterest'])) {
            $this->error('您没有权限使用这个功能，请升级会员！',U(MODULE_NAME.'/Index/index'));
        }
        //生成24小时
        for ($i = 0; $i < 24; $i++) {
            $hour[] = sprintf('%02d', $i);
        }
        //生成可预约的分钟
        for ($i = 0; $i < 60; $i++) {
            if ($i % $appoMuth['appTime'] == 0) {
                $minute[] = sprintf('%02d', $i);
            }
        }

        //生成可提前预约的天数
        for ($i = 0; $i <= $appoMuth['appNum']; $i++) {
            $day = $i+1;
            $date[$i] = $i==0?'今天':$day.'天';
        }

        //获取每个时间段的次数
        $appolistarr=M('appolist')->field('COUNT(update_time) as part','update_time')->where(array('update_time'=>array('egt',time())))->select();
        foreach($appolistarr as $rel){

            $datePart['update_time'] = $rel['part'];
        }
        $this->assign('hour', $hour);
        $this->assign('minute', $minute);
        $this->assign('date', $date);

        if ($action == 'appoRefresh') {
            $ids = is_array($_REQUEST['ids']) ? $_REQUEST['ids'] : array($_REQUEST['ids']);
            $this->name = 'index';
            $ids = array_filter($ids);
            if (!is_array($ids) && empty($ids)) {
                $this->error('没有选择需要预约刷新的房源');
            }
            array_walk($ids,'intval');

            foreach ($ids as $id) {
                if(M('appolist')->where(array('house_id'=>$id,'appo_site'=>$site))->getField('appo_list_id')){
                    continue;
                }
                $house[]=$houseRent->field('house_title,id,refresh')->where(array('id'=>$id))->find();
            }
            if (empty($house) && !is_array($house)) {
                $this->error('您没有选择房源或此房源已经预约过！');
            }
            $this->assign('house', $house);
        }elseif ($action == 'submitAppo') {//提交预约刷新
            foreach ($_POST['appo_house_id'] as $id) {
                if(M('appolist')->where(array('house_id'=>$id,'appo_site'=>$site))->getField('appo_list_id')){
                    continue;
                }
                for ($i=0;$i<=$_POST['appo_date'][$id];$i++) {
                    $appo_dates = date('Y-m-d', strtotime("+{$i} days"));
                    list($year, $month, $day) = explode('-', $appo_dates);
                    //获取小时和分钟
                    $data = array();
                    foreach ($_POST['appo_hours'][$id] as $key => $hour) {
                        //检测是否正确时间
                        if (!is_numeric($hour) && !is_numeric($_POST['appo_minute'][$id][$key])) {
                            continue;
                        } else {
                            $data[$id][] = $hour . '-' . $_POST['appo_minute'][$id][$key];
                        }
                    }

                }//for

            }//foreach


        }//elseif



        $this->display();
    }

}