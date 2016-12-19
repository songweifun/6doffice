<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/26
 * Time: 下午6:24
 */
namespace Admin\Model;
use Think\Model;
class MessageRuleModel extends Model{

    /**
     * 取得详细信息
     * @access public
     * @param int $id
     * @return array
     */
    function getInfo($id,$field = '*'){
        return $this->field($field)->where(array('id'=>$id))->find();
    }

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
    function getList($pageLimit, $fileld='*' ,$where='', $order='id desc ') {
        $result=$this->where($where)->field($fileld)->order($order)->limit($pageLimit)->select();

        return $result;
    }

    /**
     * 保存信息
     * @access public
     *
     * @param array $memberInfo
     * @return bool
     **/
    function saveMessageRule($info){
        $info['id']=intval($info['id']);
        if(!$info['id']){
            $insertField = array(
                'rule_name'=>$info['rule_name'],
                'rule_class'=>$info['rule_class'],
                'rule_remark'=>$info['rule_remark'],
                'rule_status' =>0,
            );
            return $this->add($insertField);

        }else{
            $updateField = array(
                'rule_name'=>$info['rule_name'],
                'rule_class'=>$info['rule_class'],
                'rule_remark'=>$info['rule_remark'],
            );
            return $this->where(array('id'=>$info['id']))->save($updateField);

        }
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
        return $this->where($where)->save(array('rule_status'=>$status));
    }

    /**
     * 删除信息
     * @param mixed $ids ID列表
     * @access public
     * @return bool
     */
    function deleteRule($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' id in (' . $ids . ')';
        } else {
            $where = ' id=' . intval($ids);
        }
        return $this->where($where)->delete();
    }

}