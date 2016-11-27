<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/22
 * Time: 下午9:55
 */
namespace Admin\Model;
use Think\Model;
class UsersModel extends Model{
    /**
     * 取当前用户信息
     * @access public
     * @return array
     */
    function getAuthInfo($field=NULL) {

        $authInfo = authcode($_COOKIE['AUTH_STRING'], 'DECODE', C('AUTH_KEY'));
        $authInfo = explode("\t",$authInfo);
        $result['user_id'] = $authInfo[0];
        $result['passwd'] = $authInfo[1];
        if ($field) {
            if ($result[$field]) {
                return $result[$field];
            } else {
                $info=$this->where(array('user_id'=>intval($result['user_id'])))->find();
                return $info[$field];
            }
        }
        return $result;
    }

    /**
     * 取总用户数
     * @access public
     * @return NULL
     */
    function getCount() {
        return $this->count();
    }

    /**
     * 取用户列表
     * @access public
     * @return array
     */
    function getList($pageLimit) {
        return $this->limit($pageLimit)->select();
    }


    function getAllUsers($columns='*',$condition='',$order = ''){

        //return $this->db->select('select '.strtolower($columns) .' from fke_users '.$condition .' ' .$order);
        return $this->field($columns)->where($condition)->order($order)->select();
    }

    /**
     * 保存用户信息
     * @param array $userInfo 表单数组
     * @access public
     * @return bool
     */
    function saveUsers($userInfo) {
        specConvert($userInfo, array('username','email'));//将提交的数据进行html格式编码
        $userInfo['user_id'] = intval($userInfo['user_id']);
        if ($userInfo['user_id']) {// 更新
            if ($userInfo['passwd']) {
                $updatePasswd =  md5($userInfo['passwd']);
            }
            $updateArr=array(
                'username'=>$userInfo['username'],
                'passwd'=>$updatePasswd,
                'email'=>$userInfo['email'],
                'group_id'=>$userInfo['group_id'],
            );
            $result=$this->where(array('user_id'=>$userInfo['user_id']))->save($updateArr);

            $getId = $userInfo['user_id'];
        } else {// 添加
            $insertArr=array(
                'username'=>$userInfo['username'],
                'passwd'=>md5($userInfo['passwd']),
                'email'=>$userInfo['email'],
                'group_id'=>$userInfo['group_id'],

            );

            $result = $this->add($insertArr);

        }
        //$getArr = $this->getGroupRight($userInfo['group_id']);
        //$this->saveRight($getArr,$getId);
        return $result;
    }

    /**
     * 取用户信息
     * @param $userId
     * @param string $field
     * @return mixed
     */
    function getInfo($userId, $field = '*') {
        return $this->where(array('user_id'=>$userId))->field($field)->find();
    }


    /**
     * 删除用户信息
     * @param mixed $users 用户ID
     * @access public
     * @return bool
     */
    function deleteUser($users) {
        $flag = false;
        if (is_array($users)) {
            if (in_array(1, $users)) {
                $flag = true;
            }
            $users = implode(',',$users);
            $where = 'user_id in (' . $users . ')';
        } else {
            if (1==$users) {
                $flag = true;
            }
            $where = 'user_id=' . intval($users);
        }
        if ($flag) {
            throw new Exception('系统管理员不能够被删除！');
        }
        //return $this->db->execute('delete from fke_users where ' . $where);
        return $this->where($where)->delete();
    }

}