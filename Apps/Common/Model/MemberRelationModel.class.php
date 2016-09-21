<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/22
 * Time: 下午10:14
 */
namespace Common\Model;
use Think\Model;
use Think\Model\RelationModel;
class MemberRelationModel extends RelationModel{
    protected $tableName = 'member';

    protected $_link=array(
        'broker_info'=>array(
            'mapping_type'=>self::HAS_ONE,
            'mapping_name'=>'broker_info',
            'foreign_key'=>'id',
        ),
    );

    /**
     * 取用户信息
     * @param string $memberId 用户ID
     * @param string $field 字段
     * @access public
     * @return array
     */
    public function getInfo($memberId, $field = '*',$moreInfo=false) {
        if($moreInfo){
            $userInfo = M('member')->field($field)->find($memberId);

            $detailInfo = M('broker_info')->field($field)->find($memberId);

            return array_merge((array)$userInfo,(array)$detailInfo);

        }else{
            return  M('member')->field($field)->find($memberId);
        }

    }

    /**
     * 增加积分
     */
    public function addScore($member_id,$scores){
        //echo $member_id;die;
        $oldscores=$this->where(array('id'=>$member_id))->getField('scores');
        //p($oldscores);die;
        return M('member')->where(array('id'=>$member_id))->setField('scores',$oldscores+$scores);
    }

}