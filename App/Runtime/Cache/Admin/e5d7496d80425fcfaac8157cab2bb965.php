<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U(ACTION_NAME);?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <div class="bjui-searchBar">
            <label>共有<?php echo (count($list)); ?>张表，共计<?php echo (byteFormat($totalsize["table"])); ?></label>
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default optimize">优化所选</button>
                    <button type="button" class="btn-green repair">修复所选</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="bjui-pageContent">
    <!-- 内容区 -->
    <form>
        <table data-toggle="tablefixed" data-width="100%" data-nowrap="true">
            <thead>
                <tr>
                    <th width="90">
                        <label>
                            <input name="" class="chooseAll" type="checkbox" />全选</label>
                        <label>
                            <input name="" class="unsetAll" type="checkbox" />反选</label>
                    </th>
                    <th>表名</th>
                    <th>表用途</th>
                    <th>记录行数</th>
                    <th>引擎类型</th>
                    <th>字符集</th>
                    <th>碎片</th>
                    <th>表大小</th>
                    <th>数据</th>
                    <th>索引</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><tr>
                        <td>
                            <input type="checkbox" name="table[]" value="<?php echo ($tab["Name"]); ?>" />
                        </td>
                        <td align="left"><?php echo ($tab["Name"]); ?></td>
                        <td><?php echo ($tab["Comment"]); ?></td>
                        <td><?php echo ($tab["Rows"]); ?></td>
                        <td><?php echo ($tab["Engine"]); ?></td>
                        <td><?php echo ($tab["Collation"]); ?></td>
                        <td><?php echo ($tab["Data_free"]); ?></td>
                        <td><?php echo ($tab["size"]); ?></td>
                        <td><?php echo ($tab["Data_length"]); ?></td>
                        <td><?php echo ($tab["Index_length"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <tr>
                        <th width="90">
                            <label>
                                <input name="" class="chooseAll" type="checkbox" />全选</label>
                            <label>
                                <input name="" class="unsetAll" type="checkbox" />反选</label>
                        </th>
                        <th>表名</th>
                        <th>表用途</th>
                        <th>记录行数</th>
                        <th>引擎类型</th>
                        <th>字符集</th>
                        <th><b><?php echo (byteFormat($totalsize["free"])); ?></b>
                        </th>
                        <th><b><?php echo (byteFormat($totalsize["table"])); ?></b>
                        </th>
                        <th><b><?php echo (byteFormat($totalsize["data"])); ?></b>
                        </th>
                        <th><b><?php echo (byteFormat($totalsize["index"])); ?></b>
                        </th>
                    </tr>
            </tbody>
        </table>
        <input type="hidden" name="act" id="act" />
    </form>
</div>

<script type="text/javascript">
    $(function() {
        clickCheckbox();
        var handle = function(act) {
            if ($("tbody input[type='checkbox']:checked").size() == 0) {
                popup.alert("请先选择你要优化的数据库表吧");
                return false;
            }
            $("#act").val(act);
            ajaxSubmit();
        }
        $(".optimize").click(function() {
            handle("optimize");
        });
        $(".repair").click(function() {
            handle("repair");
        });
    });
</script>