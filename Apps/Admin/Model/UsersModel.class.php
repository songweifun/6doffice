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

}