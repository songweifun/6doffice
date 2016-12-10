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

}