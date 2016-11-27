<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/11/27
 * Time: 下午8:41
 */
namespace Admin\Model;
use Think\Model;
class HousesellTrendModel extends Model{

    /**
     * 取类别总数
     * @access public
     * @return int
     */
    function getCount($where = '') {

        return $this->where($where)->count();
    }


    /**
     * 取得信息列表
     * @access public
     *
     * @param array $pageLimit
     * @return array
     **/
    function getList($pageLimit, $fileld='*' ,$where='', $order='time desc ') {

        $result=$this->field($fileld)->where($where)->order($order)->limit($pageLimit)->select();
        return $result;
    }


    /**
     * 保存信息
     * @param string $field
     * @access public
     * @return array
     */
    function saveTrend($field) {
        if ($field['id']) {
            $this->where(array('id'=>intval($field['id'])))->save(array (
                'time' =>  $field['timestr'],
                'price' => $field['price'],
                'area' => $field['area'],
                'number' => $field['number'],
            ));
        } else {
            $this->add(array(
                    'time' =>  $field['timestr'],
                    'price' => $field['price'],
                    'area' => $field['area'],
                    'number' => $field['number'],
                )
            );
        }
    }

    /**
     * 取信息
     * @param string $id
     * @param string $field
     * @access public
     * @return array
     */
    function getInfo($id, $field = '*') {
        return $this->where(array('id'=>$id))->field($field)->find();
    }


    /**
     * 删除信息
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function deleteTrend($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = 'id in (' . $ids . ')';
        } else {
            $where = 'id=' . intval($ids);
        }

        return $this->where($where)->delete();
    }


}