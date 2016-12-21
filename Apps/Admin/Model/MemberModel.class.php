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
     * 插入扩展用户信息
     * 例如：
     * $member->insertInfo($id , $basicArray, $isInfo=false ,$user_type=1);
     *
     * @param array $fieldArray
     * @param 1 or 2 $user_type
     */
    function insertInfo($fieldArray, $isInfo=false ,$user_type=1){

        //$this->db->insert($this->tNameBrokerInfo,$fieldArray);
        M('broker_info')->add($fieldArray);

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

    /**
     * 操作用户状态 不物理删除
     * @param mixed $members 用户ID
     * @access public
     * @return bool
     */
    function changeStatus($members,$status) {
        if (is_array($members)) {
            $members = implode(',',$members);
            $where = ' id in (' . $members . ')';
        } else {
            $where = ' id=' . intval($members);
        }
        //return $this->db->execute('update '.$this->tName.' set status = '.$status.' where ' . $where);
        return $this->where($where)->setField('status',$status);
    }

    /**
     * 删除用户信息
     * @param mixed $members 用户ID
     * @access public
     * @return bool
     */
    function deleteMember($members) {
        if (is_array($members)) {
            $members = implode(',',$members);
            $where = ' id in (' . $members . ')';
            $shopwhere = ' broker_id in (' . $members . ')';
            $memberwhere = ' member_id in (' . $members . ')';

        } else {
            $where = ' id=' . intval($members);
            $shopwhere = ' broker_id=' . intval($members);
            $memberwhere = ' member_id=' . intval($members);

        }
        $username=$this->where($where)->field('username')->select();
        //$username = $this->db->select('select username from '.$this->tName.' where '.$where);

        //删除出售房源记录
        M('housesell')->where($shopwhere)->delete();

        //删除出租房源记录
        M('houserent')->where($shopwhere)->delete();

        //删除fke_member_loginlog会员登录记录
        foreach ($username as $value){
            M('member_loginlog')->where(array('username'=>$value['username']))->delete();
        }

        //删除会员fke_borker_info 经纪人表信息
        M('broker_info')->where($where)->delete();

        //删除会员fke_borker_identity 经纪人身份认证表信息
        M('broker_identity')->where($shopwhere)->delete();

        //删除会员fke_borker_friends 经纪人好友表信息
        M('broker_friends')->where($shopwhere)->delete();

        //删除会员fke_broker_avatar 经纪人头像表信息
        M('broker_avatar')->where($shopwhere)->delete();


        //删除会员fke_broker_aptitude 经纪人执业认证表信息
        M('broker_aptitude')->where($shopwhere)->delete();


        //删除fke_innernote会员站内信接收记录
        foreach ($username as $value){
            M('innernote')->where(array('msg_to'=>$value['username']))->delete();

        }

        //删除fke_innernote会员站内信发送记录
        foreach ($username as $value){
            M('innernote')->where(array('msg_from'=>$value['username']))->delete();

        }

        //删除会员fke_integral_log 积分记录
        M('integral_log')->where($memberwhere)->delete();


        //如果是经纪人删除fke_shop_conf经纪人网店信息
        M('shop_conf')->where($shopwhere)->delete();


        //删除店铺fke_shop_viewlog 好友信息
        M('shop_viewlog')->where($shopwhere)->delete();


        //删除会员fke_member 表信息
        $this->where($where)->delete();

        return true;


    }

    /**
     * 检查是否有重复的身份证，认证审核时使用
     * @access public
     *
     * @param string $username
     * @return bool
     **/
    function checkIdcardUnique($idcard){
        //return $this->db->getValue('select id from '.$this->tNameBrokerInfo.' where idcard =\''. $idcard.'\'');
        return M('broker_info')->where(array('idcard'=>$idcard))->getField('id');
    }

    /**
     * 取得会员评价信息列表
     * @access public
     *
     * @param array $pageLimit
     * @return array
     **/
    function getEvaluateList($pageLimit, $fileld='*' ,$where='', $order='id desc ') {
        $result=M('broker_evaluate')->where($where)->order($order)->limit($pageLimit)->select();

        return $result;
    }

    /**
     * 删除经纪人评价
     * @param array $days 天数
     * @access public
     * @return bool
     */
    function deleteEvaluate($id) {
        if (is_array($id)) {
            $id = implode(',',$id);
            $where = ' id in (' . $id . ')';

        } else {
            $where = ' id=' . intval($id);
        }
        M('broker_evaluate')->where($where)->delete();
    }


    /**
     * 取得所有类型的用户
     * @param int $user_type
     * @param string $field
     * @return mixed
     * @param int $user_type 1：经纪人；2：业主 0：所有
     */
    function getAll($user_type=0,$field='*'){
        if($user_type ){
            $where = 'user_type = '.$user_type;
        }
        return $this->field($field)->where($where)->select();
    }


}