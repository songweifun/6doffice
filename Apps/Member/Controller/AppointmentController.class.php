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

        if ($action == 'appoRefresh') {//显示模板页面
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
            //循环每条房源
            foreach ($_POST['appo_house_id'] as $id) {
                if(M('appolist')->where(array('house_id'=>$id,'appo_site'=>$site))->getField('appo_list_id')){
                    continue;
                }
                //循环预约的每一天
                for ($i=0;$i<=$_POST['appo_date'][$id];$i++) {
                    $appo_dates = date('Y-m-d', strtotime("+{$i} days"));
                    //获得年月日
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

                    //循环每一个小时分钟的字符串
                    foreach ($data[$id] as $val) {
                        list($hour, $minute) = explode('-', $val);
                        $time = mktime($hour, $minute, 0, $month, $day, $year);
                        //检测时间是否小于现在时间
                        if ($time < time()) {
                            if (date('i', time()) < 30) {
                                $time = strtotime('+30 minute', strtotime(date('Y-m-d H:0:0', time())));
                            } else {
                                $time = strtotime('+1 hour', strtotime(date('Y-m-d H:0:0', time())));
                            }
                        }


                        //检测时间是否大于每个时间点可设置的次数
                        while (1) {
                            if (array_key_exists($time, $datePart) && $datePart[$time] >= $appoMuth['appCountNum']) {
                                $time = strtotime('+' . $appoMuth['appTime'] . ' minutes ', $time);
                            } else {
                                break;
                            }
                        }
                        try {
                            $appolistdata=array(
                                'user_id'=>$member_id,
                                'house_id'=>$id,
                                'house_title'=>$_POST['appo_house_title'][$id],
                                'update_time'=>$time,
                                'appo_site'=>$site,
                            );
                            M('appolist')->data($appolistdata)->add();
                        } catch (Exception $e) {
                            $this->error('设置预约刷新失败');
                        }
                    }

                }//for

            }//foreach
            if ($site == 'rent') {
                //jsurlto('设置预约刷新成功！');
            } else {
                jsurlto('设置预约刷新成功！',U(MODULE_NAME.'/Housesell/index'));

            }
        }elseif($action=='appoShowHouse'){//查看预约

            $this->name = 'detailHouse';
            $house_id = intval($_REQUEST['house_id']);
            $appolistarr2=M('appolist')->where(array('user_id'=>$member_id,'house_id'=>$house_id,'appo_site'=>$site))->select();
            foreach($appolistarr2 as $rel){
                $result['house_title'] = $rel['house_title'];
                $result['update'][date('Y.m.d',$rel['update_time'])][$rel['appo_list_id']]['day'] = date('Y年m月d日',$rel['update_time']);
                $result['update'][date('Y.m.d',$rel['update_time'])][$rel['appo_list_id']]['hour'] = date('H',$rel['update_time']);
                $result['update'][date('Y.m.d',$rel['update_time'])][$rel['appo_list_id']]['minute'] = date('i',$rel['update_time']);
                $result['update_limit'][date('Y.m.d',$rel['update_time'])] = date('Y年m月d日',$rel['update_time']);
            }

            //p($result);die;
            //p(is_array($result));die;


            if(!is_array($result) && empty($result)){
                if($site=='rent'){
                    //jsurlto('您选择房源没有预约刷新或者此房源不属于您！',U(MODULE_NAME.'/Houserent/index'));
                }else{
                    jsurlto('您选择房源没有预约刷新或者此房源不属于您！',U(MODULE_NAME.'/Housesell/index'));
                }
            }

            $result['house_id'] = $house_id;
            foreach($result['update_limit'] as $key=>$value){
                for($i = count($result['update'][$key]); $i < 5; $i++) {
                    $result['update'][$key][$i.'in'] = array('day'=>$value);
                }
            }
            //p($result);
            $this->assign('house',$result);
            $this->display($this->name);
            return;

        }elseif($action=='editAppo' && IS_POST){//编辑
            $to_url = $_SERVER['HTTP_REFERER'];
            $appo_hours = $_POST['appo_hours'];
            $appo_minute = $_POST['appo_minute'];
            $appo_date = $_POST['appo_date'];
            $house_id = $_POST['house_id'];
            $house_title = $_POST['house_title'];
            list($year, $month, $day) = explode('.', $appo_date);
            //p($appo_hours);die;
            foreach ($appo_hours[$_POST['appo_date']] as $id => $hour) {
                if (is_numeric($hour) && is_numeric($appo_minute[$_POST['appo_date']][$id])) {
                    $time = mktime($hour, $appo_minute[$_POST['appo_date']][$id], 0, $month, $day, $year);
                    //检测时间是否小于现在时间 如果小于 分钟数小于30当前时间加上30分钟 大于30加上一个小时
                    if ($time < time()) {
                        if (date('i', time()) < 30) {
                            $time = strtotime('+30 minute', strtotime(date('Y-m-d H:0:0', time())));
                        } else {
                            $time = strtotime('+1 hour', strtotime(date('Y-m-d H:0:0', time())));
                        }
                    }
                    //检测时间是否大于每个时间点可设置的次数
                    while (1) {
                        if (array_key_exists($time, $datePart) && $datePart[$time] >= $appoMuth['appCountNum']) {
                            $time = strtotime('+' . $appoMuth['appTime'] . ' minutes ', $time);
                        } else {
                            break;
                        }
                    }
                    try {
                        $appolistdata=array(
                            'user_id'=>$member_id,
                            'house_id'=>$house_id,
                            'house_title'=>$house_title,
                            'update_time'=>$time,
                            'appo_site'=>$site,
                        );

                        if (!is_numeric($id)) {
                            M('appolist')->data($appolistdata)->add();

                        } else {
                            M('appolist')->data($appolistdata)->where(array('appo_list_id'=>$id))->save();
                        }
                    } catch (Exception $e) {
                        $this->error('设置预约刷新失败');
                    }
                }else{
                    M('appolist')->where(array('appo_list_id'=>$id))->delete();

                }//else

            }//foreach
            jsurlto('修改成功',$to_url);
        }elseif($action=='appoDel'){//取消预约
            $house_id = I('get.house_id',0,'intval');
            M('appolist')->where(array('house_id'=>$house_id))->delete();
            jsurlto('取消成功！',U(MODULE_NAME.'/Housesell/index'));


        }else{
            jsurlto('您没有权限访问此页面!',U(MODULE_NAME.'/Housesell/index'));
        }//elseif

        $this->display();

    }

}