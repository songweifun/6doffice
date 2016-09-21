<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午9:02
 */
namespace Company\Controller;
use Think\Controller;
class ManageCompanyController extends CommonController{
    /**
     * 信息管理
     */
    public function profile(){
        $this->display();

    }

    /**
     * 修改密码
     */
    public function pwdEdit(){
        $this->display();

    }
}