<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/12/21
 * Time: 下午4:29
 */
namespace Admin\Model;
use Think\Model;
class MapModel extends Model{

    /**
     * 取得信息列表
     * @access public
     *
     * @param array $pageLimit
     * @return array
     **/
    function getList($fileld='*' ,$where='', $order=' sort asc ') {
        $result=$this->where($where)->field($fileld)->order($order)->select();

        return $result;
    }

    /**
     * 取类别总数
     * @access public
     * @return int
     */
    function getCount($where = '') {
        return $this->where($where)->count();
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
     * 保存信息
     * @param string $field
     * @access public
     * @return array
     */
    function saveInfo($field) {
        if ($field['id']) {
            $updateArray=array (
                'cityarea_name' =>  $field['cityarea_name'],
                'lat' => $field['lat'],
                'lnt' => $field['lnt'],
                'sort' => $field['sort'],
            );
            $this->where(array('id'=>intval($field['id'])))->save($updateArray);

        } else {
            $insertArray=array(
                'cityarea_name' =>  $field['cityarea_name'],
                'lat' => $field['lat'],
                'lnt' => $field['lnt'],
                'sort' => $field['sort'],
            );
            $this->add($insertArray);

        }
    }

    /**
     * 删除信息
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function deleteInfo($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' id in (' . $ids . ')';
        } else {
            $where = 'id=' . intval($ids);
        }
        return $this->where($where)->delete();
    }



}