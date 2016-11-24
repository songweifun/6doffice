<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午5:56
 */
namespace Admin\Model;
use Think\Model;
class CompanyModel extends Model{
    /**
     * 取中介公司总数
     * @access public
     * @return NULL
     */
    function getCount($where_clouse = '') {
        $where ="1 = 1";

        if($where_clouse){
            $where.= $where_clouse;
        }
        return $this->where($where)->count();
    }

    /**
     * 取得中介公司信息列表
     * @access public
     *
     * @param array $pageLimit
     * @return array
     **/
    function getList($pageLimit,$fileld='*' ,$where_clouse = '',$order='') {
        $where ='1 = 1' ;
        if($where_clouse){
            $where .= $where_clouse;
        }
        //$this->db->open('select '.$fileld.' from '.$this->tName.$where.' '.$order , $pageLimit['rowFrom'],$pageLimit['rowTo']);

        return $this->field($fileld)->where($where)->order($order)->limit($pageLimit)->select();
    }

    /**
     * 删除
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function deleteCompany($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = 'id in (' . $ids . ')';
        } else {
            $where = 'id=' . intval($ids);
        }
        //$this->db->execute('delete from '.$this->tName. $where);
        return $this->where($where)->delete();

    }


    /**
     * 操作中介公司状态
     * @param mixed $ids 中介公司ID
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
        return $this->where($where)->setField(array('status'=>$status));
        //return $this->db->execute('update '.$this->tName.' set status = '.$status.' where ' . $where);
    }

    /**
     * 取中介公司详细信息
     * @param string $id 中介公司ID
     * @param string $field 主表字段
     * @access public
     * @return array
     */
    function getInfo($id, $field = '*') {
        //return $this->db->getValue('select ' . $field . ' from '.$this->tName.'  where id=' . $id);
        return $this->field($field)->where(array('id'=>$id))->find();
    }
    /**
     * 存储中介公司
     * @param array $fileddata
     * @access public
     * @return bool
     */
    function saveCompany($fileddata){
        if($fileddata['id']){
            //编辑
            //$this->db->update($this->tName,$fileddata['company'],'id = '.$fileddata['id']);
            $this->where(array('id'=>$fileddata['id']))->save($fileddata['company']);
        } else{
            //增加
            //$this->db->insert($this->tName,$fileddata['company']);
            $this->add($fileddata['company']);
        }
        return true;
    }
}