<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/20
 * Time: 上午10:28
 */
namespace Admin\Model;
use Think\Model;
class BoroughModel extends Model{
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
                return M('borough_draw')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }
        }else{
            if($num){
                return M('borough_pic')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }else{
                return M('borough_pic')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }
        }
    }

    /**
     * 插入房源图片到小区图片 ，从房源中上传
     * @param $fileddata
     * @return mixed
     */
    function insertPic($fileddata)
    {
        return M('borough_pic')->add($fileddata);
    }

    /**
     * 插入户型图到小区图片 ，从房源中上传
     * @param $fileddata
     * @return mixed
     */
    function insertDrawing($fileddata)
    {
        return M('borough_draw')->add($fileddata);
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
     * 删除小区信息
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function deleteBorough($ids) {

        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = 'id in (' . $ids . ')';
            $where2 = 'borough_id in (' . $ids . ')';
        } else {
            $where = 'id=' . intval($ids);
            $where2 = 'borough_id=' . intval($ids);
        }
        $nohouseidarr=$this->field('id')->where($where.' and sell_num =0 and rent_num = 0 ')->select();
        $nohouseid=array();
        foreach($nohouseidarr as $v){
            $nohouseid[]=$v['id'];

        }
        //p($nohouseid);die;
        if(!empty($nohouseid)){
            $nohouseid = implode(',',$nohouseid);
            $deletewhere = 'id in (' . $nohouseid . ')';
            $deletewhere1 = 'borough_id in (' . $nohouseid . ')';
            M('borough')->where($deletewhere)->delete();
            M('borough_info')->where($deletewhere)->delete();
            M('borough_pic')->where($deletewhere1)->delete();
            M('borough_draw')->where($deletewhere1)->delete();
            M('borough_update')->where($deletewhere1)->delete();
            M('borough_evaluate')->where($deletewhere1)->delete();
            M('borough_avgprice')->where($deletewhere1)->delete();
            M('pinggu')->where($deletewhere1)->delete();
            return true;
        }else{
            return false;
        }
    }

    /**
     * 取小区信息
     * @param string $id 小区ID
     * @param string $field 主表字段
     * @param enum $more_info  是否取出详细的信息
     * @access public
     * @return array
     */
    function getInfo($id, $field = '*',$more_info = 0,$merge=false) {
        $borough = $this->where(array('id'=>$id))->field($field)->find();
        if($more_info){
            $boroughInfo=M('borough_info')->where(array('id'=>$id))->find();
            if($merge){
                return array_merge((array)$borough,(array)$boroughInfo);
            }else{
                return array('borough'=>$borough,'boroughInfo'=>$boroughInfo);
            }
        }else{
            return $borough;
        }
    }

}