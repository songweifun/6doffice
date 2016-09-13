<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/13
 * Time: 下午3:30
 */
namespace Common\Model;
use Think\Model;
class DdItemModel extends Model{

    protected $tableName="dd_item";

    /**
     * 返回字典子项列表
     * @param int $dd_id 字典ID
     * @access public
     * @return array
     */
    public function getSonList($di_value) {
        $p_id=$this->where(array('di_value'=>intval($di_value),'p_id'=>0,'dd_id'=>1))->getField('di_id');
        return $this->where(array('p_id'=>$p_id,'dd_id'=>1))->order('list_order ASC')->select();
    }

}