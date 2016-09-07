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
}