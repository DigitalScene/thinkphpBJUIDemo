<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-15 12:40
 * @version 1.0
 * @description
 */

namespace Common\Controller;

use Think\Controller;
use Common\Model\CommonModel;

class CommonController extends Controller {

    public $loginMarked;
    public $myInfo;

    /**
     * 初始化
     * 如果 继承本类的类自身也需要初始化那么需要在使用本继承类的类里使用parent::_initialize();
     */
    public function _initialize() {

        $this->loginMarked = md5(C('TOKEN.admin_marked'));
        $this->checkLogin();
        //$this->getQRCode();

        $this->myInfo = $_SESSION['myInfo'];
        $this->assign("myInfo", $_SESSION['myInfo']);
    }

    /**
      +----------------------------------------------------------
     * 查询关键词
      +----------------------------------------------------------
     */
    public function searchKeywords() {
        $searchArr = $_POST['search'];
        return $searchArr;
    }

    /**
      +----------------------------------------------------------
     * 生成查询条件
      +----------------------------------------------------------
     */
    public function searchCondition() {
        foreach ($this->searchKeywords() as $k => $v) {
            $condition[$k] = array('like', '%' . $v . '%');
        }
        return $condition;
    }

    protected function getQRCode($url = NULL) {
        if (IS_POST) {
            $this->assign("QRcodeUrl", "");
        } else {
//            $url = empty($url) ? C('WEB_ROOT') . $_SERVER['REQUEST_URI'] : $url;
            $url = empty($url) ? C('WEB_ROOT') . U(MODULE_NAME . '/' . ACTION_NAME) : $url;
            /**
              import('QRCode');
              $QRCode = new QRCode('', 80);
              $QRCodeUrl = $QRCode->getUrl($url);
              $this->assign("QRcodeUrl", $QRCodeUrl);
             */
        }
    }

    public function checkLogin() {
        if (isset($_COOKIE[$this->loginMarked])) {
            $cookie = explode("_", $_COOKIE[$this->loginMarked]);
            $timeout = C("TOKEN");
            if (time() > (end($cookie) + $timeout['admin_timeout'])) {
                setcookie("$this->loginMarked", NULL, -3600, "/");
                unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                $this->error("登录超时，请重新登录", U("Admin/Public/index"));
            } else {
                if ($cookie[0] == $_SESSION[$this->loginMarked]) {
                    setcookie("$this->loginMarked", $cookie[0] . "_" . time(), 0, "/");
                } else {
                    //setcookie("$this->loginMarked", NULL, -3600, "/");
                    //unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                    //$this->error("帐号异常，请重新登录", U("Public/index"));
                }
            }
        } else {
            $this->redirect("Admin/Public/index");
        }
        return TRUE;
    }

    /**
     * 验证token信息
     */
    protected function checkToken() {
        if (IS_POST) {
            if (!M("User")->autoCheckToken($_POST)) {
                die(json_encode(array('status' => 0, 'info' => '令牌验证失败')));
            }
            unset($_POST[C("TOKEN_NAME")]);
        }
    }

    /**
     * 显示一级菜单
     */
    private function show_menu() {
        $cache = C('admin_big_menu');
        $count = count($cache);
        $i = 1;
        $menu = "";
        foreach ($cache as $url => $name) {
            if ($i == 1) {
                $css = $url == CONTROLLER_NAME || !$cache[CONTROLLER_NAME] ? "fisrt_current" : "fisrt";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            } else if ($i == $count) {
                $css = $url == CONTROLLER_NAME ? "end_current" : "end";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            } else {
                $css = $url == CONTROLLER_NAME ? "current" : "";
                $menu.='<li class="' . $css . '"><span><a href="' . U($url . '/index') . '">' . $name . '</a></span></li>';
            }
            $i++;
        }
        return $menu;
    }

    /**
     * 显示二级菜单
     */
    private function show_sub_menu() {
        $big = CONTROLLER_NAME == "Index" ? "Common" : CONTROLLER_NAME;
        $cache = C('admin_sub_menu');
        $sub_menu = array();
        if ($cache[$big]) {
            $cache = $cache[$big];
            foreach ($cache as $url => $title) {
                $url = $big == "Common" ? $url : "$big/$url";
                $sub_menu[] = array('url' => U("$url"), 'title' => $title);
            }
            return $sub_menu;
        } else {
            return $sub_menu[] = array('url' => '#', 'title' => "该菜单组不存在");
        }
    }

}