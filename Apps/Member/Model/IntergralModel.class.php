<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/29
 * Time: 下午10:57
 */

namespace Member\Model;
use Think\Model;
class IntegralModel extends Model{
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
        $member= M('MemberRelation');
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
        $this->table($this->tNameLog)->add($insertField);
    }

    /**
     * 取得详细信息
     * @access public
     * @param int $id
     * @return array
     */
    function getInfo($id,$field = '*'){
        return $this->query('select '.$field.' from '.$this->tName.' where id =' .$id);
    }
}