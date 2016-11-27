<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/11/27
 * Time: 下午10:16
 */
namespace Admin\Model;
use Think\Model;
class GroupModel extends Model{
    /**
     * 取用户级选择框
     * @param int $value 用户组ID
     * @access public
     * @return void
     */
    function getSelect($value) {
        $array = require('./Conf/groups.cfg.php');
        $html = '<select name="group_id">';
        foreach ($array as $key => $v) {
            if ($key==$value) {
                $selected = ' selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $key . '"' . $selected . '>' . $v . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

}