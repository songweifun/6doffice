<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/29
 * Time: 下午10:57
 */

namespace Member\Model;
use Think\Model;
class IntegralRuleModel extends Model{
    /**
     * 主用户表
     *
     * @var string
     */
    protected $tName = "fke_integral_rule";

    /**
     * 主log表
     *
     * @var string
     */
    protected $tNameLog = "fke_integral_log";

    function add($member_id,$rule_id){
        $member= D('MemberRelation');
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
        //p($insertField);die;
        M('integral_log')->add($insertField);
        //$this->table($this->tNameLog)->add($insertField);//table好像插入不管使,只能用于查询
    }

    /**
     * @param $id
     * @param string $field
     * @return mixed
     */
    function getInfo($id,$field = '*'){
        return $this->table($this->tName)->where(array('id'=>$id))->find();
        //return $this->query('select '.$field.' from '.$this->tName.' where id =' .$id);
    }
}