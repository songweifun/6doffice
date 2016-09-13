<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/24
 * Time: 上午10:17
 */

namespace Common\Model;
use Think\Model\ViewModel;
class HouseSellViewModel extends ViewModel{
    protected $tableName='housesell';

    public $viewFields = array(
        'housesell'=>array('*'),
        'housesell_pic'=>array('*','_on'=>'housesell.id=housesell_pic.housesell_id'),


    );

    /**
     * 取房源数
     * @access public
     * @return NULL
     */
    public function getCount($flag = 0,$where_clouse = '') {
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

        return M('housesell')->where($where)->count();
    }


    /**
     * @param $house_id
     * @param $date
     * @return array|mixed|null
     */
    function getClick($house_id , $date)

    {
        return M('housesell_stat')->where(array('house_id'=>$house_id,'stat_date'=>$date))->getField('click_num');
        //return $this->db->getValue('select click_num from '.$this->tNameStat.' where house_id = '.$house_id.' and stat_date =\''.$date.'\'' );
    }

    /**
     * 取房源列表
     * @param array limit
     * @param Enum $flag 0：全部 ， 1：已审核 ，2：未审核 3:未审核和已通过的 4：未通过的
     * @access public
     * @return array
     */
    function getList($pageLimit,$fileld='*' , $flag = 0,$where_clouse = '',$order='') {
        $where =' where 1 = 1' ;
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
        return M('housesell')->where($where)->order($order)->limit($pageLimit)->select();
    }


}