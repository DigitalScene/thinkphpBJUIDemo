<?php

/**
 * @author Zhao Xiace <xvpindex@qq.com>
 * @link http://www.ewsd.cn
 * @copyright Copyright (C) 2014 Zhao Xiace
 * @datetime 2014-10-15 12:40
 * @version 1.0
 * @description
 */

namespace Admin\Model;

use Think\Model;
use Common\Model\CommonModel;

class AccessModel extends CommonModel {

    public $thead = array(
        'uid' => 'ID',
        'username' => '账号',
        'statusText' => '状态',
        'nameLink' => '姓名',
        'sex' => '性别',
        'duty' => '职务',
        'company' => '公司',
        'department' => '部门',
        'remark' => '备注',
        'cTime' => '开通时间'
    );

    public function nodeList() {
        $cat = new \Com\Category('AuthRule', array('id', 'pid', 'title', 'fullname'));
        $temp = $cat->getList();               //获取分类结构
        $level = array("1" => "项目（GROUP_NAME）", "2" => "模块(MODEL_NAME)", "3" => "操作（ACTION_NAME）");
        foreach ($temp as $k => $v) {
            $temp[$k]['statusText'] = $v['status'] == 1 ? "启用" : "禁用";
            $temp[$k]['chStatusText'] = $v['status'] == 0 ? "启用" : "禁用";
            $temp[$k]['level'] = $level[$v['level']];
            $list[$v['id']] = $temp[$k];
        }
        unset($temp);
        return $list;
    }

    public function roleList() {
        $M = M("AuthGroup");
        $list = $M->select();
        foreach ($list as $k => $v) {
            $list[$k]['statusText'] = $v['status'] == 1 ? "启用" : "禁用";
            $list[$k]['chStatusText'] = $v['status'] == 0 ? "启用" : "禁用";
        }
        return $list;
    }

    public function opStatus($op = 'Node') {
        $M = M("$op");
        $datas['id'] = (int) $_GET["id"];
        $datas['status'] = $_GET["status"] == 1 ? 0 : 1;
        if ($M->save($datas)) {
            return array('statusCode' => 200, 'message' => "处理成功", 'data' => array("status" => $datas['status'], "txt" => $datas['status'] == 1 ? "禁用" : "启动"));
        } else {
            return array('statusCode' => 300, 'message' => "处理失败");
        }
    }

    public function editNode() {
        $M = M("AuthRule");
        return $M->save($_POST) ? array('statusCode' => 200, 'message' => '更新节点信息成功', 'url' => U('Access/nodeList'), 'closeCurrent' => true) : array('statusCode' => 300, 'message' => '更新节点信息失败', 'closeCurrent' => true);
    }

    public function addNode() {
        $M = M("AuthRule");
        return $M->add($_POST) ? array('statusCode' => 200, 'message' => '添加节点信息成功', 'url' => U('Access/nodeList')) : array('statusCode' => 300, 'message' => '添加节点信息失败', 'closeCurrent' => true);
    }

