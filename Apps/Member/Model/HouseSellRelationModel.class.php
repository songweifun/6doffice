<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/22
 * Time: 下午10:14
 */
namespace Member\Model;
use Think\Model;
use Think\Model\RelationModel;

class HouseSellRelationModel extends RelationModel{
    protected $tableName = 'housesell';

    protected $_link=array(
        'housesell_pic'=>array(
            'mapping_type'=>self::HAS_MANY,
            'mapping_name'=>'housesell_pic',
            'foreign_key'=>'housesell_id',
        ),
    );



}