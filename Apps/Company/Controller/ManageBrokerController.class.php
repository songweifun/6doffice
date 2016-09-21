<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午9:07
 */
namespace Company\Controller;
use Think\Controller;
class ManageBrokerController extends CommonController{
    /**
     * 经纪人列表
     */
    public function index(){
        $this->display();
    }
}