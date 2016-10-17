<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/20
 * Time: 上午10:28
 */
namespace Admin\Model;
use Think\Model;
class BoroughModel extends Model{
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
                return M('borough_draw')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }
        }else{
            if($num){
                return M('borough_pic')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }else{
                return M('borough_pic')->where(array('borough_id'=>$borough_id))->limit($num)->select();
            }
        }
    }

    /**
     * 插入房源图片到小区图片 ，从房源中上传
     * @param $fileddata
     * @return mixed
     */
    function insertPic($fileddata)
    {
        return M('borough_pic')->add($fileddata);
    }

    /**
     * 插入户型图到小区图片 ，从房源中上传
     * @param $fileddata
     * @return mixed
     */
    function insertDrawing($fileddata)
    {
        return M('borough_draw')->add($fileddata);
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
     * 删除小区信息
     * @param mixed $ids 选择的ID
     * @access public
     * @return bool
     */
    function deleteBorough($ids) {

        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = 'id in (' . $ids . ')';
            $where2 = 'borough_id in (' . $ids . ')';
        } else {
            $where = 'id=' . intval($ids);
            $where2 = 'borough_id=' . intval($ids);
        }
        $nohouseidarr=$this->field('id')->where($where.' and sell_num =0 and rent_num = 0 ')->select();
        $nohouseid=array();
        foreach($nohouseidarr as $v){
            $nohouseid[]=$v['id'];

        }
        //p($nohouseid);die;
        if(!empty($nohouseid)){
            $nohouseid = implode(',',$nohouseid);
            $deletewhere = 'id in (' . $nohouseid . ')';
            $deletewhere1 = 'borough_id in (' . $nohouseid . ')';
            M('borough')->where($deletewhere)->delete();
            M('borough_info')->where($deletewhere)->delete();
            M('borough_pic')->where($deletewhere1)->delete();
            M('borough_draw')->where($deletewhere1)->delete();
            M('borough_update')->where($deletewhere1)->delete();
            M('borough_evaluate')->where($deletewhere1)->delete();
            M('borough_avgprice')->where($deletewhere1)->delete();
            M('pinggu')->where($deletewhere1)->delete();
            return true;
        }else{
            return false;
        }
    }

    /**
     * 取小区信息
     * @param string $id 小区ID
     * @param string $field 主表字段
     * @param enum $more_info  是否取出详细的信息
     * @access public
     * @return array
     */
    function getInfo($id, $field = '*',$more_info = 0,$merge=false) {
        $borough = $this->where(array('id'=>$id))->field($field)->find();
        if($more_info){
            $boroughInfo=M('borough_info')->where(array('id'=>$id))->find();
            if($merge){
                return array_merge((array)$borough,(array)$boroughInfo);
            }else{
                return array('borough'=>$borough,'boroughInfo'=>$boroughInfo);
            }
        }else{
            return $borough;
        }
    }

    /**
     * 保存小区信息
     * @param array $borough 基本表单数组
     * @param array $boroughInfo 详细表单数组
     * @access public
     * @return bool
     */
    function saveBorough($fileddata) {

        $fileddata['boroughInfo']['borough_support'] = implode(',',(array)$fileddata['boroughInfo']['borough_support'] );
        $fileddata['boroughInfo']['borough_sight'] = implode(',',(array)$fileddata['boroughInfo']['borough_sight'] );

        $fileddata['borough']['borough_letter'] = GetPinyin($fileddata['borough']['borough_name'].$fileddata['borough']['borough_alias'],1);
        $fileddata['borough']['updated'] = time();
        if(!$fileddata['borough']['borough_thumb']){
            //没有上传缩略图
            if(is_array($fileddata['borough_picture_thumb'])){
                $fileddata['borough']['borough_thumb']  = $fileddata['borough_picture_thumb'][0];
            }
        }
        if($fileddata['id']){
            //编辑
            $borough_id= intval($fileddata['id']);
            $borough=$this->where(array('id'=>$borough_id))->find();//
            if($fileddata['borough']['layout_map']) {
                $this->updateMap($borough_id,$fileddata['borough']['layout_map']);
            }
            $this->where(array('id'=>$borough_id))->save($fileddata['borough']);
            M('borough_info')->where(array('id'=>$borough_id))->save($fileddata['boroughInfo']);

            if($borough['cityarea_id']!=$fileddata['borough']['cityarea_id']||$borough['cityarea2_id']!=$fileddata['borough']['cityarea2_id']){
                //改变区域同时更新买卖租赁表
                D('Houserent')->where(array('borough_id'=>$borough_id))->save(array('cityarea_id'=>$fileddata['borough']['cityarea_id'],'cityarea2_id'=>$fileddata['borough']['cityarea2_id']));
                D('Housesell')->where(array('borough_id'=>$borough_id))->save(array('cityarea_id'=>$fileddata['borough']['cityarea_id'],'cityarea2_id'=>$fileddata['borough']['cityarea2_id']));
            }
            //照片
            M('borough_pic')->where(array('borough_id'=>$borough_id))->delete();
            if(is_array($fileddata['borough_picture_url'])){
                foreach($fileddata['borough_picture_url'] as $key => $pic_url){
                    $imgField = array(
                        'pic_url'=>$pic_url,
                        'pic_thumb'=>$fileddata['borough_picture_thumb'][$key],
                        'pic_desc'=>$fileddata['borough_picture_desc'][$key],
                        'borough_id'=>$borough_id,
                        'creater'=>$fileddata['creater'],
                        'addtime'=>time(),
                    );
                    M('borough_pic')->add($imgField);
                }
            }
            //户型图
            M('borough_draw')->where(array('borough_id'=>$borough_id))->delete();
            if(is_array($fileddata['borough_drawing_url'])){
                foreach($fileddata['borough_drawing_url'] as $key => $pic_url){
                    $imgField = array(
                        'pic_url'=>$pic_url,
                        'pic_thumb'=>$fileddata['borough_drawing_thumb'][$key],
                        'pic_desc'=>$fileddata['borough_drawing_desc'][$key],
                        'borough_id'=>$borough_id,
                        'creater'=>$fileddata['creater'],
                        'addtime'=>time(),
                    );
                    M('borough_draw')->add($imgField);
                }
            }
        }else{
            //增加

            //判断是否已经存在该小区
            $boroughId = $this->getIdByName($fileddata['borough']['borough_name']);
            if($boroughId){
                $this->error('该小区已存在数据库中，请不要重复添加');
            }

            $fileddata['borough']['is_checked'] = 1;
            $fileddata['borough']['creater'] = $fileddata['creater'];
            $fileddata['borough']['created'] = time();
            $borough_id=$this->add($fileddata['borough']);

            $fileddata['boroughInfo']['id'] = $borough_id;
            M('borough_info')->add($fileddata['boroughInfo']);
            if(is_array($fileddata['borough_picture_url'])){
                foreach($fileddata['borough_picture_url'] as $key => $pic_url){
                    $imgField = array(
                        'pic_url'=>$pic_url,
                        'pic_thumb'=>$fileddata['borough_picture_thumb'][$key],
                        'pic_desc'=>$fileddata['borough_picture_desc'][$key],
                        'borough_id'=>$borough_id,
                        'creater'=>$fileddata['creater'],
                        'addtime'=>time(),
                    );
                    M('borough_pic')->add($imgField);
                }
            }
            if(is_array($fileddata['borough_drawing_url'])){
                foreach($fileddata['borough_drawing_url'] as $key => $pic_url){
                    $imgField = array(
                        'pic_url'=>$pic_url,
                        'pic_thumb'=>$fileddata['borough_drawing_thumb'][$key],
                        'pic_desc'=>$fileddata['borough_drawing_desc'][$key],
                        'borough_id'=>$borough_id,
                        'creater'=>$fileddata['creater'],
                        'addtime'=>time(),
                    );
                    M('borough_draw')->add($imgField);
                }
            }
        }
        //图片数量
        $borough_pic_num=M('borough_pic')->where(array('borough_id'=>$borough_id))->count();
        $borough_draw_num = M('borough_draw')->where(array('borough_id'=>$borough_id))->count();
        $this->where(array('id'=>$borough_id))->save(array('layout_picture'=>$borough_pic_num,'layout_drawing'=>$borough_draw_num));

        return true;
    }

    /**
     * 修改收集地图数据
     * @param $borough_id
     * @param $mapPoint
     * @return bool
     */
    function  updateMap($borough_id,$mapPoint){
        $mapPoint1=str_ireplace(array('(',')','',''),'',$mapPoint);
        $data=explode(',',$mapPoint1);
        return $this->where(array('id'=>$borough_id))->save(array('layout_map'=>$mapPoint,'lat'=>$data[0],'lng'=>$data[1]));
        //return $this->db->execute('update '.$this->tName." set layout_map='".$mapPoint."' , lat = '".$data[0]."',lng='".$data[1]."'  where id=".$borough_id);

    }

    /**
     * 通过小区名字取小区ID  。 下拉选择小区使用
     * @param string $borough_name 小区名字
     * @access public
     * @return int id
     */
    function getIdByName($borough_name) {
        return $this->where(array('borough_name'=>array('like',"%".$borough_name."%")))->getField('id');
        //return $this->db->getValue("select id from ".$this->tName."  where borough_name like '%".$borough_name."%'");
    }

}