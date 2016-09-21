<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午8:58
 */
namespace Company\Controller;
use Think\Controller;
class ManageHouseController extends CommonController{
    /**
     * 出售管理
     */
    public function ManageSell(){
        $this->display();
    }
    /**
     * 出租管理
     */
    public function ManageRent(){
        $this->display();
    }
}