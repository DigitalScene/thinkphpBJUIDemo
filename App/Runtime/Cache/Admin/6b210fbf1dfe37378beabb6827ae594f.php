<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <!-- 内容区 -->
    <form action="<?php echo U($tdink.ACTION_NAME);?>" class="pageForm" data-toggle="validate" data-reload-navtab="true">
        <table data-toggle="tablefixed" data-widtd="100%" data-layout-h="0" data-nowrap="true">
            <tr>
                <td widtd="120">
                    <label class="control-label x100">邮件服务器：</label>
                    <input name="smtp_host" type="text" size="40" value="<?php echo C('smtp_host');?>" />
                </td>
                <td>
                    <label class="control-label x100">邮件发送端口：</label>
                    <input name="smtp_port" type="text" size="40" value="<?php echo C('smtp_port');?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label class="control-label x100">发件人地址：</label>
                    <input name="from_email" type="text" size="40" value="<?php echo C('from_email');?>" />
                </td>
                <td>
                    <label class="control-label x100">发件人名称：</label>
                    <input name="from_name" type="text" size="40" value="<?php echo C('from_name');?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label class="control-label x100">验证用户名：</label>
                    <input name="smtp_user" type="text" size="40" value="<?php echo C('smtp_user');?>" />
                </td>
                <td>
                    <label class="control-label x100">验证密码：</label>
                    <input name="smtp_pass" type="password" size="40" value="<?php echo C('smtp_pass');?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label class="control-label x100">回复EMAIL：</label>
                    <input name="reply_email" type="text" size="40" value="<?php echo C('reply_email');?>" placeholder="留空则为发件人EMAIL" /></td>
                <td>
                    <label class="control-label x100">回复名称：</label>
                    <input name="reply_name" type="text" size="40" value="<?php echo C('reply_name');?>" placeholder="留空则为发件人名称" /></td>
            </tr>
            <tr>
                <td>
                    <label class="control-label x100">接收测试邮件地址：</label>
                    <input name="test_email" type="text" size="40" value="<?php echo C('test_email');?>" placeholder="只有填写了接收测试邮件地址方可测试邮件配置是否成功" /></td>
                <td>
                <label class="control-label x100"></label>
                    
                </td>
            </tr>
        </table>
        <div class="bjui-footBar">
            <!-- 底部工具条  -->
            <ul>
                <li><button type="button" class="btn-close">关闭</button></li>
                <li><button type="submit" class="btn-default">保存</button></li>
            </ul>
        </div>
    </form>
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
    $(".submit").click(function() {
        ajaxSubmit();
    });
    $(".test").click(function() {
        if ($.trim($("input[name='test_email']").val()) == '') {
            popup.alert("没有填写接收测试邮件地址，无法发送测试邮件");
            return;
        }
        ajaxSubmit('<?php echo U("Webinfo/testEmailConfig");?>');
    });
</script>