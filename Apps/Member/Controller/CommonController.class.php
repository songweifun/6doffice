<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/23
 * Time: 下午6:52
 */

namespace Member\Controller;
use Think\Controller;
class CommonController extends Controller{
    public function _initialize(){
        if (!$_COOKIE['AUTH_MEMBER_STRING']) {
            $this->redirect(MODULE_NAME.'/Login/index');

        }else{

            if (!$_COOKIE['AUTH_CHECKTIME']) {
                // 间隔AUTH_CHECKTIME时间检查一次cookie信息是否和数据库一至
                $authInfo = getAuthInfo();
                $user=M('member')->where(array('id'=>$authInfo['id'],'passwd'=>$authInfo['passwd']))->find();

                if ($user['id']) {

                    setcookie('AUTH_CHECKTIME',1, time()+C('AUTH_TIME'));
                    //重新设置cookie使用户的Cookie在2个小时内不再失效 ， 如果是cookie设置关闭即失效就没有必要
                    /*
                    setcookie('AUTH_MEMBER_STRING',authcode($user_id. "\t" . md5($postInfo['passwd']. "\t" .$user_type), 'ENCODE', $cfg['auth_key']),$cfg['time']+7200,'/',$cfg['domain']);
                    setcookie('AUTH_MEMBER_NAME',$postInfo['username'],$cfg['time']+7200,'/',$cfg['domain']);
                    $_COOKIE['AUTH_MEMBER_NAME'] = $postInfo['username'];
                    */
                }
            }

        }//

        //公用的数据

        $page=$this;
        require(APP_PATH.'Common/commonphp/page.php');
        //echo $this->vip2SaleNum;die;

        $this->username = $_COOKIE['AUTH_MEMBER_REALNAME'] ? $_COOKIE['AUTH_MEMBER_REALNAME'] :$_COOKIE['AUTH_MEMBER_NAME'];
        $this->member_id =getAuthInfo('id');
        //未读邮件
        $newMsgCount = 0;
        if($_COOKIE['AUTH_MEMBER_NAME']){
            $newMsgCount=M('innernote')->where(array('to_del'=>0,'is_new'=>1,'msg_to'=>$_COOKIE['AUTH_MEMBER_NAME']))->count();
        }
        $this->msgCount=$newMsgCount;

        $_SESSION["file_info"] = array();
        $this->assign('session_id', session_id());

    }
}