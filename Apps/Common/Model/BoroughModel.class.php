<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/26
 * Time: 下午5:04
 */

namespace Common\Model;
use Think\Model;
class BoroughModel extends Model{


    /**
     * @param $borough_id
     * @param $imgType 图片类型true:draw,false:pic $getType
     * @param int $num
     * @return mixed
     */
    function getImgList($borough_id,$imgType,$num = 0)
    {
        if($imgType){
            if($num){
                return M('borough_draw')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }else{
                return M('borough_draw')->where(array('borough_id'=>$borough_id))->select();
            }
        }else{
            if($num){
                return M('borough_pic')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }else{
                return M('borough_pic')->where(array('borough_id'=>$borough_id))->select();
            }
        }
    }



    /**
     * 根据条件删选相应的字段
     * @param $where
     * @param string $field
     * @return mixed
     */
    function getInfo($where, $field = '') {
        $arr=$this->field($field)->where($where)->find();
        return $arr[$field];
    }

    /**
     * 取用户列表
     * @param array limit
     * @param Enum $flag 0：全部 ， 1：已审核 ，2：未审核
     * @access public
     * @return array
     */
    function getList($pageLimit,$flag = 0,$where_clouse = '',$order='') {
        $where ='1 = 1' ;
        if($where_clouse){
            $where .= $where_clouse;
        }
        if($flag == 1){
            $where .= " and is_checked = 1";
        }
        if($flag == 2){
            $where .= " and is_priceoff = 1 and is_checked = 1";
        }
        if($flag == 3){
            $where .= " and is_promote = 1";
        }
        if($flag == 4){
            $where .= " and (sell_time>'".date('Y-m-d')."' or sell_time ='' )";
        }
        if($flag == 5){
            $where .= " and is_checked = 0";
        }
        $result=$this->where($where)->order($order)->limit($pageLimit)->select();

        return $result;
    }



    /**
     * 取总用户数
     * @access public
     * @return NULL
     */
    function getCount($flag = 0,$where_clouse = '') {
        $where ="1 = 1";
        if($where_clouse){
            $where .= $where_clouse;
        }
        if($flag == 1){
            $where .= " and is_checked = 1";
        }
        if($flag == 2){
            $where .= " and is_priceoff = 1";
        }
        if($flag == 3){
            $where .= " and is_promote = 1";
        }
        if($flag == 4){
            $where .= " and (sell_time>'".date('Y-m-d')."' or sell_time ='' )";
        }
        if($flag == 5){
            $where .= " and is_checked = 0";
        }
        return $this->where($where)->count();

    }

    /**
     * 修改缩略图数据
     * @param $borough_id
     * @param $borough_thumb
     * @return bool
     */
    function  updateThumb($borough_id,$borough_thumb)
    {
        //return $this->db->execute("update ".$this->tName." set borough_thumb='".$borough_thumb."' where id=".$borough_id);
        return $this->where(array('id'=>$borough_id))->save(array('borough_thumb'=>$borough_thumb));
    }

    /**
     * 取得新盘动态列表
     * @param $boroughId
     * @return mixed
     */
    function getNewsList($boroughId) {
        $result=M('borough_news')->where(array('borough_id'=>$boroughId))->order('time desc')->select();

        return $result;
    }

    /**
     * 取意向登记人数
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function getIntentionCount($where_clouse = '') {
        $where ="1 = 1";
        if($where_clouse){
            $where .= $where_clouse;
        }
        //return $this->db->getValue('select count(*) from '.$this->tNameIntention. $where );
        return M('borough_intention')->where($where)->count();
    }

    /**
     * 增加房源数
     * @param $borough_id
     * @param string $type
     * @return bool
     */
    function  increase($borough_id,$type = 'sell_num')
    {
        //return $this->db->execute("update ".$this->tName." set ".$type."=".$type."+1 where id=".$borough_id);
        return $this->where(array('id'=>$borough_id))->setInc($type,1);
    }

    /**
     * 添加楼盘购买意向
     * @param array $Intention 基本表单数组
     * @access public
     * @return bool
     */
    function saveIntention($fileddata) {
        if($fileddata['link_type']){
            $fileddata['link_type'] = ','.implode(',',$fileddata['link_type']).',';
        }
        $field_array = array(
            'borough_id'=>intval($fileddata['borough_id']),
            'link_type'=>$fileddata['link_type'],
            'content'=>$fileddata['content'],
            'nickname'=>$fileddata['nickname'],
            'gender'=>intval($fileddata['gender']),
            'mobile'=>$fileddata['mobile'],
            'age'=>intval($fileddata['age']),
            'qq'=>$fileddata['qq'],
            'tel'=>$fileddata['tel'],
            'email'=>$fileddata['email'],
            'postcode'=>$fileddata['postcode'],
            'address'=>$fileddata['address'],
            'addtime'=>time(),
        );
        //return $this->db->insert($this->tNameIntention,$field_array);
        return M('borough_intention')->add($fileddata);
    }

}