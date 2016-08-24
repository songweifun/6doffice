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
            $this->redirect(MODULE_NAME.'/Login/login');

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

    }
}