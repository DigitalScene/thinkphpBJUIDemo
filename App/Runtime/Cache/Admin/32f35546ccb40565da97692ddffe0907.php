<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form action="<?php echo U($Think.ACTION_NAME);?>" method="POST" class="pageForm" data-toggle="validate" data-reload="true">
            <input type="hidden" name="act" value="add" />
            <select name="data[fid]" data-toggle="selectpicker" data-rule="required">
                <option value="">请选择分类</option>
                <option value="0">顶级分类</option>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["fullname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <select name="data[model]" id="newModel" data-toggle="selectpicker" data-rule="required">
                <option value="">请选择模型</option>
                <option value="singlePage">单独页</option>
                <option value="news">新闻模型</option>
                <option value="product">产品模型</option>
            </select>
            <input placeholder="你要添加的栏目名称" id="newName" type="text" name="data[name]" value="" data-rule="required" />
            <input placeholder="你要添加的栏目代码" id="newCode" type="text" name="data[code]" value="" data-rule="required" />
            <button type="submit" class="btn-default">确定添加</button>
    </form>
</div>

<div class="bjui-pageContent">
    <!-- 内容区 -->
    <table class="table table-bordered table-hover table-striped table-top" data-layout-h="0" data-selected-multi="true">
        <thead>
            <tr>
                <th>排序</th>
                <th>原分类结构</th>
                <th>操作属性</th>
                <th>新分类</th>
                <th>修改排序</th>
                <th>显示位置</th>
                <th>栏目名称</th>
                <th>栏目模型</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tree): $mod = ($i % 2 );++$i;?><form action="<?php echo U($Think.ACTION_NAME);?>" class="pageForm" data-toggle="validate" data-reload="true">
                    <input type="hidden" name="data[cid]" value="<?php echo ($tree["cid"]); ?>" />
                    <tr>
                        <td><?php echo ($tree["oid"]); ?></td>
                        <td>
                            <?php if($tree["fid"] == 0): ?><b><?php echo ($tree["fullname"]); ?></b>
                                <?php else: echo ($tree["fullname"]); endif; ?>
                            <?php if($tree["status"] == 0): ?>[
                                <font color="red">禁</font>]<?php endif; ?>
                        </td>
                        <td>
                            <select name="act" data-toggle="selectpicker" class="act">
                                <option selected="selected" value="edit">修改分类</option>
                                <option value="del">删除分类</option>
                                <option value="add">添加子类</option>
                            </select>
                        </td>
                        <td>
                            <select name="data[fid]" data-toggle="selectpicker">
                                <option value="0">顶级分类</option>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i; if($vo1['cid'] == $tree['cid']): ?><option value="<?php echo ($vo1["cid"]); ?>" selected="selected" readonly><?php echo ($vo1["fullname"]); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($vo1["cid"]); ?>"><?php echo ($vo1["fullname"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" value="<?php echo ($tree["oid"]); ?>" name="data[oid]" placeholder="排序" size="5" />
                        </td>
                        <td>
                            <select name="data[position]" data-toggle="selectpicker">
                                <option value="1" <?php if(1 == $tree['position']): ?>selected="selected"<?php endif; ?>>顶部</option>
                                <option value="2" <?php if(2 == $tree['position']): ?>selected="selected"<?php endif; ?>>菜单</option>
                                <option value="3" <?php if(3 == $tree['position']): ?>selected="selected"<?php endif; ?>>底部</option>
                                <option value="12" <?php if(12 == $tree['position']): ?>selected="selected"<?php endif; ?>>顶部+菜单</option>
                                <option value="13" <?php if(13 == $tree['position']): ?>selected="selected"<?php endif; ?>>顶部+底部</option>
                                <option value="23" <?php if(23 == $tree['position']): ?>selected="selected"<?php endif; ?>>菜单+底部</option>
                                <option value="123" <?php if(123 == $tree['position']): ?>selected="selected"<?php endif; ?>>顶+菜+底部</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" value="<?php echo ($tree["name"]); ?>" name="data[name]" placeholder="新栏目名称" size="20" />
                        </td>
                        <td>
                            <select name="data[model]" data-toggle="selectpicker">
                                <option value="page" <?php if(page == $tree['model']): ?>selected="selected"<?php endif; ?>>单页模型</option>
                                <option value="article" <?php if(article == $tree['model']): ?>selected="selected"<?php endif; ?>>文章模型</option>
                                <option value="product" <?php if(product == $tree['model']): ?>selected="selected"<?php endif; ?>>产品模型</option>
                                <option value="url" <?php if(url == $tree['model']): ?>selected="selected"<?php endif; ?>>链接模型</option>
                                <option value="link" <?php if(link == $tree['model']): ?>selected="selected"<?php endif; ?>>外链模型</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn-default">确定</button> <a href="<?php echo U('edit?cid=' . $tree[cid]);?>" class="btn btn-default" data-toggle="dialog" data-width="1000" data-height="600" data-id="dialog-mask" data-mask="true">更多</a>
                        </td>
                    </tr>
                </form><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
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