<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/24
 * Time: 上午10:17
 */

namespace Member\Model;
use Think\Model\ViewModel;
class HouseRentViewModel extends ViewModel{
    protected $tableName='houserent';

    public $viewFields = array(
        'houserent'=>array('*'),
        //'houserent_pic'=>array('*','_on'=>'houserent.id=houserent_pic.houserent_id'),
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

        return M('houserent')->where($where)->count();
    }


    /**
     * @param $house_id
     * @param $date
     * @return array|mixed|null
     */
    function getClick($house_id , $date)

    {
        return M('houserent_stat')->where(array('house_id'=>$house_id,'stat_date'=>$date))->getField('click_num');
    }


}