<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/22
 * Time: 下午3:15
 */
namespace Common\Model;
use Think\Model;
class AssessmentModel extends Model{
    protected $tableName='pinggu';

    /**
     * 根据值取
     *
     * @param string $dd_name
     * @param int $di_value
     * @return array
     */
    function getItemByValue($dd_name,$di_value)
    {
        $dd_id = M('pinggu_dd')->where(array('dd_name' => $dd_name))->getField('dd_id');
        return M('pinggu_dd_item')->where(array('dd_id' => $dd_id, 'di_value' => $di_value))->find();
    }
    /**
     * 返回字典项列表
     * @param int $dd_name 字典名字
     * @access public
     * @return array
     */
    public function getItemListByName($dd_name) {
        $dd_id=M('pinggu_dd')->where(array('dd_name'=>$dd_name))->getField('dd_id');
        return M('pinggu_dd_item')->where(array('dd_id'=>$dd_id))->order('list_order ASC')->select();

    }
    /**
     * 最后一个，默认
     *
     * @param string $dd_name
     * @return array
     */
    function getLast($dd_name)
    {
        $dd_id=M('pinggu_dd')->where(array('dd_name'=>$dd_name))->getField('dd_id');
        return M('pinggu_dd_item')->where(array('dd_id'=>$dd_id))->order('di_value desc')->select();

    }
    /**
     * 更新价格
     *
     */
    function refreshPrice($pinggu_id)
    {
        $di_quotiety = 0;
        $pinggu_info = M('pinggu')->where(array('id'=>$pinggu_id))->find();

        if(!$pinggu_info){
            return ;
        }
        //评估价
        $borough = M('borough');
        $borough_evaluate=$borough->where(array('id'=>$pinggu_info['borough_id']))->getField('borough_evaluate');//小区评估价
        $borough_evaluate=$borough->where(array('id'=>$pinggu_info['borough_id']))->getField('borough_avgprice');//小区均价
        $evaluate_price=$borough_evaluate?$borough_evaluate:$borough_evaluate;

        if(!$evaluate_price){//如果borough表中没有borough_evaluate则不评估 小区评估价
            $this->error('此小区系统暂未收录交易平均基价无法评估,请联系025-66078688进行咨询');
            return ;
        }
        //类型
        $house_type_dd=$this->getItemByValue('house_type',$pinggu_info['house_type']);
        if($house_type_dd['di_quotiety']){
            $di_quotiety += $house_type_dd['di_quotiety'];
        }
        //朝向
        $house_toward_dd = $this->getItemByValue('house_toward',$pinggu_info['house_toward']);
        if($house_toward_dd['di_quotiety']){
            $di_quotiety += $house_toward_dd['di_quotiety'];
        }
        //面积
        $house_totalarea_dd = $this->getItemListByName('house_totalarea');
        foreach ($house_totalarea_dd as $item){
            //print_rr($item);
            $tmp = explode('-',$item['di_caption']);
            if($tmp[1]){
                if($tmp[0]<=$pinggu_info['house_totalarea'] && $tmp[1]>=$pinggu_info['house_totalarea'] ){
                    $di_quotiety += $item['di_quotiety'];
                    break;
                }
            }else{
                if($tmp[0]<$pinggu_info['house_totalarea']){
                    $di_quotiety += $item['di_quotiety'];
                }
            }
        }

        //位置
        if($pinggu_info['house_place']){
            $house_place_dd = $this->getItemByValue('house_place',$pinggu_info['house_place']);
            if($house_place_dd['di_quotiety']){
                $di_quotiety += $house_place_dd['di_quotiety'];
            }
        }
        //同风
        if($pinggu_info['house_light']){
            $house_light_dd = $this->getItemByValue('house_light',$pinggu_info['house_light']);
            if($house_place_dd['di_quotiety']){
                $di_quotiety += $house_light_dd['di_quotiety'];
            }
        }

        //景观
        if($pinggu_info['house_view']){
            $house_view_dd = $this->getItemByValue('house_view',$pinggu_info['house_view']);
            if($house_view_dd['di_quotiety']){
                $di_quotiety += $house_view_dd['di_quotiety'];
            }
        }

        //噪音情况
        if($pinggu_info['house_noise']){
            $house_noise_dd = $this->getItemByValue('house_noise',$pinggu_info['house_noise']);
            if($house_noise_dd['di_quotiety']){
                $di_quotiety += $house_noise_dd['di_quotiety'];
            }
        }

        //建筑质量
        if($pinggu_info['house_quality']){
            $tmp = explode(",",$pinggu_info['house_quality']);
            foreach ($tmp as $item){
                if($item==''){
                    continue;
                }
                $house_quality_dd = $this->getItemByValue('house_quality',$item);
                if($house_quality_dd['di_quotiety']){
                    $di_quotiety += $house_quality_dd['di_quotiety'];
                }
            }
        }

        //楼层 ， 有电梯
        if($pinggu_info['has_lift']){
            $has_lift_dd = $this->getItemByValue('house_floorlift',$pinggu_info['house_floor']);
            if($has_lift_dd){
                $di_quotiety += $has_lift_dd['di_quotiety'];
            }else{
                // 6层以上每3层递增0.02
                $di_quotiety +=(intval(($pinggu_info['house_floor']-6)/3)+1)*0.02;
            }
        }
        //别墅不判断楼层
        if($pinggu_info['house_type'] == 1 || $pinggu_info['house_type'] == 2 || $pinggu_info['house_type'] == 3){
            //楼层 ， 无电梯 。有架空
            if(!$pinggu_info['has_lift'] && $pinggu_info['has_empty']){
                $house_floornoliftempty_dd = $this->getItemByValue('house_floornoliftempty',$pinggu_info['house_floor']);
                if($house_floornoliftempty_dd){
                    if($house_floornoliftempty_dd['di_quotiety']){
                        $di_quotiety += $house_floornoliftempty_dd['di_quotiety'];
                    }
                }else{
                    $house_floornoliftempty_dd = $this->getLast('house_floornoliftempty');
                    if($house_floornoliftempty_dd['di_quotiety']){
                        $di_quotiety += $house_floornoliftempty_dd['di_quotiety'];
                    }
                }
            }
            //楼层 ， 无电梯 ，无架空
            if(!$pinggu_info['has_lift'] && !$pinggu_info['has_empty']){
                $house_floornoliftnoempty_dd = $this->getItemByValue('house_floornoliftnoempty',$pinggu_info['house_floor']);
                if($house_floornoliftnoempty_dd){
                    if($house_floornoliftnoempty_dd['di_quotiety']){
                        $di_quotiety += $house_floornoliftnoempty_dd['di_quotiety'];
                    }
                }else{
                    $house_floornoliftnoempty_dd = $this->getLast('house_floornoliftnoempty');
                    if($house_floornoliftnoempty_dd['di_quotiety']){
                        $di_quotiety += $house_floornoliftnoempty_dd['di_quotiety'];
                    }
                }
            }
        }
        p($di_quotiety);

        //更新数据库

        $house_pgprice = round($evaluate_price*$pinggu_info['house_totalarea']/10000,2);
        $house_avgprice = round($evaluate_price/0.78);
        $house_avgpgprice = round($evaluate_price);
        $house_totalprice = round($house_avgprice*$pinggu_info['house_totalarea']/10000,2);
        //装修 ，只补交易价格
        if($pinggu_info['fitment_price'] && $pinggu_info['fitment_year']){
            $house_totalprice = $house_totalprice +round((8-$pinggu_info['fitment_year'])/8*$pinggu_info['fitment_price'],2);
        }
        $house_avgprice = round($house_totalprice*10000/$pinggu_info['house_totalarea']);
        $updateField = array(
            'house_totalprice'=>$house_totalprice,
            'house_avgprice'=>$house_avgprice,
            'house_pgprice'=> $house_pgprice,
            'house_avgpgprice'=> $house_avgpgprice
        );
        M('pinggu')->where(array('id'=>$pinggu_id))->save($updateField);//评估价出来了插入数据库

    }

    /**
     * 取字典项名称
     * @param string $name 字典名
     * @param string $value 值
     * @access public
     * @return array
     */
    public function getCaption($name, $value) {
        if($value ==''){
            return '';
        }
        $array = getArrayAssessment($name);
        if (strpos($value,',')===false) {
            return $array[$value];
        } else {
            $values = explode(',',$value);
            $result = '';
            foreach ($values as $v) {
                if ($v) {
                    $result .= $array[$v] . ' ';
                }
            }
        }
        return $result;
    }
}