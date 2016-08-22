<?php
namespace Member\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){

        $nowHour = date('H');
        if($nowHour > 17 || $nowHour < 6){
            $this->nowTime = "晚上";
        }elseif($nowHour > 12){
            $this->nowTime = "下午";
        }else{
            $this->nowTime = "早上";
        }

        $this->display();
    }
}