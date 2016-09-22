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

                if ($user['id']) {//根据cookiez中的用户名密码查找到了
                    //setcookie('AUTH_STRING',authcode($user['user_id'] . "\t" . $user['passwd'], 'ENCODE', C('AUTH_KEY')),0,'/',C('COOKIE_DOMAIN'));
                    setcookie('AUTH_CHECKTIME', 1, time() + C('AUTH_CHECKTIME'),'/',C('COOKIE_DOMAIN'));


                }else{//根据cookiez中的用户名密码了没查找到用户直接退出
                    setcookie('AUTH_MEMBER_STRING', 0, time()-1,'/',C('COOKIE_DOMAIN'));

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
            $where['to_del']=0;
            $where['is_new']=1;
            $where['msg_to']=$_COOKIE['AUTH_MEMBER_NAME'];
            $where['_logic'] = 'AND';
            $map['_complex']=$where;
            $map['msg_to']=$_COOKIE['AUTH_MEMBER_REALNAME'];
            $map['_logic']="OR";//用户名或者真是姓名都可以
            $newMsgCount=M('innernote')->where($map)->count();

            //$newMsgCount=M('innernote')->where(array('to_del'=>0,'is_new'=>1,'msg_to'=>$_COOKIE['AUTH_MEMBER_NAME']))->count();
        }
        $this->msgCount=$newMsgCount;

        $_SESSION["file_info"] = array();
        $this->assign('session_id', session_id());

    }
}