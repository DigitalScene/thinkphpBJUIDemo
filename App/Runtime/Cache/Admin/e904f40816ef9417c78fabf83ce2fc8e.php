<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U($Think.ACTION_NAME);?>" id="addForm" class="pageForm" data-toggle="validate" data-reload-navtab="true">
        <input type="hidden" id="pk" name="info[cid]" value="<?php echo ($info["cid"]); ?>" />
        <table class="table table-condensed table-hover" width="100%">
            <tr>
                <td width="485">
                    <label class="control-label x100">栏目名称：</label>
                    <input type="text" size="30" name="info[name]" value="<?php echo ($info["name"]); ?>" />
                </td>
                <td>
                    <label class="control-label x100">栏目模型：</label>
                    <input type="text" size="30" name="info[model]" value="<?php echo ($info["model"]); ?>" />
                </td>
            </tr>
            <tr>
                <td width="485">
                    <label class="control-label x100">栏目状态：</label>
                    <input type="radio" name="info[status]" data-toggle="icheck" value="1" data-rule="checked" data-label="启用&nbsp;&nbsp;" <?php if($info["status"] == 1): ?>checked<?php endif; ?>/>
                    <input type="radio" name="info[status]" data-toggle="icheck" value="0" data-rule="checked" data-label="禁用" <?php if($info["status"] == 0): ?>checked<?php endif; ?>/>

                </td>
                <td>
                    <label class="control-label x100">栏目地址：</label>
                    <input type="text" size="30" name="info[url]" value="<?php echo ($info["url"]); ?>" placeholder="有二级栏目的顶级栏目填"#"号" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="control-label x100">栏目关键词：</label>
                    <input type="text" style="width:784px;" name="info[keywords]" value="<?php echo ($info["keywords"]); ?>" placeholder="多关键词间用半角逗号（,）分开" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="control-label x100">栏目描述：</label>
                    <textarea data-toggle="autoheight" style="width:784px;height:50px" name="info[description]" placeholder="用于SEO的description"><?php echo ($info["description"]); ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="control-label x100">栏目摘要：</label>
                    <textarea data-toggle="autoheight" style="width:784px;height:50px" name="info[summary]" placeholder="如果不填写则系统自动截取文章前200个字符"><?php echo ($info["summary"]); ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="control-label x100">栏目内容：</label>
                    <div style="display: inline-block; vertical-align: middle;">
                        <textarea name="info[content]" style="width:784px;height:50px" data-toggle="kindeditor"><?php echo htmlspecialchars($info['content']) ?></textarea>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>

<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">保存</button></li>
    </ul>
</div>

<script type="text/javascript" src="/Static/Plugins/kindeditor/kindeditor.js"></script><script type="text/javascript" src="/Static/Plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    $(function() {
        var content;
        KindEditor.ready(function(K) {
            content = K.create('#content');
        });
        $("#checkNewsTitle").click(function() {
            $.getJSON("/index.php/Admin/Channel/checkNewsTitle", {
                title: $("#title").val(),
                id: "<?php echo ($info["id"]); ?>"
            }, function(json) {
                $("#checkNewsTitle").css("color", json.status == 1 ? "#0f0" : "#f00").html(json.info);
            });
        });
        $(".submit").click(function() {
            content.sync();
            ajaxSubmit();
            return false;
        });
    });
</script>