    /**
      +----------------------------------------------------------
     * 管理员列表
      +----------------------------------------------------------
     */
    public function adminList() {

        $list = $this->getPageList($param = array('modelName' => 'User', 'field' => '*', 'order' => 'uid ASC', 'listRows' => '20'), $condition = '');
        $userInfo = $this->getUserFullNameByUid();
        foreach ($list['info'] as $k => $v) {
            $list['info'][$k]['nameLink'] = $userInfo[$v['uid']];
            $list['info'][$k]['statusText'] = $v['status'] == 1 ? "启用" : "禁用";
        }
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 添加管理员
      +----------------------------------------------------------
     */
    public function addAdmin() {
        if (!is_email($_POST['email'])) {
            return array('statusCode' => 300, 'message' => "邮件地址错误");
        }
        $datas = array();
        $M = M("User");
        $datas['email'] = trim($_POST['email']);
        if ($M->where("`email`='" . $datas['email'] . "'")->count() > 0) {
            return array('statusCode' => 300, 'message' => "已经存在该账号");
        }
        $datas['pwd'] = encrypt(trim($_POST['pwd']));
        $datas['time'] = time();
        if ($M->add($datas)) {
            M("RoleUser")->add(array('user_id' => $M->getLastInsID(), 'role_id' => (int) $_POST['role_id']));
            if (C("SYSTEM_EMAIL")) {
                $body = "你的账号已开通，登录地址：" . C('WEB_ROOT') . U("Public/index") . "<br/>登录账号是：" . $datas["email"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;登录密码是：" . $_POST['pwd'];
                $info = send_mail($datas["email"], "", "开通账号", $body) ? "添加新账号成功并已发送账号开通通知邮件" : "添加新账号成功但发送账号开通通知邮件失败";
            } else {
                $info = "账号已开通，请通知相关人员";
            }
            return array('statusCode' => 200, 'message' => $info, 'url' => U("Access/index"));
        } else {
            return array('statusCode' => 300, 'message' => "添加新账号失败，请重试");
        }
    }

    /**
      +----------------------------------------------------------
     * 添加管理员
      +----------------------------------------------------------
     */
    public function editAdmin() {
        $M = M("User");
        if (!empty($_POST['pwd'])) {
            $_POST['pwd'] = md5(trim($_POST['pwd']) . $_POST['username']);
        } else {
            unset($_POST['pwd']);
        }
        $user_id = (int) $_POST['uid'];
        $role_id = (int) $_POST['role_id'];
        $roleStatus = M("RoleUser")->where("`user_id`=$user_id")->save(array('role_id' => $role_id));
        unset($_POST['role_id']);
        if ($M->save($_POST)) {
//            , 'url' => U("Access/index")
            return $roleStatus == TRUE ? array('statusCode' => 200, 'message' => "成功更新") : array('statusCode' => 200, 'message' => "成功更新，但更改用户所属组失败");
        } else {
            return $roleStatus == TRUE ? array('statusCode' => 200, 'message' => "更新失败，但更改用户所属组更新成功") : array('statusCode' => 300, 'message' => "更新失败，请重试");
        }
    }

    /**
      +----------------------------------------------------------
     * 添加管理员
      +----------------------------------------------------------
     */
    public function editRole() {
        $M = M("AuthGroup");
        if ($M->save($_POST)) {
            return array('statusCode' => 200, 'message' => "成功更新", 'closeCurrent' => true);
        } else {
            return array('statusCode' => 300, 'message' => "更新失败或没有修改，请重试");
        }
    }

    /**
      +----------------------------------------------------------
     * 添加管理员
      +----------------------------------------------------------
     */
    public function addRole() {
        $M = M("AuthGroup");
        if ($M->add($_POST)) {
            return array('statusCode' => 200, 'message' => "成功添加", 'url' => U("Access/roleList"));
        } else {
            return array('statusCode' => 300, 'message' => "添加失败，请重试");
        }
    }

    public function changeRole() {
        $M = M("AuthGroup");
        // $role_id = (int) $_POST['id'];
        // $M->where("role_id=" . $role_id)->delete();
        $data = $_POST['data'];
        // if (count($data) == 0) {
        //     return array('statusCode' => 200, 'message' => "清除所有权限成功", 'url' => U("Access/roleList"));
        // }
        // $datas = array();
        // foreach ($data as $k => $v) {
        //     $tem = explode(":", $v);
        //     $datas[$k]['role_id'] = $role_id;
        //     $datas[$k]['node_id'] = $tem[0];
        //     $datas[$k]['level'] = $tem[1];
        //     $datas[$k]['pid'] = $tem[2];
        // }
        $datas['rules'] = implode(',', $data);
        $condition['id'] = $_POST['id'];
        if ($M->where($condition)->save($datas)) {
            return array('statusCode' => 200, 'message' => "保存成功", 'closeCurrent' => true);
        } else {
            return array('statusCode' => 300, 'message' => "保存失败或没有更改权限");
        }
    }

}

?>
