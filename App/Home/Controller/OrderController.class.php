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

class OrderController extends CommonController {

    //加入购物车
    public function addShopcartRecord() {
        $Article = M('Article');
        $map['id'] = $_GET['id'];
        $articleList = $Article->where($map)->find();

        $Shopcart = M('Shopcart');
        $data["pid"] = $map["id"];
        $data["uid"] = $_SESSION["uid"];
        $data["title"] = $articleList["title"];
        $data["content"] = $articleList["content"];
        $data["price"] = $articleList["price"];
        $data["num"] = $articleList["num"];
        $data["subTime"] = time();
        if ($Shopcart->add($data)) {
            $this->success("添加成功!");
        } else {
            $this->error("添加失败!");
        }
    }

    //购物车产品列表
    public function orderList() {

        A("Member")->isMemberLoginIn();
        $this->assign("orderList", D("Admin/Order")->getOrderListByUid($_SESSION['uid']));

        $this->display();
    }

}

?>