<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/17
 * Time: 下午7:33
 */
namespace Tool\Controller;
use Think\Controller;
class IndexController extends Controller{
    /**
     * 贷款计算器
     */
    public function gfnl(){
        $this->display();
    }

    /**
     * 税费计算
     */
    public function sf(){
        $this->display();
    }
    /**
     * 等额本息还款
     */
    public function debx(){
        $this->display();
    }
    /**
     * 等额本金还款
     */
    public function debj(){
        $this->display();
    }
    /**
     * 公积金贷款计算
     */
    public function gjjdk(){
        $this->display();
    }
    /**
     * 提前还款计算
     */
    public function tqhd(){
        $this->display();
    }

}