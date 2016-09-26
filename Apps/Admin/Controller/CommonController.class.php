<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/22
 * Time: 下午10:16
 */
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{

    public function _initialize(){
        $page=$this;
        require(APP_PATH.'Common/commonphp/page.php');

        if ($_COOKIE['AUTH_STRING']) {

            if (!$_COOKIE['AUTH_CHECKTIME']) {
                // 间隔AUTH_CHECKTIME时间检查一次cookie信息是否和数据库一至
                $authInfo = D('Users')->getAuthInfo();
                $user=D('Users')->where(array('user_id'=>$authInfo['user_id'],'passwd'=>$authInfo['passwd']))->find();

                if ($user['user_id']) {//根据cookiez中的用户名密码查找到了
                    //setcookie('AUTH_STRING',authcode($user['user_id'] . "\t" . $user['passwd'], 'ENCODE', C('AUTH_KEY')),0,'/',C('COOKIE_DOMAIN'));
                    setcookie('AUTH_CHECKTIME', 1, time() + C('AUTH_CHECKTIME'),'/',C('COOKIE_DOMAIN'));
                }else{//根据cookiez中的用户名密码了没查找到用户直接退出
                    setcookie('AUTH_STRING', 0, time()-1,'/',C('COOKIE_DOMAIN'));
                }
            }
        }else{

            $this->redirect('Login/index');
        }
    }

}