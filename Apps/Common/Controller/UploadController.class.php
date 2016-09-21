<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/21
 * Time: 上午10:13
 */
namespace Common\Controller;
use Think\Controller;
class UploadController extends Controller{
    /**
     * ajax查询数据
     */
    public function ajax(){
        //echo "[a,b,c,d,e,fa,jac]";
        $member_id = getAuthInfo('id');
        if(I('action')=='getBoroughList'){
            $borough = M('borough');
            $_GET["q"] = charsetIconv($_GET["q"]);
            $q = strtolower($_GET["q"]);
            if (!$q) return;
            $where['borough_name']=array('like','%'.$q.'%');
            $where['borough_letter']=array('like','%'.$q.'%');
            $where['borough_alias']=array('like','%'.$q.'%');
            $where['_logic'] = 'OR';
            $map['_complex']=$where;
            $map['isdel']=array('neq',1);
            $datalist=$borough->field('id,borough_name,borough_address')->where($map)->select();
            //$this->ajaxReturn($datalist,'jsonp');
            //p($datalist);
            $str = "";
            foreach ($datalist as $key=>$value) {
                $boroughImageList = D('Borough')->getImgList($value['id'],1);//获取小区户型图
                //p($boroughImageList);
                foreach ($boroughImageList as $k=>$v) {
                    $datalist[$key]['info'][$k]['pic_thumb']=$v['pic_thumb'];
                    $datalist[$key]['info'][$k]['pic_url']=$v['pic_url'];
                    $datalist[$key]['info'][$k]['pic_desc']=$v['pic_desc'];
                }
                //echo $pic_thumb;没用
                if($value['borough_alias']){
                    //$str .= $value['borough_name'].'('.$value['borough_alias'].')'."|".$value['id']."|".$value['borough_address']."\n";
                    $str .= $value['borough_name']."|".$value['id']."|".$value['borough_address']."|".$pic_thumb."|".$pic_url."|".$pic_desc."\n";
                }else{
                    $str .= $value['borough_name']."|".$value['id']."|".$value['borough_address']."|".$pic_thumb."|".$pic_url."|".$pic_desc."\n";
                }
            }

            $str .= "我要创建新小区|addBorough|addBorough\n";
            //echo $str;
            //p($datalist);
            $datalist[]['borough_name']='我要创建新小区';
            //p($datalist);die();
            $this->ajaxReturn($datalist,'jsonp');





        }elseif(I('action')=='getMemberList'){
            $member=D('MemberView');
            $_GET["q"] = charsetIconv($_GET["q"]);
            $q = strtolower($_GET["q"]);
            if (!$q) return;
            $where['username']=array('like','%'.$q.'%');
            $where['email']=array('like','%'.$q.'%');
            $where['realname']=array('like','%'.$q.'%');
            $where['mobile']=array('like','%'.$q.'%');
            $where['_logic'] = 'OR';
            $map['_complex']=$where;
            $map['status']=array('eq',0);
            $datalist=$member->field('id,realname')->where($map)->select();
            $this->ajaxReturn($datalist,'jsonp');


        }//else if
    }
}