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

class PublicModel {

    Protected $autoCheckFields = false;

    public function auth($datas) {
        $datas = $_POST;
        $verify = new \Think\Verify();
        $isVerifyPass = $verify->check($_POST['verify_code'], '');
        if (!$isVerifyPass) {
            //json_decode()编译出来的是对象,返回的已经是json对象啦
            die(json_encode(array('statusCode' => 300, 'message' => "验证码错误啦，再输入吧")));
        }
        $M = M("User");
        if ($M->where("`username`='" . $datas['username'] . "'")->count() >= 1) {
            $info = $M->where("`username`='" . $datas["username"] . "'")->find();
            foreach ($infoList as $value) {
                $info = $value;
            }
           /* if ($info['status'] == 0) {
                return array('statusCode' => 300, 'message' => "你的账号被禁用，有疑问请与管理员联系");
            }
            if ($datas['op_type'] == 2) {
                $rc = randCode(5);
                $code = $info['uid'] . md5($rc);
                $url = str_replace(C("webPath"), "", C("WEB_ROOT")) . U("Public/findPwd", array("code" => $code));
                $body = "请在浏览器上打开地址：<a href='$url'>$url</a> 进行密码重置操作";
                $return = send_mail($datas["email"], "", "找回密码", $body);
                if ($return == 1) {
                    $info['find_code'] = $rc;
                    $M->save($info);
                    return array('statusCode' => 200, 'message' => "重置密码邮件已经发往你的邮箱" . $_POST['email'] . "中，请注意查收");
                } else {
                    return array('statusCode' => 300, 'message' => "$return");
                }
                exit;
            }*/
            if ($info['pwd'] == md5($datas['pwd'] . $info['username'])) {

                $loginMarked = C("TOKEN");

                $loginMarked = md5($loginMarked['admin_marked']);
                $shell = $info['uid'] . md5($info['pwd'] . C('AUTH_CODE'));
                $_SESSION[$loginMarked] = "$shell";
                $shell.= "_" . time();
                setcookie($loginMarked, "$shell", 0, "/");
                $_SESSION['myInfo'] = $info;

                //这里返回的还是数组array  json_encode只与die共用，不能与return共用，return需要用ajaxReturn
               return array('statusCode' => 200, 'message' => "登录成功", 'url' => U("Admin/Index/index"));
            } else {
                return array('statusCode' => 300, 'message' => "账号或密码错误");
            }
        } else {
            return array('statusCode' => 300, 'message' => "不存在用户名为 " . $datas["username"] . ' 的账号！');
        }
    }

   /* public function findPwd() {
        $datas = $_POST;
        $M = M("User");
        if ($_SESSION['verify'] != md5($_POST['verify_code'])) {
            die(json_encode(array('statusCode' => 300, 'message' => "验证码错误啦，再输入吧")));
        }
//        $this->check_verify_code();
        if (trim($datas['pwd']) == '') {
            return array('statusCode' => 300, 'message' => "密码不能为空");
        }
        if (trim($datas['pwd']) != trim($datas['pwd1'])) {
            return array('statusCode' => 300, 'message' => "两次密码不一致");
        }
        $data['aid'] = $_SESSION['aid'];
        $data['pwd'] = md5(C("AUTH_CODE") . md5($datas['pwd']));
        $data['find_code'] = NULL;
        if ($M->save($data)) {
            return array('statusCode' => 200, 'message' => "你的密码已经成功重置", 'url' => U('Access/index'));
        } else {
            return array('statusCode' => 300, 'message' => "密码重置失败");
        }
    }*/

}

?>
