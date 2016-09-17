<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/17
 * Time: 下午7:01
 */
namespace Home\Controller;
use Think\Controller;
class BaiduMapController extends CommonController{
    public function index(){
        $borough_id=I('get.id');
        $borough = M('borough');
        $boroughInfo = $borough->where(array('id'=>$borough_id))->find();
        $this->borough_address=$boroughInfo['borough_address'];
        $this->display();
    }
}