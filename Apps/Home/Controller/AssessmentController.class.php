<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午10:01
 */
namespace Home\Controller;
use Think\Controller;
class AssessmentController extends CommonController{
    public function index(){
        //字典
        $house_type_option = getArrayAssessment('house_type');
        $this->assign('house_type_option', $house_type_option);

        //特色
        $house_toword_option = getArrayAssessment('house_toward');
        $this->assign('house_toword_option', $house_toword_option);
        $this->display();
    }
}