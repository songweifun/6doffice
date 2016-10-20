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

}