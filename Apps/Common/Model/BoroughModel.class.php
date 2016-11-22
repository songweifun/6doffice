<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/26
 * Time: 下午5:04
 */

namespace Common\Model;
use Think\Model;
class BoroughModel extends Model{


    /**
     * @param $borough_id
     * @param $imgType 图片类型true:draw,false:pic $getType
     * @param int $num
     * @return mixed
     */
    function getImgList($borough_id,$imgType,$num = 0)
    {
        if($imgType){
            if($num){
                return M('borough_draw')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }else{
                return M('borough_draw')->where(array('borough_id'=>$borough_id))->select();
            }
        }else{
            if($num){
                return M('borough_pic')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }else{
                return M('borough_pic')->where(array('borough_id'=>$borough_id))->select();
            }
        }
    }



    /**
     * 根据条件删选相应的字段
     * @param $where
     * @param string $field
     * @return mixed
     */
    function getInfo($where, $field = '') {
        $arr=$this->field($field)->where($where)->find();
        return $arr[$field];
    }

    /**
     * 取用户列表
     * @param array limit
     * @param Enum $flag 0：全部 ， 1：已审核 ，2：未审核
     * @access public
     * @return array
     */
    function getList($pageLimit,$flag = 0,$where_clouse = '',$order='') {
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

        return $result;
    }



    /**
     * 取总用户数
     * @access public
     * @return NULL
     */
    function getCount($flag = 0,$where_clouse = '') {
        $where ="1 = 1";
        if($where_clouse){
            $where .= $where_clouse;
        }
        if($flag == 1){
            $where .= " and is_checked = 1";
        }
        if($flag == 2){
            $where .= " and is_priceoff = 1";
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