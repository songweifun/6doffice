<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午5:22
 */
namespace Company\Controller;
use Think\Controller;
class LoginController extends Controller{
    /**
     * 登录页模板
     */
    public function index(){
       $page=$this;
        require(APP_PATH.'Common/commonphp/page.php');
       $this->title = $this->title.' - 公司登陆';
        $this->display();
    }

    /**
     * 登录验证
     */
    public function login(){
        $username=I('post.username');
        $passwd=I('post.passwd');
        if(!$username || !$passwd) $this->error('请输入用户名和密码','',1);
        if ($username && $passwd) {
            $company=D('company');
            $info =$company->where(array('username'=>$username))->find();
            if(!$info){
                $this->error('用户名不存在','',1);
            }elseif(strtolower($info['passwd'])!=md5($passwd)){
                $this->error('密码错误！','',1);
            }else{
                if (isset($_POST['notForget']) && intval($_POST['notForget'])==1) {
                    setcookie('AUTH_COMPANY_FORGET',$username,time()+60*60*24*365,'/','');
                }
                $auth_code = authcode($info['id']. "\t" . md5($passwd). "\t" .$info['type'], 'ENCODE',C('AUTH_KEY'));
                setcookie('AUTH_COMPANY_STRING',$auth_code,0,'/','');
                $_COOKIE['AUTH_COMPANY_STRING'] = $auth_code;
                setcookie('AUTH_COMPANY_NAME',$username,0,'/','');
                $_COOKIE['AUTH_COMPANY_NAME'] = $username;
                $this->success('登录成功',U('Index/index'));

            }


        }//&& end
    }

    /**
     * 退出登录
     */
    public function logout(){
        $company=D('company');

        if($_COOKIE['AUTH_COMPANY_STRING']){
            $uid = $company->getAuthInfo('id');
        }
        setcookie('AUTH_COMPANY_STRING', 0, time()-1,'/','');
        setcookie('AUTH_COMPANY_NAME',0,time()-1,'/','');
        $this->redirect('Login/index');

    }
}