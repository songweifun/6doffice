<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午4:34
 */
namespace Admin\Controller;
use Think\Controller;
class BoroughManageController extends CommonController{
    public function _initialize()
    {
        $this->cate=CONTROLLER_NAME;  //分配栏目
    }

    /**
     * 小区管理列表
     */
    public function index(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 小区审核
     */
    public function check(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 小区更新审核
     */
    public function updateCheck(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 评估价更新
     */
    public function evaluate(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }

    /**
     * 评估系数管理
     */
    public function pingguDd(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }

}