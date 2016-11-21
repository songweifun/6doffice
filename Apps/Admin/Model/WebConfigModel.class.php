<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/25
 * Time: 下午2:39
 */
namespace Admin\Model;
use Think\Model;
class WebConfigModel extends Model{

    /**
     * 保存网站信息
     * @access public
     * @param int $id
     * @return array
     */
    function saveConf($fileddata){
        //$this->db->update($this->tName,$fileddata['webConfig']);
        //p($fileddata);die;
        $this->where(array('id'=>1))->save($fileddata);
        $this->cache();
        return true;
    }
    /**
     * 取得详细信息
     * @access public
     * @param int $id
     * @return array
     */
    function getInfo($id,$field = '*'){
        return $this->field($field)->where(array('id'=>$id))->find();
    }

    /**
     * 缓存网站基本信息
     * @access public
     * @return void
     */
    public function cache() {
        //$array = $this->db->getValue('select * from fke_web_config where id = 1', 'hashmap');
        $array=$this->where(array('id'=>1))->find();
        $fp = fopen('./Apps/Common/Conf/base.php', 'w');
        //p($array);die;
        fputs($fp, '<?php return '.var_export($array, true) . '; ?>');
        fclose($fp);
    }

}