<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
    <head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="keywords" content="<?php echo ($articleDetail["keywords"]); ?>" />
<meta name="description" content="<?php echo ($articleDetail["summary"]); ?>" />
<link href="<?php echo C('STATIC_PATH');?>Plugins/BJUI/themes/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo C('STATIC_PATH');?>Plugins/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/App/Home/View/eblog/Public/Css/sb-admin-2.css" />
<link rel="stylesheet" type="text/css" href="/App/Home/View/eblog/Public/Css/base.css" />
<!--[if lte IE 9]>
    <script src="<?php echo C('STATIC_PATH');?>Plugins/BJUI/other/html5shiv.min.js"></script>
    <script src="<?php echo C('STATIC_PATH');?>Plugins/BJUI/other/respond.min.js"></script>
<![endif]-->
<script src="<?php echo C('STATIC_PATH');?>Plugins/BJUI/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo C('STATIC_PATH');?>Plugins/BJUI/plugins/bootstrap.min.js"></script>
<script src="<?php echo C('STATIC_PATH');?>Plugins/jquery/plugins/jquery.imgAutoSize.js"></script>
<script src="/Public/Js/functions.js"></script>
<script>
    $(function ($) {
        $('.panel-body').imgAutoSize(30);
        $('.thumbnail').imgAutoSize(30);
    });
</script>
    <link href="<?php echo C('STATIC_PATH');?>Plugins/jquery/plugins/SuperSlide/style.css" rel="stylesheet">
    <script src="<?php echo C('STATIC_PATH');?>Plugins/jquery/plugins/SuperSlide/jquery.SuperSlide.2.1.js"></script>
    <title><?php echo C('siteName');?></title>
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/"><img src="/App/Home/View/eblog/Public/Img/logo.png"></a>
        </div>
        <div class="navbar-collapse collapse">
            <?php echo W('Channel/menu');?>
        </div><!--/.nav-collapse -->

    </div>
</div>

<div class="container " style="margin-top:80px;">

    <div class="row">

        <div class="col-md-8">

            <div class="foucebox" style="margin:0 auto">
                    <!-- 大图 -->
                    <div  class="bd">
                        <?php if(is_array($thumbnailList)): $i = 0; $__LIST__ = $thumbnailList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tVo): $mod = ($i % 2 );++$i;?><div  class="showDiv">
                                <h2><a href="/article-<?php echo ($tVo["cid"]); ?>-<?php echo ($tVo["id"]); ?>.html"><?php echo ($tVo["title"]); ?></a></h2>
                                <a href="/article-<?php echo ($tVo["cid"]); ?>-<?php echo ($tVo["id"]); ?>.html"><img src="<?php echo ($tVo["thumbnail"]); ?>" ></a>
                                <div class="foucebox_bg"></div>
                                <div>
                                    <h2><a href="/article-<?php echo ($tVo["cid"]); ?>-<?php echo ($tVo["id"]); ?>.html"><?php echo ($tVo["title"]); ?></a></h2>
                                    <p><?php echo ($tVo["summary"]); ?></p>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <!-- 小图 -->
                    <div class="hd">
                        <ul>
                            <?php if(is_array($thumbnailList)): $i = 0; $__LIST__ = $thumbnailList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tVo): $mod = ($i % 2 );++$i;?><li><a href="/article-<?php echo ($tVo["cid"]); ?>-<?php echo ($tVo["id"]); ?>.html"><img src="<?php echo ($tVo["thumbnail"]); ?>"><span class="txt"><?php echo ($tVo["title"]); ?></span><span class="txt_bg"></span><span class="mask"></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
            </div>
            <script type="text/javascript">
                jQuery(".foucebox").slide({ effect:"fold", autoPlay:true, delayTime:300, startFun:function(i){
                        //下面代码控制文字显示
                        jQuery(".foucebox .showDiv").eq(i).find("h2").css({display:"none",bottom:0}).animate({opacity:"show",bottom:"60px"},300);
                        jQuery(".foucebox .showDiv").eq(i).find("p").css({display:"none",bottom:0}).animate({opacity:"show",bottom:"10px"},300);
                    }
                });
            </script>

            <p></p>

            <div class="row">
                <?php if(is_array($topCate)): $i = 0; $__LIST__ = $topCate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-fire"></i> <a href="/index-<?php echo ($vo["fid"]); ?>-<?php echo ($vo["cid"]); ?>.html"><?php echo ($vo["name"]); ?></a></h4></div>
                            <div class="list-group">
                                <?php if(is_array($vo["article"])): $i = 0; $__LIST__ = $vo["article"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$articleVo): $mod = ($i % 2 );++$i;?><a href="/article-<?php echo ($articleVo["cid"]); ?>-<?php echo ($articleVo["id"]); ?>.html" class="list-group-item"><?php echo (cutStr($articleVo["title"],"28")); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>

        <div class="col-md-4 col-sm-12">

            <form class="form-group" action="<?php echo U('Article/search');?>">
                <div class="form-group input-group">
                    <input type="text" name="keyWords" class="form-control" placeholder="请输入标题/内容关键词" value="<?php echo ($_GET['kw']); ?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default submit"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </form>

            <div class="panel panel-red">
                <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-fire"></i> 热门文章</h4></div>
                <div class="list-group">
                    <?php $M = M("Article");$count = $M->where()->count();$Page = new \Think\Page($count, 15);$Page->setConfig("theme", "<ul class='pagination'><li><a>%totalRow% %header% %nowPage%/%totalPage% 页</a></li><li>%upPage%</li><li>%first%</li><li>%prePage%</li><li>%linkPage%</li><li>%nextPage%</li><li>%end%</li><li>%downPage%</li></ul>");$list["page"] = $Page->show();$list["info"] = $M->field("id,cid,title")->where()->order("visitNums DESC")->limit($Page->firstRow, $Page->listRows)->select();foreach ($list["info"] as $value):extract($value);?><a href="/article-<?php echo ($cid); ?>-<?php echo ($id); ?>.html" class="list-group-item"><?php echo ($title); ?></a><?php endforeach ?>
                </div>
            </div>

        </div>
    </div>
</div>

<div style="background:#385881;">
    <div class="container" style="margin-top:10px;padding-top: 10px;color: white;">
        <center>
            <?php if(is_array($channelList)): $i = 0; $__LIST__ = $channelList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><a href='<?php echo ($data["url"]); ?>'><?php echo ($data["name"]); ?></a>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
            <p style="padding-top:5px;">
                <?php echo C("sys_copyright");?> 
            </p>
            <p style="padding-top:5px; display: none;">
                <?php echo C("icp");?> <?php echo C("counter");?>
            </p>
        </center>
    </div>
</div>


</body>
</html>