<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/26
 * Time: 下午6:27
 */
namespace Admin\Model;
use Think\Model;
class InnernoteModel extends Model{

    /**
     * 发送信息
     * @access public
     *
     * @param string $msg_from
     * @param string $msg_to
     * @param string $title
     * @param string $content
     * @return bool
     **/
    function send($msg_from,$msg_to,$title,$content,$reply_to=0,$belongs_to=0){
        $insertArray = array(
            'msg_from'=>$msg_from,
            'msg_to'=>$msg_to,
            'msg_title'=>$title,
            'msg_content'=>$content,
            'replay_to'=>$reply_to,
            'belongs_to'=>$belongs_to,
            'add_time'=>time()
        );
         $this->add($insertArray);
    }

    /**
     * 取类别总数
     * @access public
     * @return int
     */
    function getCount($where = '') {
        return $this->where($where)->count;

    }

    /**
     * 取得信息列表
     * @access public
     *
     * @param array $pageLimit
     * @return array
     **/
    function getList($pageLimit, $fileld='*' ,$where='', $order='id desc ') {
        return $this->where($where)->field($fileld)->order($order)->limit($pageLimit)->select();

    }

    /**
     * 操作状态 不物理删除
     * @param mixed $members 用户ID
     * @access public
     * @return bool
     */
    function fromDel($ids,$status=1) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' ( id in ('.$ids.') or belongs_to in ('.$ids.') )';
        } else {
            $where = ' ( id= ' . intval($ids).' or belongs_to = ' . intval($ids) . ')';
        }
        return $this->where($where)->save(array('from_del'=>$status));
    }

    /**
     * 删除信息
     * @param mixed $ids ID列表
     * @access public
     * @return bool
     */
    function deleteInfo($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' id in (' . $ids . ')';
        } else {
            $where = ' id=' . intval($ids);
        }
        return $this->where($where)->delete();
    }
    /**
     * 删除附属信息
     * @param mixed $ids ID列表
     * @access public
     * @return bool
     */
    function deleteBelongsTo($ids) {
        if (is_array($ids)) {
            $ids = implode(',',$ids);
            $where = ' belongs_to in (' . $ids . ')';
        } else {
            $where = ' belongs_to =' . intval($ids);
        }
        $this->where($where)->delete();
    }


}