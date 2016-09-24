<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午3:24
 */
namespace Admin\Controller;
use Think\Controller;
class HouseManageController extends CommonController{
    public function _initialize()
    {
        $this->cate=CONTROLLER_NAME;  //分配栏目
    }
    /**
     * 出售管理
     */
    public function sell(){



        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 出租管理
     */
    public function rent(){


        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 求购管理
     */
    public function buy(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 求租管理
     */
    public function hold(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 委托出售
     */
    public function consign(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }
    /**
     * 虚假举报
     */
    public function report(){
        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }

}
