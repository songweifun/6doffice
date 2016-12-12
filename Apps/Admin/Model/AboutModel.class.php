<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/12/12
 * Time: 下午8:09
 */
namespace Admin\Model;
use Think\Model;
class AboutModel extends Model{

    /**
     * 取得详细信息
     * @access public
     * @param int $id
     * @return array
     */
    function getInfo($id,$field = '*'){
        return $this->where(array('id'=>$id))->getField('content');
    }

    /**
     * 保存网站信息
     * @access public
     * @param int $id
     * @return array
     */
    function saveInfo($id,$fileddata){
        $this->where(array('id'=>$id))->save(array('content'=>$fileddata));
    }
}