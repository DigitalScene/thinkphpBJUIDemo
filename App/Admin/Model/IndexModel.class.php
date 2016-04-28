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

class IndexModel extends Model {

    public function myInfo($datas) {
        $M = M("User");
        if (md5($datas['pwd0'] . $datas['username']) != $_SESSION['myInfo']['pwd']) {
            return array('status' => 0, 'info' => "旧密码错误");
        }
        if (trim($datas['pwd']) == '') {
            return array('status' => 0, 'info' => "密码不能为空");
        }
        if (trim($datas['pwd']) != trim($datas['pwd1'])) {
            return array('status' => 0, 'info' => "两次密码不一致");
        }
        $data['uid'] = $_SESSION['myInfo']['uid'];
        $data['pwd'] = md5($datas['pwd'] . $datas['username']);
        if ($M->save($data)) {
            setcookie("$this->loginMarked", NULL, -3600, "/");
            unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
            return array('status' => 1, 'info' => "你的密码已经成功修改，请重新登录", 'url' => U('Access/index'));
        } else {
            return array('status' => 0, 'info' => "密码修改失败");
        }
    }

}

?>
