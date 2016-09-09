<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 16/9/9
 * Time: 下午11:06
 */
namespace Member\Controller;
use Think\Controller;
class ManageRentController extends CommonController{//出租管理控制器
    /**
     *刷新
     */
    public function refresh()
    {
        $member=D('MemberView');
        $member_id = $member->getAuthInfo('id');
        $houseRent = D('HouseRentRelation');
        //刷新房源
        $ids = $_POST['ids'];//获得所选中房源的ID

        if (!is_array($ids) || empty($ids)) {
            $this->error('没有选择刷新条目');
        } else {
            array_walk($ids, 'intval');
        }

        foreach ($ids as $id) {
            $houseInfo = $houseRent->where(array('id' => $id))->find();
            //p($houseInfo);
            if ($houseInfo['refresh'] == 0) {
                $this->error('请不要选择可刷新次数为0的房源');
            }
        }

        try {
            $houseRent->where(array('id' => array('in', $ids)))->setDec('refresh', 1);
            $houseRent->refresh($ids);
            jsurlto('刷新房源成功', U(MODULE_NAME . '/HouseRent/index'));
        } catch (Exception $e) {
            $this->error('刷新房源失败');
        }
    }


}