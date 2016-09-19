<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/19
 * Time: 下午12:09
 */
namespace Common\Model;
use Think\Model;
class BrokerFriensRelationModel extends Model\RelationModel{
    protected $tableName='broker_friends';
    public $_link=array(
        'member'=>array(
            'mapping_type'=>self::HAS_ONE,
            'mapping_name'=>'member',
            'foreign_key'=>'id',
        )

    );
}