<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-15 12:40
 * @version 1.0
 * @description
 */

namespace Home\Controller;

use Think\Controller;

// 本类由系统自动生成，仅供测试用途
class BaseController extends CommonController {

    public function demoRegion() {
        $province = M('Region')->where(array('pid' => 1))->select();
        $this->assign('province', $province);
        $this->display();
    }

    public function getRegion() {
        $Region = M("Region");
        $map['pid'] = $_REQUEST["pid"];
        $map['type'] = $_REQUEST["type"];
        $list = $Region->where($map)->select();
        echo json_encode($list);
    }

}