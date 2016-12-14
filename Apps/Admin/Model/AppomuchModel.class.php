<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/12/14
 * Time: 下午10:48
 */
namespace Admin\Model;
use Think\Model;
class AppomuchModel extends Model{
    public function updateapp($appo_value,$appo_name){

        $this->where(array('appo_name'=>$appo_name))->save(array('appo_value'=>$appo_value));

    }
}