<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 下午7:14
 */
namespace Company\Model;
use Think\Model;
class CompanyModel extends Model{
    /**
     * 取当前用户信息
     * @access public
     * @return array
     */
    function getAuthInfo($field=NULL) {
        $authInfo = authcode($_COOKIE['AUTH_COMPANY_STRING'], 'DECODE', C('AUTH_KEY'));
        $authInfo = explode("\t",$authInfo);
        $result['id'] = $authInfo[0];
        $result['passwd'] = $authInfo[1];
        $result['type'] = $authInfo[2];
        if ($_COOKIE['AUTH_COMPANY_NAME']) {
            $result['username'] = $_COOKIE['AUTH_COMPANY_NAME'];
        }

        if ($field) {
            if ($result[$field]) {
                return $result[$field];
            } else {
                $info = $this->where(array('id'=>$result['id']))->find();
                return $info[$field];
            }
        }
        return $result;
    }
}