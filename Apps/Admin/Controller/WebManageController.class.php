<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/23
 * Time: 下午6:52
 */
namespace Admin\Controller;
use Think\Controller;
class WebManageController extends CommonController{
    public function _initialize()
    {
        $this->cate=CONTROLLER_NAME;  //分配栏目
    }

    /**
     * 网站信息
     */
    public function webInfo(){
        $stat = D('Statistics');
        $HouseWanted=D('HouseWanted');
        $houserent=D('Houserent');
        $housesell=D('Housesell');
        $xiaoqu=D('BoroughUpdate');
        $borough=D('Borough');
        $company=D('Company');
        $member=D('Member');
        $BrokerIndentity=D('BrokerIdentity');
        $ConsignSale=D('ConsignSale');
        $city=D('City');
        $BrokerAvatar=D('BrokerAvatar');
        $BrokerAptitude=D('BrokerAptitude');

        //取二手房、小区、租房信息
        $allNum = $stat->getAll('allNum');
        $allNum=array_to_hashmap($allNum,'stat_index','stat_value');
        $this->assign('statistics', $allNum);

        //取得新楼盘数量
        $newhouse = $borough->getCount('3','');
        $this->assign('newhouse',$newhouse);

        //取得中介公司数量
        $companyCount = $company->getCount(' and type=0');
        $this->assign('companyCount',$companyCount);

        //取得未审核的小区更新数量
        $xiaoqu_num = $xiaoqu->getCount('status = 0 ');
        $this->assign('xiaoqu_num',$xiaoqu_num);

        //取得搬家公司数量
        $moveCompanyCount = $company->getCount(' and type=1');
        $this->assign('moveCompanyCount',$moveCompanyCount);

        //取得装修公司数量
        $decorationCompanyCount = $company->getCount(' and type=2');
        $this->assign('decorationCompanyCount',$decorationCompanyCount);
        //取得未审核求租数量
        $Unaudited_hold = $HouseWanted->getCount('wanted_type = 2 and status = 0');
        $this->assign('Unaudited_hold',$Unaudited_hold);

        //取得未审核求购数量
        $Unaudited_buy = $HouseWanted->getCount('wanted_type = 1 and status = 0');
        $this->assign('Unaudited_buy',$Unaudited_buy);

        //取二手房均价
        $val = $stat->getAll('val');
        $val=array_to_hashmap($val,'stat_index','stat_value');
        $this->assign('val', $val);

        //取得出售房源置顶数量
        $Unaudited_housesell = $housesell->getCount('10','');
        $this->assign('Unaudited_housesell',$Unaudited_housesell);


        //取得出租房源置顶数量
        $Unaudited_houserent = $houserent->getCount('10','');
        $this->assign('Unaudited_houserent',$Unaudited_houserent);
        //未开通经纪人
        $noOpen = $member->getCount('status =1');
        $this->assign('noOpen',$noOpen);

        //个人出售未审核数量
        $guestSale = $housesell->getCount('2','');
        $this->assign('guestSale',$guestSale);

        //个人出租未审核数量
        $guestRent = $houserent->getCount('2','');
        $this->assign('guestRent',$guestRent);

        //取得未审核的小区更新数量
        $xiaoqu_num = $xiaoqu->getCount('status = 0 ');
        $this->assign('xiaoqu_num',$xiaoqu_num);

        //取得未审核的小区数量
        $borough_num = $borough->getCount(0,' and is_checked=0 ');
        $this->assign('borough_num',$borough_num);

        //经纪人身份未审核数量
        $broker_id = $BrokerIndentity->getCount('status=0');
        $this->assign('broker_id',$broker_id);

        //未受理的委托房源
        $consignCount = $ConsignSale->getCount('1','');
        $this->assign('consignCount',$consignCount);

        //未受理的加盟信息
        $UunionCount = $city->getCountUnion('1','');
        $this->assign('UunionCount',$UunionCount);

        //经纪人头像未审核数量
        $broker_avatar = $BrokerAvatar->getCount('status=0');
        $this->assign('broker_avatar',$broker_avatar);

        //经纪人身份未审核数量
        $broker_api = $BrokerAptitude->getCount('status=0');
        $this->assign('broker_api',$broker_api);

        //获取服务器信息
        $this->banben = PHP_VERSION;
        $this->xitong = PHP_OS;
        $this->mag = ini_get(magic_quotes_gpc);


        $this->sysinfo = array(
            'os' => $_SERVER["SERVER_SOFTWARE"], //获取服务器标识的字串
            'version' => PHP_VERSION, //获取PHP服务器版本
            'time' => date("Y-m-d H:i:s", time()), //获取服务器时间
            'pc' => $_SERVER['SERVER_NAME'], //当前主机名
            'osname' => php_uname(), //获取系统类型及版本号
            'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'], //获取服务器语言
            'port' => $_SERVER['SERVER_PORT'], //获取服务器Web端口
            'max_upload' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", //最大上传
            'max_ex_time' => ini_get("max_execution_time")."秒", //脚本最大执行时间
            'mysql_version' => $this->_mysql_version(),
            'mysql_size' => $this->_mysql_db_size(),
        );



        $this->menu=ACTION_NAME;//分配小栏目
        $this->display();

    }



    /**
     * 网站配置
     */
    public function webConfig(){
        $config=M('web_config');
        $action=I('get.action');
        if($action=='save'){
            //p($_POST);die;
            if($config->where(array('id'=>1))->save($_POST['webConfig'])){
                $this->success('保存成功',U('webconfig'));
                exit;
            }else{
                $this->error('保存失败');
            }



        }
        $webConfig = $config->where(array('id'=>1))->find();
        $this->assign('webConfig', $webConfig);
        //p($webConfig);die;

        $this->menu=ACTION_NAME;//分配小栏目

        $this->display();
    }

    /**
     * n
     * 内置函数
     */
    private function _mysql_version()
    {
        $Model = M();
        $version = $Model->query("select version() as ver");
        return $version[0]['ver'];
    }

    private function _mysql_db_size()
    {
        $Model = M();
        $sql = "SHOW TABLE STATUS FROM ".C('DB_NAME');
        $tblPrefix = C('DB_PREFIX');
        if($tblPrefix != null) {
            $sql .= " LIKE '{$tblPrefix}%'";
        }
        $row = $Model->query($sql);
        $size = 0;
        foreach($row as $value) {
            $size += $value["Data_length"] + $value["Index_length"];
        }
        return round(($size/1048576),2).'M';
    }
}