<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/26
 * Time: 下午4:47
 */
namespace Common\Model;
use Think\Model\ViewModel;
class BoroughViewModel extends ViewModel{
    protected $tableName='borough';
    public $viewFields = array(
        'borough'=>array('*','_type'=>'LEFT'),
        'borough_info'=>array('*', '_on'=>'borough.id=borough_info.id'),
        //'User'=>array('name'=>'username', '_on'=>'Blog.user_id=User.id'),
    );

    /**
     * 取得所有符合条件的用户
     *
     * @param string $columns
     * @param string $condition
     * @param string $order
     * @return array
     */
    function getFields($columns='*',$condition='',$order = ''){

        $arr=  $this->field($columns)->where($condition)->order($order)->select();
        $arr2=array();
        foreach($arr as $v){
            $arr2[]=$v['id'];

        }
        return $arr2;

        //return $this->db->select('select '.strtolower($columns).' from '.$this->tName.$condition.' '.$order);
    }


    /**
     * 取用户列表
     * @param array limit
     * @param Enum $flag 0：全部 ， 1：已审核 ，2：未审核
     * @access public
     * @return array
     */
    function getListDetail($pageLimit,$flag = 0,$where_clouse = '',$order='') {
        $where ='1 = 1' ;
        if($where_clouse){
            $where .= $where_clouse;
        }
        if($flag == 1){
            $where .= " and is_checked = 1";
        }
        if($flag == 2){
            $where .= " and is_priceoff = 1 and is_checked = 1";
        }
        if($flag == 3){
            $where .= " and is_promote = 1";
        }
        if($flag == 4){
            $where .= " and (sell_time>'".date('Y-m-d')."' or sell_time ='' )";
        }
        if($flag == 5){
            $where .= " and is_checked = 0";
        }
        $result=$this->where($where)->order($order)->limit($pageLimit)->select();
//        $sql = "select * from ".$this->tName." as b
//			left join ".$this->tNameInfo." as i
//			on b.id = i.id
//			".$where.' '.$order;
//        $this->db->open($sql , $pageLimit['rowFrom'],$pageLimit['rowTo']);
//        $result = array();
//        while ($rs = $this->db->next()) {
//            $result[] = $rs;
//        }
        return $result;
    }


    function getCount($flag = 0,$where_clouse = ''){
        $where ='1 = 1' ;
        if($where_clouse){
            $where .= $where_clouse;
        }
        if($flag == 1){
            $where .= " and is_checked = 1";
        }
        if($flag == 2){
            $where .= " and is_priceoff = 1 and is_checked = 1";
        }
        if($flag == 3){
            $where .= " and is_promote = 1";
        }
        if($flag == 4){
            $where .= " and (sell_time>'".date('Y-m-d')."' or sell_time ='' )";
        }
        if($flag == 5){
            $where .= " and is_checked = 0";
        }
        return $this->where($where)->count();
    }



}