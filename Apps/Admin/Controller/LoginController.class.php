<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/14
 * Time: 上午11:16
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Image;

class LoginController extends Controller{
    public function index(){
        $this->display();
    }

    /**
     * 登录验证
     */
    public function login(){
        p($_POST);
        $code=I('post.verify');
        $verify = new \Think\Verify();
        $user=D('Users');
        $username=trim(I('post.name'));
        $passwd=I('post.password');
        $userInfo=$user->where(array('username'=>$username))->find();
        if(!$verify->check($code)) $this->error('验证码错误');
        if(!$userInfo){
            $this->error('用户名不存在');

        }else{
            if($userInfo['passwd']!=md5($passwd)){
                $this->error('密码错误');
            }else{
                if(isset($notForget) && $notForget==1){//记住密码一年
                    //setcookie('AUTH_MEMBER_FORGET',$username,time()+60*60*24*365,'/',C('COOKIE_DOMAIN'));
                    setcookie('AUTH_STRING',authcode($userInfo['user_id'] . "\t" . md5($passwd), 'ENCODE', C('AUTH_KEY')),0,'/',C('COOKIE_DOMAIN'));

                }
                /*$auth_code = authcode($userInfo['user_id']. "\t" . md5($passwd). "\t", 'ENCODE',C('AUTH_KEY'));
                setcookie('AUTH_STRING',$auth_code,0,'/',C('COOKIE_DOMAIN'));
                $_COOKIE['AUTH_STRING'] = $auth_code;
                setcookie('ADMIN_USERID_KSY',$userInfo['user_id'],0,'/',C('COOKIE_DOMAIN'));
                $_COOKIE['ADMIN_USERID_KSY'] = $userInfo['user_id'];*/

                setcookie('AUTH_STRING',authcode($userInfo['user_id'] . "\t" . md5($passwd), 'ENCODE', C('AUTH_KEY')),0,'/',C('COOKIE_DOMAIN'));
                setcookie('ADMIN_USERID_KSY',$userInfo['user_id'],time()+C('AUTH_TIME'),0,'/',C('COOKIE_DOMAIN'));//注意路径
                $this->redirect('Index/index');
            }
        }

    }

    /**
     * 验证码
     */
    public function verify(){
        $Verify = new \Think\Verify();
        $Verify->fontSiz=16;
        $Verify->length   = 1;
        $Verify->useNoise = false;
        $Verify->imageW  = 100;
        $Verify->imageH  = 50;
        $Verify->entry();
    }
    /**
     * 退出登录
     */
    public function logout(){
        setcookie('AUTH_STRING', 0, time()-1,'/',C('COOKIE_DOMAIN'));
        header('location:' . U(MODULE_NAME.'/Login/index'));
    }
}