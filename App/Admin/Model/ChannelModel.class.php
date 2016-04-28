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

class ChannelModel extends CommonModel {

    public function listNews($firstRow = 0, $listRows = 20) {
        $M = M("Channel");
        $list = $M->field("`cid`,`title`,`status`,`published`,`id`,`aid`")->order("`published` DESC")->limit("$firstRow , $listRows")->select();
        $statusArr = array("审核状态", "已发布状态");
        $aidArr = M("User")->field("`aid`,`email`,`nickname`")->select();
        foreach ($aidArr as $k => $v) {
            $aids[$v['aid']] = $v;
        }
        unset($aidArr);
        $cidArr = M("Channel")->field("`cid`,`name`")->select();
        foreach ($cidArr as $k => $v) {
            $cids[$v['cid']] = $v;
        }
        unset($cidArr);
        foreach ($list as $k => $v) {
            $list[$k]['aidName'] = $aids[$v['aid']]['nickname'] == '' ? $aids[$v['aid']]['email'] : $aids[$v['aid']]['nickname'];
            $list[$k]['status'] = $statusArr[$v['status']];
            $list[$k]['cidName'] = $cids[$v['cid']]['name'];
        }
        return $list;
    }

    public function category() {
        if (IS_POST) {
            $act = $_POST[act];
            $data = $_POST['data'];
            $data['name'] = addslashes($data['name']);
            if ($data["model"] == "article") {
                $data["url"] = "/Article/index/code/" . $data["code"];
            } else if ($data["model"] == "product") {
                $data["url"] = "/Product/index/code/" . $data["code"];
            } else if ($data["model"] == "page") {
                $data["url"] = "/Article/page/code/" . $data["code"];
            } else {
                if ($data["url"]) {
                    $data["url"] = $data["url"];
                } else {
                    unset($data["url"]);
                }
            }
            $M = M("Channel");
            if ($act == "add") { //添加分类
                unset($data[cid]);
                $data["status"] = "1";
                $data["position"] = "2";
                if ($M->where($data)->count() == 0) {
                    return ($M->add($data)) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功添加到系统中') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 添加失败');
                } else {
                    return array('statusCode' => 200, 'message' => '系统中已经存在分类' . $data['name']);
                }
            } else if ($act == "edit") { //修改分类
                if (empty($data['name'])) {
                    unset($data['name']);
                }
                if ($data['fid'] == $data['cid']) {
                    unset($data['fid']);
                }
                return ($M->save($data)) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功更新') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 更新失败');
            } else if ($act == "del") { //删除分类
                unset($data['fid'], $data['name'], $data['model'], $data['code'], $data['position'], $data['url'], $data['oid']);
                return ($M->where($data)->delete()) ? array('statusCode' => 200, 'message' => '分类 ' . $data['name'] . ' 已经成功删除') : array('statusCode' => 300, 'message' => '分类 ' . $data['name'] . ' 删除失败');
                echo $M->getlastsql();
            }
        } else {
            $Category = new \Com\Category('Channel', array('cid', 'fid', 'name', 'fullname'));
            return $Category->getList($condition = NULL, $cid = 0, $orderby = 'oid asc'); //获取分类结构
        }
    }

    public function addNews() {
        $M = M("Channel");
        $data = $_POST['info'];
        $data['published'] = time();
        $data['aid'] = $_SESSION['my_info']['aid'];
        if (empty($data['summary'])) {
            $data['summary'] = cutStr($data['content'], 200);
        }
        if ($M->add($data)) {
            return array('status' => 1, 'info' => "已经发布", 'url' => U('Channel/index'));
        } else {
            return array('status' => 0, 'info' => "发布失败，请刷新页面尝试操作");
        }
    }

    public function edit() {
        $M = M("Channel");
        $data = $_POST['info'];
        $data['uTime'] = time();
        if ($M->save($data)) {
            return array('statusCode' => 200, 'message' => "已经更新", 'closeCurrent' => true);
        } else {
            return array('statusCode' => 300, 'message' => "更新失败，请刷新页面尝试操作".$M->getlastsql());
        }
    }

    //根据栏目代码获得栏目信息
    public function getChannelDetailByCode($code) {

        $condition['code'] = $code;
        return BaseModel::getDetail($param = array('modelName' => 'Channel'), $condition);
    }

    public function getChannelDetailById($id) {
        $condition['cid'] = $id;
        return parent::getDetail($param = array('modelName' => 'Channel'), $condition);
    }

    /**
      +----------------------------------------------------------
     * 获取频道分类信息
      +----------------------------------------------------------
     */
    public function getChannelList() {
        $channelInfoArr = parent::getList($param = array('modelName' => 'Channel', 'field' => '*', 'order' => 'oid ASC'), $condition = '');
        foreach ($channelInfoArr as $k => $v) {
            $channelInfo[$v['cid']] = $v;
        }
        return $channelInfo;
    }

}

?>
