<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/26
 * Time: 下午10:18
 */
namespace Admin\Model;
use Think\Model;
class IntegralRuleModel extends Model{

    /**
     * 根据类型获得积分规则
     * @param $id
     * @param string $field
     * @return mixed
     */
    function getInfo($id,$field = '*'){
        return $this->field($field)->where(array('id'=>$id))->find();
    }

    /**
     * 按规则增加积分
     * @param mixed|string $member_id
     * @param array $rule_id
     */
    function addScore($member_id,$rule_id){
        $member= D('Member');
        $ruleInfo = $this->getInfo($rule_id);
        //p($ruleInfo);die;
        $member->addScore($member_id,$ruleInfo['rule_score']);
        //log
        $insertField = array(
            'member_id'=>$member_id,
            'rule_id'=>$rule_id,
            'rule_class'=>$ruleInfo['rule_class'],
            'rule_score'=>$ruleInfo['rule_score'],
            'add_time'=>time()
        );
        M('integral_log')->add($insertField);
    }


    /**
     * 察看用户是不是已经得到这个加分
     *
     * @param int $member_id
     * @param int $rule_id
     * @return array
     */
    function getLogByRuleId($member_id,$rule_id)
    {
        return M('integral_log')->where(array('member_id'=>$member_id,'rule_id'=>$rule_id))->find();
        //return $this->db->getValue("select * from ".$this->tNameLog." where member_id=".$member_id." and rule_id=".rule_id);
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
     * 保存信息
     * @access public
     *
     * @param array $memberInfo
     * @return bool
     **/
    function saveIntergraRule($info){
        $info['id']=intval($info['id']);
        if(!$info['id']){
            $insertField = array(
                'rule_name'=>$info['rule_name'],
                'rule_class'=>$info['rule_class'],
                'rule_score'=>$info['rule_score'],
                'rule_remark'=>$info['rule_remark'],
                'rule_status' =>0,
            );
            return $this->add($insertField);
        }else{
            $updateField = array(
                'rule_name'=>$info['rule_name'],
                'rule_class'=>$info['rule_class'],
                'rule_score'=>$info['rule_score'],
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