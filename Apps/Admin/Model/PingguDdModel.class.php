<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/11/19
 * Time: 上午11:18
 */
namespace Admin\Model;
use Think\Model;
class PingguDdModel extends Model{

    //private $tNameItem = M('pinggu_dd_item');//php5不允许对象赋值给属性

    /**
     * 返回字典列表
     * @access public
     * @return array
     */
    public function getList() {
        //return $this->db->select('select * from '.$this->tName);
        return $this->select();
    }

    /**
     * 取字典项信息
     * @param int $di_id 字典项ID
     * @access public
     * @return array
     */
    public function getDiInfo($di_id) {
        //return $this->db->getValue('select * from '.$this->tNameItem.' where di_id='  . intval($di_id));
        return M('pinggu_dd_item')->where(array('di_id'=>intval($di_id)))->find();
    }

    /**
     * 返回字典项列表
     * @param int $dd_id 字典ID
     * @access public
     * @return array
     */
    public function getItemList($dd_id) {
        //return $this->db->select('select * from '.$this->tNameItem.' where dd_id=' . intval($dd_id).' order by list_order ASC');
        return M('pinggu_dd_item')->where(array('dd_id'=>intval($dd_id)))->order('list_order ASC')->select();
    }

    /**
     * 检查唯一性
     * @param int $info 字典项信息
     * @access public
     * @return array
     */
    public function checkUnique($info) {
//        return $this->db->getValue('select count(*) from '.$this->tNameItem.' where (di_value=\''
//            . $info['di_value'] . '\' or di_caption=\''.$info['di_caption']
//            . '\') and dd_id=' . intval($info['dd_id'])
//            . ' and di_id!=' . intval($info['di_id']));
        $where['di_value']  = $info['di_value'];
        $where['di_caption']  = $info['di_caption'];
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
        $map['dd_id']  = intval($info['dd_id']);
        $map['di_id']  = array("neq",intval($info['di_id']));

        return M('pinggu_dd_item')->where($map)->count();
    }

    /**
     * 保存字典项信息
     * @param $info
     * @throws Exception
     */
    public function saveDd($info) {
        if ($this->checkUnique($info)) {
            throw new Exception('值或名称已经存在！');
        }
        if ($info['di_id']) {
            $updateField=array (
                'di_value' => $info['di_value'],
                'di_caption' => $info['di_caption'],
                'di_quotiety' => $info['di_quotiety'],
            );
            M('pinggu_dd_item')->where(array('di_id'=>intval($info['di_id'])))->save($updateField);
        } else {
            $insertField=array(
                'dd_id' => $info['dd_id'],
                'di_value' => $info['di_value'],
                'di_caption' => $info['di_caption'],
                'di_quotiety' => $info['di_quotiety'],
            );
            M('pinggu_dd_item')->add($insertField);
        }
        $this->cache($info['dd_id']);
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
        //$array = $this->db->select('select di_value,di_caption,di_quotiety from '.$this->tNameItem.' where dd_id=' . $dd_id.' order by list_order asc', 'hashmap');
        $array=M('pinggu_dd_item')->field('di_value,di_caption,di_quotiety')->where(array('dd_id'=>$dd_id))->order('list_order asc')->select();

        $fp = fopen('./Conf/pinggu/' . $dd_name . '.php', 'w');
        fputs($fp, '<?php return '.var_export($array, true) . '; ?>');
        fclose($fp);
    }

    /**
     * 排序
     *
     * @param array $order_arr
     * @return bool
     */
    function orderDd($order_arr,$dd_id)
    {
        foreach ($order_arr as $key=> $a_order){
            //$this->db->execute('update '.$this->tNameItem.' set list_order = '.$a_order.' where di_id = '.$key);
            M('pinggu_dd_item')->where(array('di_id'=>$key))->save(array('list_order'=>$a_order));
        }
        $this->cache($dd_id);
        return true;
    }


    /**
     * 分组操作
     *
     * @param array $order_arr
     * @return bool
     */
    function groupDd($order_arr,$dd_id)
    {
        foreach ($order_arr as $key=> $a_order){
            //$this->db->execute('update '.$this->tNameItem.' set list_group = '.$a_order.' where di_id = '.$key);
            M('pinggu_dd_item')->where(array('di_id'=>$key))->save(array('list_group'=>$a_order));
        }
        $this->cache($dd_id);
        return true;
    }

    /**
     * 删除字典项
     * @param mixed $users 字典项ID
     * @access public
     * @return bool
     */
    public function deleteDds($dds) {
        if (is_array($dds)) {
            $dds = implode(',',$dds);
            $where = 'di_id in (' . $dds . ')';
        } else {
            $where = 'di_id=' . intval($dds);
        }
        //$dd_id = $this->db->getValue('select dd_id from '.$this->tNameItem.' where ' . $where);
        $dd_id=M('pinggu_dd_item')->field('dd_id')->where($where)->find();
        //$this->db->execute('delete from '.$this->tNameItem.' where ' . $where);
        M('pinggu_dd_item')->where($where)->delete();

        $this->cache($dd_id);
    }

}