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
use Common\Model\CommonModel;

class UserModel extends CommonModel {

    /**
      +----------------------------------------------------------
     * 定义
      +----------------------------------------------------------
     */
    public $model = 'User';

    public $tableFields = array(
      'uid' => array('name'=>'UID', 'order'=>'1'),
      'username' => array('name'=>'账号', 'order'=>'1'),
      'name' => array('name'=>'姓名', 'order'=>'1'),
      'sex' => array('name'=>'性别', 'order'=>'0'),
      'status' => array('name'=>'状态', 'order'=>'1')
    );

    protected $_validate = array(
      array('name', 'require', '姓名必填！'),
      array('passwd', 'require', '密码必填！'),
      array('repasswd', 'passwd', '确认密码不正确 ', 0, 'confirm'),
      array('email', 'require', '邮箱必填！'),
      array('email', 'email', '邮箱格式错误！', 2),
      array('name', '', '姓名已存在！', 0, 'unique', self::MODEL_INSERT),
    );

    protected $_auto = array(
      array('pass', 'md5', 3, 'function'),
      array('ifadmin', '0', self::MODEL_INSERT),
      array('ip', 'get_client_ip', 3, 'function'),
      array('createtime', 'time', 3, 'function'),
    );

    /**
      +----------------------------------------------------------
     * 管理员列表
      +----------------------------------------------------------
     */
    public function index($condition) {

        $list = $this->getPageList($param = array('modelName' => 'User', 'field' => '*', 'order' => 'uid ASC', 'listRows' => '20'), $condition);
        foreach ($list['info'] as $k => $v) {
            $list['info'][$k]['name'] = CommonModel::getUserFullNameByUid($v['uid']);
            $list['info'][$k]['sex'] = $v['sex'] == 1 ? '男' : '女';
            $list['info'][$k]['company'] = $v['UserOrg'][0]['company'];
            $list['info'][$k]['department'] = $v['UserOrg'][0]['department'];
            $list['info'][$k]['office'] = $v['UserOrg'][0]['office'];
            $list['info'][$k]['duty'] = $v['UserOrg'][0]['duty'];
            $list['info'][$k]['status'] = $v['status'] == 1 ? "启用" : "禁用";
        }
        return $list;
    }

    /**
      +----------------------------------------------------------
     * 数据详情
      +----------------------------------------------------------
     */
    public function detail($condition){
        return $this->getDetail($param = array('modelName' => $this->model), $condition);
    }

    //protected $trueTableName = 'top_user';
    //获得用户详情
    public function getMemberDetailByUid($uid) {

        if (isset($uid)) {
            $map["uid"] = $uid;
            return M("User")->where($map)->find();
        }
    }

    //获得用户列表
    public function getMemberListByAll() {

        return M("User")->select();
    }

    //编辑用户
    public function edit() {
        $M = M("User");
        $data = $_POST['info'];
        $data['update_time'] = time();
        if ($M->save($data)) {
            return array('status' => 1, 'info' => "已经更新", 'url' => U('Member/index'));
        } else {
            return array('status' => 0, 'info' => "更新失败，请刷新页面尝试操作");
        }
    }

}

?>
