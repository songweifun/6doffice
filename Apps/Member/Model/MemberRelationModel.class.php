<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/22
 * Time: 下午10:14
 */
namespace Member\Model;
use Think\Model\RelationModel;
class MemberRelationModel extends RelationModel{
    protected $tableName = 'member';

    protected $_link=array(
        'broker_info'=>array(
            'mapping_type'=>self::HAS_ONE,
            'mapping_name'=>'broker_info',
            'foreign_key'=>'id',
        ),
    );

}