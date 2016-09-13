<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/24
 * Time: 上午9:52
 */
namespace Common\Model;
use Think\Model\ViewModel;
class MemberViewModel extends ViewModel{
    protected $tableName='member';

    public $viewFields = array(
        'member'=>array('*'),
        'broker_info'=>array('*','_on'=>'member.id=broker_info.id'),


    );

    /**
     * 获取用户信息
     * @param $id
     * @param string $field
     * @param bool|false $moreInfo
     * @return mixed
     */
    public function getInfo($id,$field='*',$moreInfo=false){
        if(!$moreInfo){
            $this->viewFields=array(
                'member'=>array('*'),
            );
            $userInfo=$this->field($field)->find($id);
        }else{
            $userInfo=$this->field($field)->find($id);
        }
        return $userInfo;
    }


    /**
     * 取当前用户信息cookie中的
     * @access public
     * @return array
     */
    public function getAuthInfo($field=NULL) {
        $authInfo = authcode($_COOKIE['AUTH_MEMBER_STRING'], 'DECODE', C('AUTH_KEY'));
        $authInfo = explode("\t",$authInfo);
        $result['id'] = $authInfo[0];
        $result['passwd'] = $authInfo[1];
        $result['user_type'] = $authInfo[2];
        if ($_COOKIE['AUTH_MEMBER_NAME']) {
            $result['username'] = $_COOKIE['AUTH_MEMBER_NAME'];
        }
        if ($_COOKIE['AUTH_MEMBER_REALNAME']) {
            $result['realname'] = $_COOKIE['AUTH_MEMBER_REALNAME'];
        }

        if ($field) {
            if ($result[$field]) {
                return $result[$field];
            } else {
                $this->viewFields = array(
                    'member'=>array('*'),
                    'broker_info'=>array('*','_on'=>'member.id=broker_info.id'),


                );
                //$userInfo = M('member')->find($result['id']);
                //$detailInfo = M('broker_info')->find($result['id']);
                //$info= array_merge((array)$userInfo,(array)$detailInfo);
                $info=$this->find($result['id']);
                return $info[$field];
            }
        }
        return $result;
    }


}