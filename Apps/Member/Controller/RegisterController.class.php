<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/21
 * Time: 下午11:20
 */
namespace Member\Controller;
use Think\Controller;
class RegisterController extends Controller{
    /**
     * 注册页面
     */
    public function index(){
        $this->display();
    }
}