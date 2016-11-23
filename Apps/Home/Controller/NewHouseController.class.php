<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/11/22
 * Time: 下午9:07
 */
namespace Home\Controller;
use Think\Controller;
class NewHouseController extends CommonController{
    public function _initialize()
    {
        //$this=$this;
        parent::_initialize();
        $this->menu="newHouse";  //分配栏目
    }

    /**
     * 新房首页
     */
    public function index(){
        $this->title = $this->city.'新房 - '.$this->titlec;   //网站名称
        //关键词和描述
        $this->keyword = $this->newhouse_keyword;
        $this->description = $this->newhouse_description;
        $borough = M('borough');
        //二手房按价格统计
        $sell_price_option = array(
            '0-5000'=>'5000元/㎡以下',
            '5000-6000'=>'5000-6000元/㎡以下',
            '6000-7000'=>'6000-7000元/㎡',
            '7000-8000'=>'7000-8000元/㎡',
            '8000-9000'=>'8000-9000元/㎡',
            '9000-10000'=>'9000-10000元/㎡',
            '10000-0'=>'10000元/㎡以上',
        );

        //按区域统计
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        $house_type_option = getArray('house_type');
        $this->assign('house_type_option', $house_type_option);

        $this->assign('sell_price_option', $sell_price_option);
        //$boroughCountCityarea = $borough->getCountGroupBy('cityarea_id',' and isnew =1 and isdel = 0 ',0);
        $boroughCountCityarea=$borough->field('cityarea_id,count(*) as house_num')->where(array('isnew'=>1,'isdel'=>0))->group('cityarea_id')->having('house_num>0')->select();
        foreach ($boroughCountCityarea as $key => $item){
            $boroughCountCityarea[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
        }
        //p($boroughCountCityarea);die;
        $this->assign('boroughCountCityarea', $boroughCountCityarea);

        //按板块统计
        $borough_section_option = getArray('borough_section');

        $this->assign('boroughCountSection', $borough_section_option);

        //按开发商统计
        $borough_developer_option = getArray('borough_developer');
        $borough_developer_option[0] = "其他";
        //$boroughCountDeveloper = $borough->getCountGroupBy('borough_developer_id',' and isnew =1 and isdel = 0 ',0);
        $boroughCountDeveloper=$borough->field('borough_developer_id,count(*) as house_num')->where(array('isnew'=>1,'isdel'=>0))->group('borough_developer_id')->having('house_num>0')->select();

        foreach ($boroughCountDeveloper as $key => $item){
            $boroughCountDeveloper[$key]['borough_developer'] = $borough_developer_option[$item['borough_developer_id']];
        }
        $this->assign('boroughCountDeveloper', $boroughCountDeveloper);

        //字母索引
        $house_letter_option = range('A','Z');
        $this->assign('house_letter_option', $house_letter_option);

        $where =' and isnew =1 and isdel = 0 ';

        $state= $_GET['state'];
        switch ($state){
            case 'promote':
                $where .=" and is_promote=1 ";
                $this->title = "热推楼盘,".$this->title;
                break;
            case 'priceoff':
                $where .=" and is_priceoff=1 ";
                $this->title = "促销楼盘,".$this->title;
                break;
            case 'new':
                $where .=" and (sell_time>'".date('Y-m-d')."' or sell_time ='' )";
                $this->title = "即将开盘,".$this->title;
                break;
            default:
                //all
                break;
        }

        //cityarea
        $cityarea = intval($_GET['cityarea']);
        if($cityarea){
            $where .= ' and cityarea_id = '.$cityarea;
            $this->title = $cityarea_option[$cityarea].",".$this->title;
        }
        $dd=D('DdItem');
        $borough_section=$dd->getSonList($cityarea);
        $this->assign('borough_section',$borough_section);

        //cityarea2
        $cityarea2 = intval($_GET['cityarea2']);
        if($cityarea2){
            $where .= ' and cityarea2_id = '.$cityarea2;
            $this->title = $cityarea_option[$cityarea].",".$this->title;
        }
        //section
        $section = intval($_GET['section']);
        if($section){
            $where .= ' and borough_section = '.$section;
            $this->title = $borough_section_option[$section].",".$this->title;
        }
        //type
        $type = intval($_GET['type']);
        if($type){
            $where .= ' and borough_type = '.$type;
            $this->title = $house_type_option[$type].",".$this->title;
        }
        if(isset($_GET['developer']) && $_GET['developer']!==''){
            $developer = intval($_GET['developer']);
            $where .= ' and borough_developer_id = '.$developer;
            $this->title = $borough_developer_option[$developer].",".$this->title;
        }

        //q
        $q = $_GET['q']=="可输入小区名、路名或划片学校" ? "":trim($_GET['q']);
        if($q){
            // 小区名、路名或划片学校
            $where.=" and borough_name like '%".$q."%' or borough_address like '%".$q."%' or elementary_school like '%".$q."%' or middle_school like '%".$q."%'" ;
            $this->title = $q.",".$this->title;
        }
        //price
        $price = $_GET['price'];
        if($price){
            $tmp = explode('-',$price);
            if($tmp[0]){
                $where .= ' and borough_avgprice >= '.intval($tmp[0]);
            }
            if($tmp[1]){
                $where .= ' and borough_avgprice <= '.intval($tmp[1]);
            }
            $this->title = "均价".$price.",".$this->title;
        }

        //letter
        $letter = $_GET['letter'];
        if($letter){
            $where .= " and borough_letter like '".$letter."%'";
            $this->title = "字母".$letter."开头,".$this->title;
        }
        //list_order 排序转换
        switch ($_GET['list_order']){
            case "updated desc":
                $list_order = "is_promote desc,updated desc";
                break;
            case "avg_price asc":
                $list_order = "is_promote desc,borough_avgprice asc";
                break;
            case "avg_price desc":
                $list_order = "is_promote desc,borough_avgprice desc";
                break;
            case "sell_time desc":
                $list_order = "is_promote desc,sell_time desc";
                break;
            default:
                $list_order = "is_promote desc,updated desc";
                break;
        }
        //list_num
        $list_num = intval($_GET['list_num']);
        if(!$list_num){
            $list_num = 12;
        }

        $borough = D('Borough');

        $boroughPriceoffList = $borough->getList('0,5','2','','');
        $this->assign('boroughPriceoffList', $boroughPriceoffList);
        $row_count=D('BoroughView')->getCount(1, $where);
        $Page = new \Think\Page($row_count, $list_num);



        $pageLimit = $Page->firstRow . ',' . $Page->listRows;
        $dataList = D('BoroughView')->getListDetail($pageLimit,1,$where,$list_order);


        //p($dataList);die;


        $Page->setConfig('header', '共%TOTAL_ROW%条');
        $Page->setConfig('first', '首页');
        $Page->setConfig('last', '共%TOTAL_PAGE%页');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('link', 'indexpagenumb');//pagenumb 会替换成页码
        $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');

        //page
        $page_count=ceil($row_count/$list_num)>0?ceil($row_count/$list_num):1;
        $pageno = $_GET['p']?intval($_GET['p']):1;
        $pre_page = $pageno>1?$pageno-1:1;
        $next_page = $pageno<$page_count?$pageno+1:$page_count;
        $this->assign('pageno', $pageno);
        $this->assign('row_count', $row_count);
        $this->assign('page_count',$page_count);
        $this->assign('pre_page', $pre_page);
        $this->assign('next_page',$next_page);

        $integral_array = C('RANK');
        foreach ($dataList as $key=> $item){
            $dataList[$key]['cityarea_name'] = $cityarea_option[$item['cityarea_id']];
            $dataList[$key]['section_name'] = $borough_section_option[$item['borough_section']];
            $dataList[$key]['borough_content'] = substrs(strip_tags($item['borough_content']),80);
        }

        $borough_list_num = count($dataList);
        if($borough_list_num%2){
            $borough_list_num = 2-$borough_list_num%2;
            $this->assign('borough_list_num', $borough_list_num);
        }

        $this->assign('dataList', $dataList);
        $this->assign('pagePanel', $Page->show());//分页条
        $this->assign('pagePanel_top', $Page->show());//分页条

        $this->assign('back_to', urlencode($_SERVER['REQUEST_URI']));

        $this->display();
    }

    /**
     * 新房详情页
     */
    public function detail(){

        //小区
        $borough = D('Borough');
        //区域字典
        $cityarea_option =getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect(U('index'));
        }

        //小区详细信息
        $boroughInfo = D('BoroughView')->where(array('id'=>$id))->find();
        $boroughInfo['cityarea_name'] = $cityarea_option[$boroughInfo['cityarea_id']];
        $boroughInfo['borough_section'] = getCaption('borough_section',$boroughInfo['borough_section']);
        $boroughInfo['borough_support'] = getCaption('borough_support',$boroughInfo['borough_support']);
        $boroughInfo['borough_sight'] = getCaption('borough_sight',$boroughInfo['borough_sight']);
        $boroughInfo['borough_type'] = getCaption('borough_type',$boroughInfo['borough_type']);
        $boroughInfo['unsign_percent_change'] = abs($boroughInfo['percent_change']);

        //小区图片
        $boroughImageList = $borough->getImgList($id,0,4);
        $this->assign('boroughImageList', $boroughImageList);
        $borough_img_num = count($boroughImageList);
        if($borough_img_num%2){
            $borough_img_num = 2-$borough_img_num%2;
            $this->assign('borough_img_num', $borough_img_num);
        }
        if(!$boroughInfo['borough_thumb']){
            if($boroughImageList){
                $boroughInfo['borough_thumb'] = $boroughImageList[0]['pic_url'];
                $borough->updateThumb($boroughInfo['id'],$boroughInfo['borough_thumb']);
            }
        }
        $this->assign('dataInfo', $boroughInfo);
        //p($boroughInfo);die;


        //小区户型图
        $boroughDrawList = $borough->getImgList($id,1,4);
        $this->assign('boroughDrawList', $boroughDrawList);
        $borough_draw_num = count($boroughDrawList);
        if($borough_draw_num%2){
            $borough_draw_num = 2-$borough_draw_num%2;
            $this->assign('borough_draw_num', $borough_draw_num);
        }

        //新盘新闻动态
        $boroughNewsList = $borough->getNewsList($boroughInfo['id']);
        $this->assign('boroughNewsList', $boroughNewsList);

        $intentionCount = $borough->getIntentionCount(' and borough_id='.$boroughInfo['id']);
        $this->assign('intentionCount', $intentionCount);


        //价格小区
        $samePriceBorough =$borough->getList(5,1,' and id<>'.$id.' and isdel =0 and isnew =1 and borough_avgprice >='.($boroughInfo['borough_avgprice']-200).' and borough_avgprice<='.($boroughInfo['borough_avgprice']+200),'borough_avgprice desc');
        $this->assign('samePriceBorough', $samePriceBorough);

        //cityarea小区
        $sameCityareaBorough =$borough->getList(5,1,' and id<>'.$id.' and isdel =0 and isnew =1 and cityarea_id = '.$boroughInfo['cityarea_id'],'updated desc');
        $this->assign('sameCityareaBorough', $sameCityareaBorough);

        //网友察看
        $boroughClickList =$borough->getList(5,1,' and id<>'.$id.' and isdel =0 and isnew =1','rand() desc');
        $this->assign('boroughClickList', $boroughClickList);

        //页面标题
        $this->title = $boroughInfo['borough_name'].'的楼盘概况 - '.$this->title;


        //增加计数
        $borough->increase($boroughInfo['id'],'click_num');

        //$this->assign('boroughAdviserList', $boroughAdviserList);


        $this->display();

    }

