<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/25
 * Time: 下午2:39
 */
namespace Admin\Model;
use Think\Model;
class WebConfigModel extends Model{
    /**
     * 取得详细信息
     * @access public
     * @param int $id
     * @return array
     */
    function getInfo($id,$field = '*'){
        return $this->field($field)->where(array('id'=>$id))->find();
    }

}