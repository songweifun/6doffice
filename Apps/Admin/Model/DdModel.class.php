<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/12/13
 * Time: 下午8:42
 */
namespace Admin\Model;
use Think\Model;
class DdModel extends Model{
    /**
     * 返回字典列表
     * @access public
     * @return array
     */
    public function getList() {
        return $this->order('dd_id asc')->select();
    }

    /**
     * 检查唯一性
     * @param int $info 字典项信息
     * @access public
     * @return array
     */
    public function checkUnique($info) {
        $where['di_value']  = array('eq', $info['di_value']);
        $where['di_caption']  = array('eq',$info['di_caption']);
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
        $map['dd_id']  = array('eq',intval($info['dd_id']));
        $map['di_id']  = array('eq',intval($info['di_id']));
        return M('dd_item')->where($map)->count();


    }

    /**
     * 保存字典项信息
     * @param array $info 字典项信息
     * @access public
     * @return void
     */
    public function saveDd($info) {
        if ($this->checkUnique($info)) {
            throw new Exception('值或名称已经存在！');
        }
        if ($info['di_id']) {
            $updateArray=array (
                'di_value' => $info['di_value'],
                'di_caption' => $info['di_caption'],
            );
            M('dd_item')->where(array('di_id'=>intval($info['di_id'])))->save($updateArray);

        } else {
            $inserArray=array(
                'dd_id' => $info['dd_id'],
                'di_value' => $info['di_value'],
                'di_caption' => $info['di_caption'],
            );
            M('dd_item')->add($inserArray);


        }
        $this->cache($info['dd_id']);
        $this->cache2($info['dd_id']);
    }



    public function saveDd2($info) {
        if ($this->checkUnique($info)) {
            throw new Exception('值或名称已经存在！');
        }
        if ($info['di_id']) {
            $updateArray=array (
                'di_value' => $info['di_value'],
                'di_caption' => $info['di_caption'],
                'p_id' => $info['p_id'],
            );
            M('dd_item')->where(array('di_id'=>intval($info['di_id'])))->save($updateArray);


        } else {
            $inserArray=array(
                'dd_id' => $info['dd_id'],
                'di_value' => $info['di_value'],
                'di_caption' => $info['di_caption'],
                'p_id' => $info['p_id'],
            );

            M('dd_item')->add($inserArray);
        }
        $this->cache($info['dd_id']);
        $this->cache2($info['dd_id']);
    }

    /**
     * 缓存字典信息
     * @param int $dd_id 字典ID
     * @access public
     * @return void
     */
    public function cache($dd_id) {
        $dd_id = intval($dd_id);
        $dd_name=$this->where(array('dd_id'=>$dd_id))->getField('dd_name');
        $array=M('dd_item')->where(array('dd_id'=>$dd_id,'p_id'=>0))->field('di_value,di_caption')->order('list_order asc')->select();

        $fp = fopen('./Conf/dd/' . $dd_name . '.php', 'w');
        fputs($fp, '<?php return '.var_export($array, true) . '; ?>');
        fclose($fp);
    }

    public function cache2($dd_id) {
        $dd_id = intval($dd_id);
        $array=M('dd_item')->where(array('dd_id'=>$dd_id,'p_id'=>array('neq',1)))->field('di_value,di_caption')->order('list_order asc')->select();

        $fp = fopen('./Conf/dd/dd/cityarea2.php', 'w');
        fputs($fp, '<?php return '.var_export($array, true) . '; ?>');
        fclose($fp);
    }

    /**
     * 取字典项信息
     * @param int $di_id 字典项ID
     * @access public
     * @return array
     */
    public function getDiInfo($di_id) {
        return M('dd_item')->where(array('di_id'=>intval($di_id)))->find();
    }

    public function getArea() {
        $class=M('dd_item')->where(array('dd_id'=>1,'p_id'=>0))->order(' list_order ASC')->select();
        foreach($class as $key=>$value){
            $son=M('dd_item')->where(array('dd_id'=>1,'p_id'=>$value['di_id']))->order('list_order ASC')->select();
            foreach($son as $k=>$v){
                $class[$key]['son'][$k]=$v;
            }

        }
        /*$query_sql='select * from fke_dd_item where dd_id=1 and p_id=0 order by list_order ASC';
        $query = mysql_query($query_sql);
        $i=0;
        while ($row = mysql_fetch_array($query)) {
            $class[]=$row;
            $query2_sql="select * from fke_dd_item where dd_id=1 and p_id='".$row['di_id']."' order by list_order ASC";
            $query2 = mysql_query($query2_sql);
            $m=0;
            while ($row2 = mysql_fetch_array($query2)) {
                $class[$i]['son'][$m]=$row2;
                $m++;
            }
            $i++;
        }*/
        //p($class);die;
        return $class;
    }

    /**
     * 返回字典项列表
     * @param int $dd_id 字典ID
     * @access public
     * @return array
     */
    public function getItemList($dd_id) {
        return M('dd_item')->where(array('dd_id'=>intval($dd_id),'p_id'=>0))->order('list_order ASC')->select();
    }

    /**
     * 排序
     *
     * @param array $order_arr
     * @return bool
     */
    function orderBy($order_arr,$dd_id)
    {
        foreach ($order_arr as $key=> $a_order){
            M('dd_item')->where(array('di_id'=>$key))->save(array('list_order'=>$a_order));
        }
        $this->cache($dd_id);
        $this->cache2($dd_id);
        return true;
    }
    /**
     * 分组操作
     *
     * @param array $order_arr
     * @return bool
     */
    function groupBy($order_arr,$dd_id)
    {
        foreach ($order_arr as $key=> $a_order){
            M('dd_item')->where(array('di_id'=>$key))->save(array('list_group'=>$a_order));
        }
        $this->cache($dd_id);
        $this->cache2($dd_id);
        return true;
    }

    /**
     * 删除字典项
     * @param mixed $users 字典项ID
     * @access public
     * @return bool
     */
    public function deleteInfo($dds) {
        if (is_array($dds)) {
            $dds = implode(',',$dds);
            $where = 'di_id in (' . $dds . ')';
        } else {
            $where = 'di_id=' . intval($dds);
        }
        $dd_id=M('dd_item')->where($where)->field('dd_id')->select();


        M('dd_item')->where($where)->delete();
        foreach($dd_id as $k=>$v){
            $this->cache($v['$dd_id']);
            $this->cache2($v['$dd_id']);
        }

    }


}