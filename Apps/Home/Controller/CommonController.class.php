<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/12
 * Time: 下午3:58
 */
namespace Home\Controller;
use Think\Controller;
Class CommonController extends Controller{
    public function _initialize(){//用一重

        $page=$this;
        require(APP_PATH.'Common/commonphp/page.php');

        $realname = $_COOKIE['AUTH_MEMBER_REALNAME'] ? $_COOKIE['AUTH_MEMBER_REALNAME'] :$_COOKIE['AUTH_MEMBER_NAME'];
        $this->assign('username',$realname);
        if($_COOKIE['AUTH_MEMBER_STRING']){
            $member = D('MemberView');
            $user_type = $member->getAuthInfo('user_type');
            $this->assign('user_type',$user_type);
        }

        $newMsgCount = 0;
        if($_COOKIE['AUTH_MEMBER_NAME']) {
            $where['to_del'] = 0;
            $where['is_new'] = 1;
            $where['msg_to'] = $_COOKIE['AUTH_MEMBER_NAME'];
            $where['_logic'] = 'AND';
            $map['_complex'] = $where;
            $map['msg_to'] = $_COOKIE['AUTH_MEMBER_REALNAME'];
            $map['_logic'] = "OR";//用户名或者真是姓名都可以
            $newMsgCount = M('innernote')->where($map)->count();
        }
        $this->assign('msgCount',$newMsgCount);
        $this->host=$_SERVER['SERVER_NAME'];


    }
}