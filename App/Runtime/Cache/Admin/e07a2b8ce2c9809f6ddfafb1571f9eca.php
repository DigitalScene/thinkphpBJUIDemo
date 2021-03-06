<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="table-edit.html" method="post">
        <input type="hidden" name="pageNum" value="${model.pageNum}">
        <input type="hidden" name="numPerPage" value="${model.numPerPage}">
        <input type="hidden" name="orderField" value="${param.orderField}">
        <input type="hidden" name="orderDirection" value="${param.orderDirection}">
        <div class="bjui-searchBar">
            <label>姓名：</label><input type="text" value="" name="name" size="10">&nbsp;
            <label>护照号：</label><input type="text" value="" name="passportno" size="8">&nbsp;
            <label>出生日期:</label><input type="text" value="" name="birthday" size="10">&nbsp;
            <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;
            <a class="btn btn-orange" href="javascript:;" onclick="$(this).navtab('reloadForm', true)" data-icon="undo">清空查询</a>&nbsp;
            <div class="alert alert-info search-inline"><i class="fa fa-info-circle"></i> 双击行可编辑</div>&nbsp;
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn-default dropdown-toggle" data-toggle="dropdown" data-icon="copy">批量操作<span class="caret"></span></button>
                    <ul class="dropdown-menu right" role="menu">
                        <li><a href="book1.xlsx" data-toggle="doexport" data-confirm-msg="确定要导出信息吗？">导出<span style="color: green;">全部</span></a></li>
                        <li><a href="book1.xlsx" data-toggle="doexportchecked" data-confirm-msg="确定要导出选中项吗？" data-idname="expids" data-group="ids">导出<span style="color: red;">选中</span></a></li>
                        <li class="divider"></li>
                        <li><a href="ajaxDone2.html" data-toggle="doajaxchecked" data-confirm-msg="确定要删除选中项吗？" data-idname="delids" data-group="ids">删除选中</a></li>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-green" data-toggle="tableditadd" data-target="#tabledit1" data-num="1" data-icon="plus">添加编辑行</button>&nbsp;
            <button type="button" class="btn-green" onclick="$(this).tabledit('add', $('#tabledit1'), 2)">添加编辑行2</button>
        </div>
    </form>
</div>

<div class="bjui-pageContent">
    <!-- 内容区 -->
    <form action="<?php echo U($Think.ACTION_NAME);?>" class="pageForm" data-toggle="validate" method="post">
        <table id="tabledit1" class="table table-bordered table-hover table-striped table-top" data-toggle="tabledit" data-initnum="0" data-layout-h="0" data-action="<?php echo U($Think.ACTION_NAME);?>">
            <thead>
                <tr data-idname="info[#index#].id">
                    <th title="显示类型"><input type="text" name="info[#index#].type" data-rule="required" value="" size="5"></th>
                    <th title="名称"><input type="text" name="info[#index#].name" data-rule="required" value="" size="10"></th>
                    <th title="代码"><input type="text" name="info[#index#].code" data-rule="required" value="" size="10"></th>
                    <th title="配置值"><input type="text" name="info[#index#].value" data-rule="required" value="" size="20"></th>
                    <th title="描述"><input type="text" name="info[#index#].desc" value="" size="30"></th>
                    <th title="" data-addtool="true" width="100">
                        <a href="javascript:;" class="btn btn-green" data-toggle="dosave">保存</a>
                        <a href="ajaxDone2.html" class="btn btn-red row-del" data-confirm-msg="确定要删除该行信息吗？">删</a>
                    </th>
                </tr>
            </thead>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($vo["id"]); ?>">
                    <td><?php echo ($vo["type"]); ?></td>
                    <td><?php echo ($vo["name"]); ?></td>
                    <td><?php echo ($vo["code"]); ?></td>
                    <td><?php echo ($vo["value"]); ?></td>
                    <td><?php echo ($vo["desc"]); ?></td>
                    <td data-noedit="true">
                        <button type="button" class="btn-green" data-toggle="doedit">编辑</button>
                        <a href="ajaxDone2.html" class="btn btn-red row-del" data-confirm-msg="确定要删除该行信息吗？">删</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        
        <div class="bjui-footBar">
            <!-- 底部工具条  -->
            <ul>
                <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
                <li><button type="submit" class="btn-default" data-icon="save">全部保存</button></li>
            </ul>
        </div>
    </form>
</div>