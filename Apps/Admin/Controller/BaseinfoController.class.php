<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/19
 * Time: 下午6:33
 */
namespace Admin\Controller;
use Think\Controller;
class BaseinfoController extends Controller{
    /**
     * 网站信息
     */
    public function webInfo(){
        //取二手房、小区、租房信息
        $allNum=M('statistics')->where(array('stat_class'=>'allNum'))->select();
        $this->statistics=array_to_hashmap($allNum,'stat_index','stat_value');
        //p($allNum);die();
        $this->display();

    }
}