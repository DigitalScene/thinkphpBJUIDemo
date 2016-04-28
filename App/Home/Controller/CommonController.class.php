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
use Common\Model\CommonModel;
use Admin\Model\ChannelModel;

class CommonController extends Controller {

    function _initialize() {
    	$this->channelModel = D('Admin/Channel');
        $this->channelDetail = $this->channelModel->getChannelDetailById(I('get.cid'));
    }

}

?>