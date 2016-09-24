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
}