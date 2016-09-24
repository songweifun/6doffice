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
}