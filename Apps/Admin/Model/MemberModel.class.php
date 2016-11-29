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
        return $this->where(array('id'=>$member_id))->setField('scores',$oldscores[0]+$scores);
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

    /**
     * 根据用户名取用户ID
     *
     * @param string $username
     * @return int
     */
    function getIdByUsername($username)
    {
        return $this->where(array('username'=>$username))->getField('id');
    }

    /**
     * 根据字段来搜索用户名信息 ， 返回array id
     *
     * @param string $field
     * @param string $keyword
     * @return array
     */
    function searchMember($field,$keyword)
    {
        switch($field){
            case "realname":
                $result=M('broker_info')->field('id')->where(array('realname'=>array('like','%'.$keyword.'%')))->select();
                return arr2ToArr1($result);


                break;
            case "tel":
                $condition['mobile']=array('like','%'.$keyword.'%');
                $condition['com_tell']=array('like','%'.$keyword.'%');
                $condition['_logic']='or';
                $result=M('broker_info')->field('id')->where($condition)->select();
                return arr2ToArr1($result);

                break;
            case "idcard":
                $result=M('broker_info')->field('id')->where(array('idcard'=>array('like','%'.$keyword.'%')))->select();
                return arr2ToArr1($result);

                break;
            case "com":
                $condition['company']=array('like','%'.$keyword.'%');
                $condition['outlet']=array('like','%'.$keyword.'%');
                $condition['_logic']='or';
                $result=M('broker_info')->field('id')->where($condition)->select();
                return arr2ToArr1($result);


                break;
            case "avatar":
                $result=M('broker_info')->field('id')->where(array('avatar'=>array('neq','')))->select();
                return arr2ToArr1($result);

                break;
            case "identity":
                $result=M('broker_info')->field('id')->where(array('idcard'=>array('neq','')))->select();
                return arr2ToArr1($result);

                break;
            default:
                break;
        }
    }

    /**
     * 取得member信息列表
     * @param $pageLimit
     * @param string $fileld
     * @param string $where
     * @param string $order
     * @return mixed
     */
    function getList($pageLimit, $fileld='*' ,$where='', $order='id desc') {


        $result=$this->where($where)->field($fileld)->order($order)->limit($pageLimit)->select();
        return $result;
    }

    /**
     * 取的用户扩展信息
     * @param $memberId
     * @param $user_type
     * @return mixed
     */
    function getMoreInfo($memberId,$user_type)
    {

        return M('broker_info')->where(array('id'=>$memberId))->find();


    }

    /**
     * 修改用户信息 ，区别于直接保存全部信息，这里如果需要修改用户的基本信息和详细信息，需要执行两次的操作
     * 例如：
     * $member->updateInfo($id , $basicArray, $isInfo=false ,$user_type=1);
     * $member->updateInfo($id , $extentArray, $isInfo=true ,$user_type=1);
     *
     * @param int $id
     * @param array $fieldArray
     * @param bool $isInfo
     * @param 1 or 2 $user_type
     */
    function updateInfo($id , $fieldArray, $isInfo=false ,$user_type=1){
        if($isInfo){

            //$this->db->update($this->tNameBrokerInfo,$fieldArray,' id ='.$id);
            return M('broker_info')->where(array('id'=>$id))->save($fieldArray);
        }else{
            //$this->db->update($this->tName,$fieldArray,' id ='.$id);
            return $this->where(array('id'=>$id))->save($fieldArray);
        }

    }


    /**
     * 修改积分
     */
    function updateScore($member_id,$scores){
        //return $this->db->execute("update ".$this->tName." set scores = ".$scores." where id=".$member_id);
        return $this->where(array('id'=>$member_id))->save(array('scores'=>$scores));
    }

    /**
     * 升级vip
     * @param array $days 天数
     * @access public
     * @return bool
     */
    function vipSave($fileddata,$value) {
        $field_array  = array(
            'member_id'=>$fileddata['member_id'],
            'add_time'=>time(),
            'to_time'=>$fileddata['to_time'],
        );

        $config=C('BASE');



        //增加急售标签
        if($value==1){
            $this->where(array('id'=>$fileddata['member_id']))->save(array('vexation'=>$config['vip_vip1_vexation']));
        }
        if($value==2){
            $this->where(array('id'=>$fileddata['member_id']))->save(array('vexation'=>$config['vip_vip2_vexation']));
        }



        //如果有之前有会员vip记录 要删除
        if($this->getVipTime($fileddata['member_id'],'*')){
            $this->deleteVip($fileddata['member_id']);
        }
        $this->where(array('id'=>$fileddata['member_id']))->save(array('vip'=>$value));
        return M('member_vip')->add($field_array);
    }

    /**
     * 查询VIP表字段
     * @param string $memberId 用户ID
     * @param string $field 字段
     * @access public
     * @return array
     */
    function getVipTime($memberId, $field = '*') {
        return M('member_vip')->where(array('member_id'=>$memberId))->field($field)->find();
    }

    /**
     * 删除vip记录
     * @param array $days 天数
     * @access public
     * @return bool
     */
    function deleteVip($id) {
        return M('member_vip')->where(array('member_id'=>$id))->delete();
    }


    /**
     * 用户充值
     * @access public
     * @return bool
     */
    function updatemoney($id,$value) {
        //return $this->db->execute('update '.$this->tName.' set money = money +'.$value.' where id='.$id);
        $money=$this->where(array('id'=>$id))->getField('money');
        return $this->where(array('id'=>$id))->save(array('money'=>$money+$value));
    }


}