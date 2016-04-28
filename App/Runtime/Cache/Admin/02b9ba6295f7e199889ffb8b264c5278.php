<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <!-- 内容区 -->
    <form action="<?php echo U($tdink.ACTION_NAME);?>" class="pageForm" data-toggle="validate" data-reload-navtab="true">
        <table data-toggle="tablefixed" data-widtd="100%" data-layout-h="0" data-nowrap="true">
            <tr>
                <td width="120">
                    <label class="control-label x100">后台登陆标示：</label>
                    <input name="admin_marked" type="text" size="40" value="<?php echo C('TOKEN.admin_marked');?>" placeholder="后台登陆COOKIE标示，在COOKIE里已MD5加密该值存储登陆信息" />
                </td>
                <td>
                    <label class="control-label x100">后台登陆有效期：</label>
                    <input name="admin_timeout" type="text" size="40" value="<?php echo C('TOKEN.admin_timeout');?>" placeholder="登陆后如未操作时间超过该设定值时就自动退出系统，单位为秒，最小值为100" />
                </td>
            </tr>
            <tr>
                <td>
                    <label class="control-label x100">前台登陆标示：</label>
                    <input name="member_marked" type="text" size="40" value="<?php echo C('TOKEN.member_marked');?>" />
                </td>
                <td>
                    <label class="control-label x100">前台登陆有效期：</label>
                    <input name="member_timeout" type="text" size="40" value="<?php echo C('TOKEN.member_timeout');?>" />
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
</script>