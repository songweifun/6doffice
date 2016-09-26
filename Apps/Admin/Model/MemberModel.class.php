<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午6:24
 */
namespace Admin\Model;
use Think\Model;
class MemberModel extends Model{
    /**
     * 取类别总数
     * @access public
     * @return int
     */
    function getCount($where = '') {

        return $this->where($where)->count();
    }

    /**
     * 增加积分
     */
    public function addScore($member_id,$scores){
        $oldscores=$this->where(array('id'=>$member_id))->getField('scores');
        return $this->where(array('id'=>$member_id))->setField('scores',$oldscores+$scores);
    }

    /**
     * 取用户信息
     * @param string $memberId 用户ID
     * @param string $user_type 用户类型
     * @access public
     * @return array
     */
    function getRealName($memberId,$user_type) {
        return M('broker_info')->where(array('id'=>$memberId))->getField('realname');

    }

    /**
     * 取用户信息
     * @param string $memberId 用户ID
     * @param string $field 字段
     * @access public
     * @return array
     */
    function getInfo($memberId, $field = '*',$moreInfo=false) {
        if($moreInfo){
            $userInfo = $this->where(array('id'=>$memberId))->field($field)->find();
            $detailInfo = M('broker_info')->field($field)->where(array('id'=>$memberId))->find();


            return array_merge((array)$userInfo,(array)$detailInfo);

        }else{
            return $this->where(array('id'=>$memberId))->field($field)->find();
        }

    }
}