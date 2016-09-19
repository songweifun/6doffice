<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/19
 * Time: 下午1:01
 */
namespace Common\Model;
use Think\Model;
class ShopViewlogModel extends Model{
    protected $tableName='shop_viewlog';

    public function addLog($broker_id,$friend_id){
        $timeBefore = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $timeEnd = mktime(0,0,0,date('m'),date('d')+1,date('Y'));
        $logId=$this->where(array('broker_id'=>$broker_id,'friend_id'=>$friend_id,'add_time'=>array('gt',$timeBefore),'add_time'=>array('lt',$timeEnd)))->getField('id');
        if($logId){
            $click_num=$this->where(array('id'=>$logId))->getField('click_num');
            return $this->where(array('id'=>$logId))->save(array('add_time'=>time(),'click_num'=>$click_num+1));
        }else{
            $insertField = array(
                'broker_id' => $broker_id,
                'friend_id' =>$friend_id,
                'click_num'=>1,
                'add_time' =>time()
            );
            return $this->add($insertField);
        }
    }
}