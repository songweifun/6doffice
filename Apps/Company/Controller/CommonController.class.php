<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午5:44
 */
namespace Company\Controller;
use Think\Controller;
Class CommonController extends Controller{
    public function _initialize(){
        $page=$this;
        require(APP_PATH.'Common/commonphp/page.php');

        $company=D('Company');
        $authSuc = false;
        $back_to = $_SERVER['REQUEST_URI'];
        //p($back_to);die;
        if ($_COOKIE['AUTH_COMPANY_STRING']) {
            if (!$_COOKIE['AUTH_CHECKTIME']) {
                // 间隔AUTH_CHECKTIME时间检查一次cookie信息是否和数据库一至
                $authInfo = $company->getAuthInfo();
                $user = $company->where(array('id'=>$authInfo['id'],'passwd'=>$authInfo['passwd']))->find();
                if ($user['id']) {
                    $authSuc = true;
                    setcookie('AUTH_CHECKTIME',1, time()+C('AUTH_TIME'));

                }
            } else {
                $authSuc = true;
            }
            $user_type = $company->getAuthInfo('type');
            if($user_type == 1 ){
                if(strpos($back_to,'owner') != ""){
                    $back_to = str_replace('owner','member',$back_to);
                    header("location:".$back_to);
                }
            }else{
                if(strpos($back_to,'member') != 0){
                    $back_to = str_replace('member','owner',$back_to);

                    header("location:".$back_to);
                }
            }
        }
        if ($authSuc===false) {
            //$this->redirect('Login/index',array('back_to'=>$back_to));
            //$this->//($cfg['url'].'company/login/login.php?back_to='.$back_to);
            $this->redirect('Login/index');

        }

    }
}