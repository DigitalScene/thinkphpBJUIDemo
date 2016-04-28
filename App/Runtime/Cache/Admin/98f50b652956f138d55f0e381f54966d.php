<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <div data-layout-h="0">
        <!-- 内容区 -->
        <form>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td style="text-align: left;" colspan="4">
                            <label>
                                <input name="" class="chooseAll" type="checkbox" />全选</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input name="" class="unsetAll" type="checkbox" />反选</label>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($caches)): $k = 0; $__LIST__ = $caches;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cache): $mod = ($k % 2 );++$k; if($k%2==1) echo "
                            <tr>"; ?>
                        <td width="30" align="center">
                            <input type="checkbox" name="cache[]" value="<?php echo ($key); ?>" />
                        </td>
                        <td><?php echo ($cache["name"]); ?>
                            <br/>(<?php echo ($cache["path"]); ?>)</td>
                        <?php if($k%2==0) echo "</tr>"; endforeach; endif; else: echo "" ;endif; ?>
                    <?php if(count($caches)%2==1) echo '
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>'; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <label>
                                <input name="" class="chooseAll" type="checkbox" />全选</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input name="" class="unsetAll" type="checkbox" />反选</label>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <div class="bjui-footBar">
        <!-- 底部工具条  -->
        <button class="btn btn-sm btn-info submit">清除已选缓存</button>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        clickCheckbox();
        $(".submit").click(function() {
            if ($("tbody input[type='checkbox']:checked").size() == 0) {
                popup.alert("请先选择要删除的缓存吧");
                return false;
            }
            ajaxSubmit();
        });
    });
</script>