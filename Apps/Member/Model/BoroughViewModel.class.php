<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/26
 * Time: 下午4:47
 */
namespace Member\Model;
use Think\Model\ViewModel;
class BoroughViewModel extends ViewModel{
    protected $tableName='borough';
    public $viewFields = array(
        'borough'=>array('id','name','title'),
        'borough_info'=>array('title'=>'category_name', '_on'=>'borough.id=borough_info.id'),
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



}