<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/23
 * Time: 下午6:52
 */
namespace Admin\Controller;
use Think\Controller;
class WebConfigController extends CommonController{
    public function webConfig(){
        $config=M('web_config');
        $webConfig = $config->where(array('id'=>1))->find();
        $this->assign('webConfig', $webConfig);
        $this->display();
    }
}