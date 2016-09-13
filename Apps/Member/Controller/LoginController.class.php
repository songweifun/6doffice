<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/8/20
 * Time: 下午8:50
 */
namespace Member\Controller;
use Think\App;
use Think\Controller;
class LoginController extends Controller{
    /**
     * 登录首页
     */
    public function index(){

        $this->username = $_COOKIE['AUTH_MEMBER_REALNAME'] ? $_COOKIE['AUTH_MEMBER_REALNAME'] :$_COOKIE['AUTH_MEMBER_NAME'];
        $this->name='login';
        $page=$this;
        require(APP_PATH.'Common/commonphp/page.php');

        //p($webConfig);die();
        $this->title=$page->title.' - 会员登陆';
        $this->cityarea=C('CITYAREA');






        $this->display();
    }

    /**
     * 验证码
     */
    public function verify(){
        $id=I('get.id','','intval');
        $config = array(
            'imageW'=>75,
            'imageH'=>30,
            'fontSize'=>12,
            'length' => 3, // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
            'reset' => false, // 验证成功后是否重置

        );
        $Verify=new \Think\Verify($config);

        if($id==1){
            $Verify->entry(1);

        }elseif($id==2){
            $Verify->entry(2);

        }

    }
    /**
     * 注册用户
     */
    public function register(){
        if(!IS_POST) $this->error('非法访问');
        $username=I('username');
        $passwd=I('passwd');
        $code=I('verify');
        if(!$this->check_verify($code,1)){
            $this->error('验证码错误');

        }
        if(!$username || !$passwd) {
            $this->error('请输入用户名或密码！');
        }
        if(C('BASE.base_member_open')==1){
            $status=0;
        }else{
            $status=1;
        }
        if(M('member')->where(array('username'=>$username))->find()) $this->error('用户名已存在');
        $data=array(
            'username'=>I('username'),
            'passwd'=>I('passwd','','md5'),
            'email'=>I('email'),
            'user_type'=>I('user_type',1,'intval'),
            'logins'=>1,
            'last_login'=>time(),
            'add_time'=>time(),
            'status'=>$status,
            'broker_info'=>array(
                'realname'=>I('realname'),
				'mobile'=>I('mobile'),
				'cityarea_id'=>I('cityarea_id'),
                'cityarea2_id'=>I('cityarea2_id'),
				'gender'=>I('gender'),
				'outlet_first'=>I('outlet_first'),
				'outlet_last'=>I('outlet_last'),

            ),
        );
        if($userid=D('MemberRelation')->relation(true)->add($data)){//关联模型插入两个表中
            $this->addLoginLog($username);
            //登录信息写入cookie

            $auth_code = authcode($userid. "\t" . md5($passwd). "\t" .$data['user_type'], 'ENCODE',C('AUTH_KEY'));
            setcookie('AUTH_MEMBER_STRING',$auth_code,0,'/',C('COOKIE_DOMAIN'));
            $_COOKIE['AUTH_MEMBER_STRING'] = $auth_code;
            setcookie('AUTH_MEMBER_NAME',$username,0,'/',C('COOKIE_DOMAIN'));
            $_COOKIE['AUTH_MEMBER_NAME'] = $username;
            /*$brokerwhere['id']=$userid;
            $brokerwhere['user_type']=I('user_type');
            $realname = M('broker_info')->field('realname')->where($brokerwhere)->find();*/
            setcookie('AUTH_MEMBER_REALNAME',I('realname'),0,'/',C('COOKIE_DOMAIN'));
            $_COOKIE['AUTH_MEMBER_REALNAME'] = I('realname');

            //计算并更新用户活跃度
            $dateNow = mktime(0,0,0,date('m'),date('d'),date('Y'));
            $dateBefore =  $dateNow -604800;
            $loginlogdb=M('member_loginlog');
            $condition['username'] = $username;
            $condition['add_time'] = array('egt',$dateBefore);
            $loginlogarr=$loginlogdb->field('add_time')->where($condition)->order('add_time asc')->select();
            //组合出loginlog一维数组
            $loginlog=array();
            foreach($loginlogarr as $v){

                foreach($v as $value){
                    $loginlog[]=$value;
                }

            }
            $active_arr = array_fill(0, 7, 0);
            $activeRate = 0;
            foreach($loginlog as $item) {
                for ($i = 0; $i <= 6; $i++) {
                    if ($dateBefore + $i * 86400 == $item) {
                        $activeRate += 1000 + pow(2, $i);
                        $active_arr[$i] = 1;
                        break;
                    }
                }
            }
            if($active_arr){
                $active_str = implode('|',$active_arr);
            }else{
                $active_str = '';
            }
            D('MemberRelation')->where(array('id'=>$userid))->save(array('active_str'=>$active_str,'active_rate'=>$activeRate));

            $this->success('注册成功',U(MODULE_NAME.'/Index/index'));
        }else{
            $this->error('注册失败');
        }


    }
    /**
     * ajax验证验证码
     */
    public function codeCheckAjax(){
        if(!IS_AJAX) $this->error('非法访问');
        $arr=array();
        $code=I('code');
        if($this->check_verify($code,1)){
            $arr['status']=true;
            $arr['returnMSG']='验证码正确';
        }else{
            $arr['status']=false;
            $arr['returnMSG']='验证码错误';

        }
        $this->ajaxReturn($arr);


    }

