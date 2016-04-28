<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-15 12:40
 * @version 1.0
 * @description
 */

namespace Admin\Model;

use Think\Model;

class WebinfoModel extends Model {

    public function getWebInfoByType($infoType) {
        $Model = M('Config');
        return $list = $Model->where('infoType=' . $infoType)->order('id desc')->select();
    }

}

?>
