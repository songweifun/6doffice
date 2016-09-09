<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/6
 * Time: 下午6:24
 */
namespace Member\Model;
use Think\Model\RelationModel;
class HouseRentRelationModel extends RelationModel{
    protected $tableName='houserent';
    protected $_link=array(
        'houserent_pic'=>array(
            'mapping_type'=>self::HAS_MANY,
            'mapping_name'=>'houserent_pic',
            'foreign_key'=>'houserent_id',
        ),

    );

    /**
     * 刷新房源
     * @param $ids
     * @param string $now_time
     * @return bool
     */
    function refresh($ids,$now_time='') {

        //分开操作，保证今天发的房源排在刷新房源前面
        $to_day = mktime(0,0,0,date('m'),date('d'),date('Y'));
        if(empty($now_time)){
            $now_time = time();
        }

        $this->where(array('id'=>array('in',$ids),'created'=>array('egt',$to_day)))->save(array('updated'=>$now_time,'update_order'=>$now_time+14400));//四小时优先显示
        $this->where(array('id'=>array('in',$ids),'created'=>array('lt',$to_day)))->save(array('updated'=>$now_time,'update_order'=>$now_time));

        return true;
    }
}