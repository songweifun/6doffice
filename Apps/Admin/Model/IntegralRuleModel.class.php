<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/26
 * Time: 下午10:18
 */
namespace Home\Model;
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
    function add($member_id,$rule_id){
        $member= D('Member');
        $ruleInfo = $this->getInfo($rule_id);
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

}