<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午6:47
 */
namespace Admin\Model;
use Think\Model;
class BrokerAvatarModel extends Model{
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
    function getList($pageLimit, $fileld='*' ,$where='', $order='id desc') {
        $result=$this->where($where)->field($fileld)->order($order)->limit($pageLimit)->select();

        return $result;
    }
    /**
     * 删除信息
     * @param mixed $ids ID列表
     * @access public
     * @return bool
     */
    function deleteInfo($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' id in (' . $ids . ')';
        } else {
            $where = ' id=' . intval($ids);
        }
        return $this->where($where)->delete();
    }
    /**
     * 操作用户状态 不物理删除
     * @param mixed $members 用户ID
     * @access public
     * @return bool
     */
    function changeStatus($ids,$status) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' id in (' . $ids . ')';
        } else {
            $where = ' id=' . intval($ids);
        }
        return $this->where($where)->save(array('status'=>$status));
    }

    /**
     * 取得详细信息
     * @access public
     * @param int $id
     * @return array
     */
    function getInfo($id,$field = '*'){
        return $this->where(array('id'=>$id))->field($field)->find();
    }
}