<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U($Think.ACTION_NAME);?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <div class="bjui-searchBar">
            <label>姓名：</label><input type="text" name="search[name]" value="<?php echo ($search["name"]); ?>" class="form-control" size="10" />
            <label>员工号：</label><input type="text" name="search[username]" value="<?php echo ($search["username"]); ?>" class="form-control" size="10" /></li>
            <button type="submit" class="btn-default" data-icon="search">查询</button>
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">功能操作<span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a href="<?php echo U('addAdmin');?>" data-toggle="dialog" data-width="1000" data-height="600" data-id="dialog-mask" data-mask="true">新增数据</a></li></ul>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="bjui-pageContent">
    <!-- 内容区 -->
    <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
        <thead>
            <tr>
                <?php if(is_array($tableFields)): $i = 0; $__LIST__ = $tableFields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tvo): $mod = ($i % 2 );++$i;?><th <?php if($tvo["order"] == 1): ?>data-order-field="<?php echo ($key); ?>"<?php endif; ?>><?php echo ($tvo["name"]); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
            </tr>
        </thead>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr aid="<?php echo ($vo["aid"]); ?>">
                <?php if(is_array($tableFields)): $i = 0; $__LIST__ = $tableFields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tvo): $mod = ($i % 2 );++$i;?><td><?php echo ($vo["$key"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                <td>
                    [ <?php if($vo["email"] == C('ADMIN_AUTH_KEY')): ?>--
                        <?php else: ?><a href="/index.php/Admin/User/editAdmin/uid/<?php echo ($vo["uid"]); ?>" data-toggle="modal" data-target="#myModal">编辑</a><?php endif; ?> ]
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
</div>

<div class="bjui-pageFooter">
    <div class="pages">
        <span>每页</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
                <option value="20" <?php if($_SESSION['pageSize']== 20): ?>selected="selected"<?php endif; ?>>20</option>
                <option value="40" <?php if($_SESSION['pageSize']== 40): ?>selected="selected"<?php endif; ?>>40</option>
                <option value="60" <?php if($_SESSION['pageSize']== 60): ?>selected="selected"<?php endif; ?>>60</option>
                <option value="120" <?php if($_SESSION['pageSize']== 120): ?>selected="selected"<?php endif; ?>>120</option>
                <option value="150" <?php if($_SESSION['pageSize']== 150): ?>selected="selected"<?php endif; ?>>150</option>
            </select>
        </div>
        <span>条，共 <?php echo ($total); ?> 条</span>
    </div>
    <div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($total); ?>" data-page-size="<?php echo (session('pageSize')); ?>" data-page-current="<?php echo (session('pageCurrent')); ?>">
    </div>
</div>

<script>
    /* zxc优化开始 */

    // 解决多个列表间的字段排序冲突问题
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='orderField']").val("");
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='orderDirection']").val("");

    // 解决多个列表间的分页大小冲突问题
    var selectedPagesize = $(".page.unitBox.fade.in > .bjui-pageFooter > .pages > .selectPagesize > select").val();
    $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='pageSize']").val(selectedPagesize);
    $(".page.unitBox.fade.in > .bjui-pageFooter > .pagination-box").attr('data-page-size',selectedPagesize);

    //console.log("pageSize" + $(".page.unitBox.fade.in > .bjui-pageHeader > #pagerForm > [name='pageSize']").val());
    //console.log("selectedPagesize:" + selectedPagesize);
    //console.log("data-page-size:" + $(".page.unitBox.fade.in > .bjui-pageFooter > .pagination-box").attr('data-page-size'));

    /* zxc优化结束 */
</script>

<script type="text/javascript">
    //show完毕前执行
    $('#myModal').on('shown.bs.modal', function () {
        // 提交表单
        $(".submitForm").click(function() {
            var url;
            if ($("#pk").val()){
                url = '/index.php/Admin/User/editAdmin';
            } else {
                <?php if(ACTION_NAME != 'editAdmin'): ?>if (!isEmail($("#email").val())) {
                        popup.alert("账号邮件地址格式错误");
                        return false;
                    }
                    if ($.trim($("#pwd").val()) == '') {
                        popup.alert("密码不能为空");
                        return false;
                    }<?php endif; ?>
                url = '/index.php/Admin/User/addAdmin';
            }
            ajaxSubmit(url, '#addForm');
        });
    });       
</script>