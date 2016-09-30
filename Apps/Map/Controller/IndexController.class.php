<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/18
 * Time: 下午10:04
 */
namespace Map\Controller;
use Think\Controller;
class IndexController extends Controller{
    public function rent(){
        $this->display();
    }
    public function marker(){
        $markers=M('borough')->field('lat,lng,id,borough_address,borough_name')->select();
        $this->ajaxReturn($markers);
    }
}