<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/24
 * Time: 下午6:18
 */

namespace Admin\Model;
use Think\Model;
class HousesellModel extends Model{

    /**
     * 取房源列表
     * @param array limit
     * @param Enum $flag 0：全部 ， 1：已审核 ，2：未审核 3:未审核和已通过的 4：未通过的
     * @access public
     * @return array
     */
    function getList($pageLimit,$fileld='*' , $flag = 0,$where_clouse = '',$order='') {
        $where ='1 = 1' ;
        if($where_clouse){
            $where .= $where_clouse;
        }
        if($flag == 1){
            $where .= " and is_checked = 1 ";
        }elseif($flag == 2){
            $where .= " and is_checked = 0 ";
        }elseif($flag == 3){
            $where .= " and (is_checked = 0 or is_checked = 1 )";
        }elseif($flag == 4){
            $where .= " and is_checked = 2";
        }elseif($flag == 5){
            $where .= " and is_index = 1";
        }elseif($flag == 6){
            $where .= " and status = 1";
        }elseif($flag == 7){
            $where .= " and status = 2";
        }elseif($flag == 8){
            $where .= " and status = 3";
        }elseif($flag == 9){
            $where .= " and (status = 4 or status = 7)";
        }
        elseif($flag == 10){
            $where .= " and is_top = 1";
        }
        elseif($flag == 11){
            $where .= " and is_like = 1";
        }
        elseif($flag == 12){
            $where .= " and is_themes = 1";
        }
        elseif($flag == 13){
            $where .= " and created > ".mktime(0,0,0,date('m'),date('d')-2,date('Y'))." and created < ".mktime(0,0,0,date('m'),date('d'),date('Y'));
        }
        $result=$this->field($fileld)->where($where)->order($order)->limit($pageLimit)->select();

        return $result;
    }
    /**
     * 取房源数
     * @access public
     * @return NULL
     */
    function getCount($flag = 0,$where_clouse = '') {
        $where ="1 = 1";
        if($flag == 1){
            $where .= " and is_checked = 1";
        }
        if($flag == 2){
            $where .= " and is_checked = 0";
        }
        if($flag == 3){
            $where .= " and (is_checked = 0 or is_checked = 1 )";
        }
        if($flag == 5){
            $where .= " and is_index= 1";
        }
        if($flag == 6){
            $where .= " and status = 1";
        }if($flag == 7){
            $where .= " and status = 2";
        }if($flag == 8){
            $where .= " and status = 3";
        }if($flag == 9){
            $where .= " and (status = 4 or status = 7)";
        }
        if($flag == 10){
            $where .= " and is_top = 1";
        }
        if($flag == 11){
            $where .= " and is_like = 1";
        }
        if($flag == 12){
            $where .= " and is_themes = 1";
        }
        if($flag == 13){
            $where .= " and created > ".mktime(0,0,0,date('m'),date('d')-2,date('Y'))." and created < ".mktime(0,0,0,date('m'),date('d'),date('Y'));
        }

        if($where_clouse){
            $where.= $where_clouse;
        }
        return $this->where($where)->count();

    }

    /**
     * 取得房源点击数
     * 按天统计
     * @param housell_id
     * @param date
     * @return num
     *
     */
    function getClick($house_id , $date)
    {
        return M('housesell_stat')->where(array('house_id'=>$house_id,'stat_date'=>$date))->getField('click_num');

    }

    /**
     * 图片的列表
     * @param $housesell_id
     * @param string $field
     * @return mixed
     */
    function getImgList($housesell_id,$field = '*')
    {
        return M('housesell_pic')->where(array('housesell_id'=>$housesell_id))->select();

    }

    /**
     * 根据时间删除房源
     * @param $date
     * @return bool
     */
    function dateDel($date){

        list($year, $month, $day) = explode('-', $date);
        if (checkdate($month, $day, $year)) {
            $date =mktime(0,0,0,$month,$day,$year);
            $idsArr=$this->field('id')->where("created <= ".$date)->select();
            foreach($idsArr as $v){
                $ids[]=$v['id'];
            }
            //p($ids);die;
            if($this->deleteSell($ids)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * 删除房源信息
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function deleteSell($ids) {

        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = 'id in (' . $ids . ')';
            $deletewhere = 'id in (' . $ids . ')';
            $deletewhere1 = 'housesell_id in (' . $ids . ')';
            $deletewhere2 = 'house_id in (' . $ids . ')';
        } else {
            $where = 'id=' . intval($ids);
            $deletewhere = 'id='.$ids ;
            $deletewhere1 = 'housesell_id ='.$ids ;
            $deletewhere2 = 'house_id='.$ids;

        }

        //更新统计数据
        $broughId = $this->field('borough_id')->where($where)->select();
        //p($broughId);die;

        foreach ($broughId as $key=> $item){
            D('Borough')->where(array('id'=>$item['borough_id']))->setDec('sell_num',1);
            D('Statistics')->where(array('stat_index'=>'sellNum'))->setDec('stat_value',1);
        }

        //echo 1;die;




        $this->where($deletewhere)->delete();//删除出售表
        M('housesell_pic')->where($deletewhere1)->delete();//删除图片
        M('housesell_stat')->where($deletewhere2)->delete();//删除房源点击
        M('housesell_bargain')->where($deletewhere2)->delete();//删除成交表*/
        return true;

    }

    /**
     * 更新某个字段
     * @param mixed $ids ID
     * @access public
     * @return bool
     */
    function update($ids,$field,$value) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' id in (' . $ids . ')';
        } else {
            $where = ' id=' . intval($ids);
        }
        return $this->where($where)->save(array($field=>$value));
    }

    /**
     * 审核房源
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function check($ids,$flag) {
        $where = '1=1 ';
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where .= ' and id in (' . $ids . ')';
        } else {
            $where .= ' and id=' . intval($ids);
        }
        return $this->where($where)->save(array('is_checked'=>$flag));
    }

    /**
     * 取房源信息
     * @param string $id 小区ID
     * @param string $field 主表字段
     * @access public
     * @return array
     */
    function getInfo($id, $field = '*') {
        return $this->field($field)->where(array('id'=>$id))->find();
    }

    /**
     * 图片数量
     *
     * @param string 出售房源ID $housesell_id
     * @return number
     */
    function getImgNum($housesell_id)
    {
        return M('housesell_pic')->where(array('housesell_id'=>$housesell_id))->count();
    }

}