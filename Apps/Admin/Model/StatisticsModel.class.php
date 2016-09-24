<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午5:43
 */
namespace Admin\Model;
use Think\Model;
class StatisticsModel extends Model{
    /**
     * 取所有统计信息
     * @access public
     * @return array
     */
    function getAll($classname='') {
        if($classname){
            return $this->where(array('stat_class'=>$classname))->select();
        }else{
            return $this->select();
        }
    }
}