    /**
     * 封装的验证码检测方法
     * @param $code
     * @param string $id
     * @return bool
     */
  function check_verify($code, $id = ''){

    $verify = new \Think\Verify();
    $verify->reset=false;// 验证成功后是否重置
    return $verify->check($code, $id);
  }
    /**
     * 验证登录
     */

    public function login(){

        if(!IS_POST) $this->error('非法访问');
        $username=I('username');
        $passwd=I('passwd');
        $code=I('verify2');
        $notForget=I('notForget',0,'intval');

        if(!$this->check_verify($code,2)) $this ->error('验证码错误');
        $userarr=D('MemberRelation')->relation(true)->where(array('username'=>$username))->find();
        //p($userarr);die;
        if(!$userarr){
            $this->error('用户名不存在');
        }else{
            if(md5($passwd)!=$userarr['passwd']){
                $this->error('密码错误');
            }else{
                //写入cookie
                if(isset($notForget) && $notForget==1){//记住密码一年
                    setcookie('AUTH_MEMBER_FORGET',$username,time()+60*60*24*365,'/',C('COOKIE_DOMAIN'));
                }

                $auth_code = authcode($userarr['id']. "\t" . md5($passwd). "\t" .$userarr['user_type'], 'ENCODE',C('AUTH_KEY'));
                setcookie('AUTH_MEMBER_STRING',$auth_code,0,'/',C('COOKIE_DOMAIN'));
                $_COOKIE['AUTH_MEMBER_STRING'] = $auth_code;
                setcookie('AUTH_MEMBER_NAME',$username,0,'/',C('COOKIE_DOMAIN'));
                $_COOKIE['AUTH_MEMBER_NAME'] = $username;

                setcookie('AUTH_MEMBER_REALNAME',$userarr['broker_info']['realname'],0,'/',C('COOKIE_DOMAIN'));
                $_COOKIE['AUTH_MEMBER_REALNAME'] = $userarr['broker_info']['realname'];


                //更新最后登陆时间和登陆次数
                M('member')->where(array('id'=>$userarr['id']))->save(array('last_login'=>time(),'logins'=>$userarr['logins']+1));

                //重新计算用户活跃度
                //1:记录loginlog
                $this->addLoginLog($username);
                //2:计算活跃度
                if($userarr['user_type']==1){
                    //7天前
                    $dateNow = mktime(0,0,0,date('m'),date('d'),date('Y'));
                    $dateBefore =  $dateNow -518400;
                    //echo $dateBefore;
                    $loginlogdb=M('member_loginlog');
                    $condition['username'] = $username;
                    $condition['add_time'] = array('egt',$dateBefore);
                    $loginlogarr=$loginlogdb->field('add_time')->where($condition)->order('add_time asc')->select();
                    //组合出loginlog一维数组
                    $loginlog=array();
                    foreach($loginlogarr as $v){

                        foreach($v as $value){
                            $loginlog[]=$value;
                        }

                    }
                    //p($loginlog);
                    $active_arr = array_fill(0, 7, 0);
                    //p($active_arr);
                    $activeRate = 0;
                    foreach($loginlog as $item) {
                        for ($i = 0; $i <= 6; $i++) {
                            if ($dateBefore + $i * 86400 == $item) {
                                $activeRate += 1000 + pow(2, $i);
                                $active_arr[$i] = 1;
                                break;
                            }
                        }
                    }
                    //p($activeRate);die;

                    if($active_arr){
                        $active_str = implode('|',$active_arr);
                    }else{
                        $active_str = '';
                    }
                    D('MemberRelation')->where(array('id'=>$userarr['id']))->save(array('active_str'=>$active_str,'active_rate'=>$activeRate));

                }

                $integral = D('IntegralRule');
                //echo $userarr['id'];die;

                $integral->add($userarr['id'],1);//没登录一次加5分



                $this->success('登录成功正在跳转.....',U(MODULE_NAME.'/Index/index'));
            }
        }

    }

    /**
     * 安全退出
     */
    public function logout(){
        /*if($_COOKIE['AUTH_MEMBER_STRING']){
            $uid = $this->getAuthInfo('id');
        }*/
        setcookie('AUTH_MEMBER_STRING', 0, time()-1,'/',C('COOKIE_DOMAIN'));
        setcookie('AUTH_MEMBER_NAME',0,time()-1,'/',C('COOKIE_DOMAIN'));
        setcookie('AUTH_MEMBER_REALNAME',0,time()-1,'/',C('COOKIE_DOMAIN'));
        $this->redirect('Home/Index/index');

    }

    /**
     * 增加loginLog
     *
     * @param string $username
     * @return bool
     */
    function addLoginLog($username)
    {
        $db=M('member_loginlog');
        $today = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $condition['username'] = $username;
        $condition['add_time'] = $today;
        $loginLogId=$db->field('id')->where($condition)->find();
        //p($loginLogId);die;
        if($loginLogId['id']){
            $db->where(array('id'=>$loginLogId['id']))->setInc('login_times',1);
        }else{
            $db->data(array('username'=>$username,'login_times'=>1,'add_time'=>$today))->add();
        }
        return true;
    }





}