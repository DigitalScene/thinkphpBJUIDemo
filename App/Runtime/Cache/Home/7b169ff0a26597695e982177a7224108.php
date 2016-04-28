<?php if (!defined('THINK_PATH')) exit();?><ul class="nav navbar-nav">
    <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(is_array($vo['child'][0])){ ?>
         <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?><span class="caret"></span></a>
             <ul class="dropdown-menu">
                 <?php foreach($vo['child'] as $childKey=>$childValue){ ?>
                 <li><?php echo ($childValue["link"]); ?></li>
                 <?php } ?>
             </ul>
         </li>
         <?php }else{ ?>
         <li <?php if($vo["cid"] == $_GET["cid"]){echo 'class="active"';}elseif($key == 0 && $_GET[cid] == ""){echo 'class="active"';} ?>><?php echo ($vo["link"]); ?></li>
         <?php } endforeach; endif; else: echo "" ;endif; ?>
</ul>