<?php

/**
 * @author 小策一喋 <xvpindex@qq.com>
 * @link http://www.topstack.cn
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-17  12:40:31
 * @version 1.0
 * @description
 */

namespace Home\Controller;

use Think\Controller;

class ArticleController extends CommonController {

    /**
      +----------------------------------------------------------
     * 定义
      +----------------------------------------------------------
     */
    protected $model;

    /**
      +----------------------------------------------------------
     * 初始化
      +----------------------------------------------------------
     */
    public function _initialize() {
        parent::_initialize();
        $this->model = D('Admin/Article');
    }

    public function api() {
        $randList = $this->model->getRandList();
        foreach ($randList['info'] as $k => $v) {
            $randList['info'][$k]['url'] = U('Article/detail@www.ewsd.cn', 'id=' . $v['id']);
        }
        $this->ajaxReturn($randList);
    }

    public function getApiData() {

        $content = json_decode(file_get_contents('http://localhost:86/Article/api'));
        foreach ($content->info as $k => $v) {
            echo '<li><a target="_blank" href="' . $v->url . '">' . $v->title . '</a></li>';
        }
    }

    public function index() {

        $condition['fid'] = I('get.cid');
        $condition['model'] = 'article';
        $topCate = $this->model->getList($param = array('modelName' => 'Channel', 'field' => '*', 'order' => 'oid ASC'), $condition);
        $Article = M('Article');
        $field = array('id', 'cid', 'title', 'summary', 'uTime');
        foreach ($topCate as $k => $v) {
            $cids[] = $v['cid'];
        }
        $cids[] = I('get.cid');
        $articleCondition = array('cid' => array('IN', $cids));
        $this->articleList = $this->model->getCommonPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'id DESC', 'listRows' => '10'), $articleCondition);

        $this->display();
    }

    /**
      +----------------------------------------------------------
     * 文章查询
      +----------------------------------------------------------
     */
    public function search() {

        $randList = $this->model->getRandList();
        $articleMap['title|content'] = array('LIKE', '%' . I('get.keyWords') . '%');
        $articleList = $this->model->getListbyAll($order = 'uTime DESC', $articleMap);
        
        $this->assign('randList', $randList['info']);
        $this->assign('articleList', $articleList["info"]);
        $this->assign('page', $articleList["page"]);
        $this->display();
    }

    public function articleList() {

        $this->commonList();
        $this->display();
    }

    public function page() {

        $this->display();
    }

    public function _before_detail() {

        $condition['id'] = I('get.id');
        $this->model->toSetInc($param = array('modelName' => 'Article'), 'visitNums', 1, $condition);
    }

    public function detail() {
        $id = I('get.id');
        $this->model->visitNumAdd($id);
        //$randList = $this->model->getRandList();
        $articleDetail = $this->model->getDetailById($id);
        
        //$this->assign('randList', $randList['info']);
        $this->assign('articleDetail', $articleDetail);

        $this->assign('front', $this->model->getFront($id));
        $this->assign('after', $this->model->getAfter($id));
        
        $this->display();
    }

    public function articleSearch() {

        $articleMap['cid'] = $channelDetail["id"];
        $articleList = $this->model->getPageList($param = array('modelName' => 'Article', 'field' => '*', 'order' => 'id DESC', 'listRows' => '10'), $articleMap);

        $this->assign('articleList', $articleList["info"]);
        $this->assign('page', $articleList["page"]);
        $this->display("articleList");
    }

}

?>