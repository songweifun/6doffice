<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/26
 * Time: 下午5:04
 */

namespace Member\Model;
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

}