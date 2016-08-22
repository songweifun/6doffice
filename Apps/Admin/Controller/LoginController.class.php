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
    }

    /**
     * 验证码
     */
    public function verify(){
        $Verify = new \Think\Verify();
        $Verify->fontSiz=40;
        $Verify->entry();
    }
}