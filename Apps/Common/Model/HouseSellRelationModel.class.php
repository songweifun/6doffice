<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/22
 * Time: 下午10:14
 */
namespace Common\Model;
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
        /*'housesell_stat'=>array(
            'mapping_type'=>self::HAS_ONE,
            'mapping_name'=>'housesell_stat',
            'foreign_key'=>'house_id',

        ),
        'housesell_bargain'=>array(
            'mapping_type'=>self::HAS_ONE,
            'mapping_name'=>'housesell_bargain',
            'foreign_key'=>'house_id',

        ),*/
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

        $this->where(array('id'=>array('in',$ids),'created'=>array('egt',$to_day)))->save(array('updated'=>$now_time,'update_order'=>$now_time+14400));
        $this->where(array('id'=>array('in',$ids),'created'=>array('lt',$to_day)))->save(array('updated'=>$now_time,'update_order'=>$now_time));

        return true;
    }

    /**
     *  删除房源信息
     * @param $ids
     * @return bool
     */
    function deleteSell($ids) {

        $this->_link=array(
            'housesell_pic'=>array(
                'mapping_type'=>self::HAS_MANY,
                'mapping_name'=>'housesell_pic',
                'foreign_key'=>'housesell_id',
            ),
            'housesell_stat'=>array(
                'mapping_type'=>self::HAS_MANY,
                'mapping_name'=>'housesell_stat',
                'foreign_key'=>'house_id',

            ),
            'housesell_bargain'=>array(
                'mapping_type'=>self::HAS_ONE,
                'mapping_name'=>'housesell_bargain',
                'foreign_key'=>'house_id',

            ),
        );

        //更新统计数据
        $broughId=$this->field('borough_id')->where(array('id'=>array('in',$ids)))->select();
        //p($broughId);die();
        foreach ($broughId as $key=> $item){
            D('Borough')->where(array('id'=>$item['borough_id']))->setDec('sell_num',1);
            M('statistics')->where(array('stat_index'=>'sellNum'))->setDec('stat_value',1);
        }
        foreach($ids as $id){
            $this->relation(true)->delete($id);//关联模型删除图片 静态信息 成交纪录
        }
        return true;
    }

    /**
     * 增加点击数 ， 需要增加总数和每天点击数
     * @param $house_id
     * @return bool
     */
    function addClick($house_id)
    {
        $today = date("Y-m-d", time());
        $stat_id = M('housesell_stat')->where(array('house_id' => $house_id, 'stat_date' => $today))->getField('id');
        if ($stat_id) {
            M('housesell_stat')->where(array('id' => $stat_id))->setInc('click_num', 1);
        } else {
            M('housesell_stat')->data(array('house_id' => $house_id, 'click_num' => 1, 'stat_date' => $today))->add();
        }
        return $this->where(array('id' => $house_id))->setInc('click_num', 1);
    }





    }