    /**
     * 新盘相册
     */
    public function photo(){

        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect(U('index'));
        }

        //小区
        $borough = D('Borough');

        //小区详细信息
        $boroughInfo = $borough->field('id,borough_name')->where(array('id'=>$id))->find();
        $this->assign('dataInfo', $boroughInfo);

        //小区图片
        $boroughImageList = $borough->getImgList($id,0);
        $this->assign('boroughImageList', $boroughImageList);
        $borough_img_num = count($boroughImageList);
        if($borough_img_num%3){
            $borough_img_num = 3-$borough_img_num%3;
            $this->assign('borough_img_num', $borough_img_num);
        }

        //页面标题
        $this->title = $boroughInfo['borough_name'].'的项目图片 - '.$this->title;


        $this->display();

    }

    /**
     * 户型鉴赏
     */
    public function structure(){
        //区域字典
        $cityarea_option = getArray('cityarea');
        $this->assign('cityarea_option', $cityarea_option);

        //id
        $id = intval($_GET['id']);
        if(!$id){
            $this->redirect(U('index'));
        }

        //小区
        $borough = D('Borough');

        //小区详细信息
        $boroughInfo = $borough->field('id,borough_name')->where(array('id'=>$id))->find();
        $this->assign('dataInfo', $boroughInfo);

        //小区图片
        $boroughImageList = $borough->getImgList($id,1);
        $this->assign('boroughImageList', $boroughImageList);
        $borough_img_num = count($boroughImageList);
        if($borough_img_num%3){
            $borough_img_num = 3-$borough_img_num%3;
            $this->assign('borough_img_num', $borough_img_num);
        }

        //页面标题
        $this->title = $boroughInfo['borough_name'].'的户型图 - '.$this->title;

        //关键词
        $this->keyword = '哈尔滨新楼盘,哈尔滨租房,哈尔滨二手房,哈尔滨'.$boroughInfo['borough_name'].'的户型图';
        $this->display();
    }
    /**
     * 意向表单收集
     */
    public function save(){
        $borough = D('Borough');

        $borough_id = $_GET['borough_id'];
        $_POST['borough_id'] = $borough_id;
        $borough->saveIntention($_POST);
        $this->success('成功提交您的意向',U('detail').'/id/'.$borough_id);

    }

}
