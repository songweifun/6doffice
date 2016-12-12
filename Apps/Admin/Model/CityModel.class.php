<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午6:40
 */
namespace Admin\Model;
use Think\Model;
class CityModel extends Model{
    protected $tName = "city";
    protected $tNameUnion = "union";
    /**
     * 取加盟信息类别总数
     * @access public
     * @return NULL
     */
    function getCountUnion($flag = 0,$where_clouse = '') {
        $where ="1 = 1";
        if($flag == 1){
            $where .= " and status = 0 ";
        }
        if($flag == 2){
            $where .= " and status = 1 ";
        }
        if($flag == 3){
            $where .= " and status = 2 ";
        }

        if($where_clouse){
            $where.= $where_clouse;
        }

        return M('union')->where($where)->count();
    }

    /**
     * 取类别总数
     * @access public
     * @return int
     */
    function getCount($where = '') {
        return $this->where($where)->count();

    }

    /**
     * 取得信息列表
     * @access public
     *
     * @param array $pageLimit
     * @return array
     **/
    function getList($pageLimit, $fileld='*' ,$where='', $order='id asc ') {

        $result=$this->where($where)->field($fileld)->order($order)->limit($pageLimit)->select();

        return $result;
    }

    /**
     * 取得详细信息
     * @access public
     * @param int $id
     * @return array
     */
    function getInfo($id,$field = '*'){
        return $this->where(array('id'=>$id))->field($field)->find();
    }


    /**
     * 保存信息
     * @access public
     *
     * @param array $memberInfo
     * @return bool
     **/
    function saveInfo($info){
        $info['id']=intval($info['id']);
        if(!$info['id']){
            $insertField = array(
                'name'=>$info['name'],
                'url'=>$info['url'],
                'logo'=>$info['logo'],
                'is_proxy'=>$info['is_proxy'],
                'pid'=>$info['pid'],
                'is_hot'=>$info['is_hot'],
                'add_time'=>time(),

            );
            $this->add($insertField);

        }else{
            $updateField  = array(
                'name'=>$info['name'],
                'url'=>$info['url'],
                'logo'=>$info['logo'],
                'pid'=>$info['pid'],
                'is_hot'=>$info['is_hot'],
                'is_proxy'=>$info['is_proxy'],
            );
            $this->where(array('id'=>$info['id']))->save($updateField);

        }
    }

    /**
     * 删除信息
     * @param mixed $ids ID列表
     * @access public
     * @return bool
     */
    function deleteInfo($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' id in (' . $ids . ')';
        } else {
            $where = ' id=' . intval($ids);
        }
        return $this->where($where)->delete();
    }


    /**
     * 操作用户状态 不物理删除
     * @param mixed $members 用户ID
     * @access public
     * @return bool
     */
    function changeStatus($ids,$status) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' id in (' . $ids . ')';
        } else {
            $where = ' id=' . intval($ids);
        }
        return $this->where($where)->save(array('status'=>$status));
    }

    /**
     * 取加盟信息列表
     * @param array limit
     * @access public
     * @return array
     */
    function getListUnion($pageLimit,$fileld='*' , $flag = 0,$where_clouse = '',$order='') {
        $where ='1 = 1' ;
        if($where_clouse){
            $where .= $where_clouse;
        }
        if($flag == 1){
            $where .= " and status = 0 ";
        }
        if($flag == 2){
            $where .= " and status = 1 ";
        }
        if($flag == 3){
            $where .= " and status = 2 ";
        }
        $result=M('union')->where($where)->order($order)->limit($pageLimit)->select();

        return $result;
    }

    /**
     * 删除加盟信息
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function deleteUnion($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' where id in (' . $ids . ')';
        } else {
            $where = ' where id=' . intval($ids);
        }
        M('union')->where($where)->delete();
        return true;

    }

    /**
     * 修改加盟信息状态
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function checkUnion($ids,$flag) {
        $where = ' where 1=1 ';
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where .= ' and id in (' . $ids . ')';
        } else {
            $where .= ' and id=' . intval($ids);
        }
        return  M('union')->where($where)->save(array('status'=>$flag));

    }
}