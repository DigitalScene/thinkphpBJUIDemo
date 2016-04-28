<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="<?php echo U(ACTION_NAME);?>" method="post">
        <input type="hidden" name="pageSize" value="<?php echo (session('pageSize')); ?>">
        <input type="hidden" name="pageCurrent" value="<?php echo (session('pageCurrent')); ?>">
        <input type="hidden" name="orderField" value="<?php echo (session('orderField')); ?>">
        <input type="hidden" name="orderDirection" value="<?php echo (session('orderDirection')); ?>">
        <div class="bjui-searchBar">
            <label>共有<?php echo ($files); ?>个压缩包文件，共计<?php echo ($total); ?></label>
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default delZipFiles">删除所选</button>
                    <button type="button" class="btn-green unzipSelect">解压缩所选</button>
                    </ul>
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
                    <th>压缩包名称</th>
                    <th>打包时间</th>
                    <th>文件大小</th>
                    <th>解压</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$zip): $mod = ($i % 2 );++$i;?><tr>
                        <td>
                            <input type="checkbox" name="zipFiles[]" value="<?php echo ($zip["file"]); ?>" />
                        </td>
                        <td align="left"><a href="<?php echo U('SysData/downFile',array('file'=>$zip['file'],'type'=>'zip'));?>" target="_blank"><?php echo ($zip["file"]); ?></a>
                        </td>
                        <td><?php echo ($zip["time"]); ?></td>
                        <td><?php echo ($zip["size"]); ?></td>
                        <td>
                            <button class="btn unzip" file="<?php echo ($zip["file"]); ?>">解压</button>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <tr>
                        <th width="90">
                            <label>
                                <input name="" class="chooseAll" type="checkbox" />全选</label>
                            <label>
                                <input name="" class="unsetAll" type="checkbox" />反选</label>
                        </th>
                        <th>压缩包名称</th>
                        <th>备份时间</th>
                        <th>总计：<?php echo ($total); ?></th>
                        <th>解压</th>
                    </tr>
            </tbody>
        </table>
    </form>
</div>

<script type="text/javascript">
    $(function() {
        //全新反选
        clickCheckbox();

        var repeat = function(url) {
            $.post(url, function(json) {
                //                        var json = eval("(" + json + ")");
                if (json.status == 1) {
                    if (json.url) {
                        $("#opStatus").html(json.info);
                        repeat(json.url);
                    } else {
                        popup.success(json.info, 'oh yeah', function(action) {
                            if (action == 'ok') {
                                $("#opStatus").hide('solw');
                                $(".unzipSelect").html('解压缩所选');
                            }
                        });
                        $(".btn").removeAttr("disabledSubmit");
                    }
                } else {
                    popup.error(json.info);
                }
            });
        }

        $(".unzipSelect").click(function() {
            if ($(this).attr("disabledSubmit")) {
                popup.alert("已提交，系统在处理中...");
                return false;
            }
            if ($("tbody input[type='checkbox']:checked").size() == 0) {
                popup.alert("请先选择你要删除的数据库表吧");
                return false;
            }
            var files = [];
            $("tbody input[type='checkbox'][name='zipFiles[]']:checked").each(function(i) {
                files[i] = $(this).val();
            });
            $.post("/index.php/Admin/SysData/unzipSqlfile", {
                'zipFiles': files
            }, function(json) {
                //                        var json = eval("(" + json + ")");
                if (json.status == 1) {
                    if (json.url) {
                        $("#opStatus").show().html(json.info);
                        repeat(json.url);
                    } else {
                        popup.success(json.info);
                    }
                    popup.close("asyncbox_alert");
                } else {
                    popup.error(json.info);
                }
            });

            return false;
        });


        $(".unzip").click(function() {
            $.post("/index.php/Admin/SysData/unzipSqlfile", {
                'zipFiles[]': $(this).attr("file")
            }, function(json) {
                //                        var json = eval("(" + json + ")");
                json.status == 1 ? popup.success(json.info) : popup.error(json.info);
                $(".btn").removeAttr("disabledSubmit");
                if (json.url && json.url != '') {
                    setTimeout(function() {
                        top.window.location.href = json.url;
                    }, 2000);
                }
            });
            return false;
        });
        //删除备份文件
        $(".delZipFiles").click(function() {
            if ($(this).attr("disabledSubmit")) {
                popup.alert("已提交，系统在处理中...");

            }
            if ($("tbody input[type='checkbox']:checked").size() == 0) {
                popup.alert("请先选择你要删除的zip文件吧");
                return false;
            }
            popup.confirm('你确定要删除备份文件吗？', '温馨提示', function(action) {
                if (action == 'ok') {
                    $(".btn").attr("disabledSubmit", true);
                    $(this).html("提交处理中...");
                    ajaxSubmit("/index.php/Admin/SysData/delZipFiles");
                }
            });
            return false;
        });
    });
</script>