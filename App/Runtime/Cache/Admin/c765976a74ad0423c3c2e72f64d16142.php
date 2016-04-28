<?php if (!defined('THINK_PATH')) exit();?><div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">
            <strong>添加/编辑信息</strong>
        </h4>
    </div>
    <div class="modal-body">
        <form id="addForm" class="form-horizontal" role="form">
            <input type="hidden" id="pk" name="info[uid]" value="<?php echo ($info["uid"]); ?>" />
            <input type="hidden" name="info[username]" value="<?php echo ($info["username"]); ?>" />
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-4">
                    <input <?php if(ACTION_NAME == 'editAdmin'): ?>disabled="disabled"<?php endif; ?>name="info[username]" type="text" class="form-control input-sm" value="<?php echo ($info["username"]); ?>" />
                </div>
                <label for="inputField" class="col-sm-2 control-label">邮箱地址</label>
                <div class="col-sm-4">
                    <input name="info[email]" id="email" type="text" class="form-control input-sm" value="<?php echo ($info["email"]); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-4">
                    <input name="info[name]" type="text" class="form-control input-sm" value="<?php echo ($info["name"]); ?>" />
                </div>
                <label for="inputField" class="col-sm-2 control-label">新密码</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" name="info[pwd]" id="pwd" type="password" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">性别</label>
                <div class="col-sm-4">
                    <select name="info[sex]" class="form-control input-sm">
                        <option value=""></option>
                        <option value="1" <?php if($info[sex] == 1): ?>selected="true"<?php endif; ?>>男</option>
                        <option value="2" <?php if($info[sex] == 2): ?>selected="true"<?php endif; ?>>女</option>
                    </select>
                </div>
                <label for="inputField" class="col-sm-2 control-label">生日</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm datePicker" name="info[birthday]" type="text" value="<?php echo ($info["birthday"]); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">身份证号</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" name="info[idCardNo]" type="text" value="<?php echo ($info["idCardNo"]); ?>" />
                </div>
                <label for="inputField" class="col-sm-2 control-label">籍贯</label>
                <div class="col-sm-4">
                    <select name="info[native]" class="form-control input-sm">
                        <option value=""></option>
                        <?php if(is_array($nativeList)): $i = 0; $__LIST__ = $nativeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nativeVo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($nativeVo["cid"]); ?>" <?php if($nativeVo[cid] == $info[native]): ?>selected="true"<?php endif; ?>><?php echo ($nativeVo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">民族</label>
                <div class="col-sm-4">
                    <select name="info[nation]" class="form-control input-sm">
                        <option value=""></option>
                        <?php if(is_array($nationList)): $i = 0; $__LIST__ = $nationList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nationVo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($nationVo["cid"]); ?>" <?php if($nationVo[cid] == $info[nation]): ?>selected="true"<?php endif; ?>><?php echo ($nationVo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <label for="inputField" class="col-sm-2 control-label">毕业院校</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" name="info[education]" type="text" value="<?php echo ($info["education"]); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">学历</label>
                <div class="col-sm-4">
                    <select name="info[degree]" class="form-control input-sm">
                        <option value=""></option>
                        <?php if(is_array($degreeList)): $i = 0; $__LIST__ = $degreeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$degreeVo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($degreeVo["cid"]); ?>" <?php if($degreeVo[cid] == $info[degree]): ?>selected="true"<?php endif; ?>><?php echo ($degreeVo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <label for="inputField" class="col-sm-2 control-label">电话</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" name="info[tel]" type="text" value="<?php echo ($info["tel"]); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">手机</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" name="info[mobile]" type="text" value="<?php echo ($info["mobile"]); ?>" />
                </div>
                <label for="inputField" class="col-sm-2 control-label">办公地址</label>
                <div class="col-sm-4">
                    <input class="form-control input-sm" name="info[address]" type="text" value="<?php echo ($info["address"]); ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">状态</label>
                <div class="col-sm-4">
                    <select name="info[status]" class="form-control input-sm">
                        <?php if($info["status"] == 1): ?><option value="1" selected>启用</option>
                            <option value="0">禁用</option>
                            <?php else: ?>
                            <option value="1">启用</option>
                            <option value="0" selected>禁用</option><?php endif; ?>
                    </select>
                </div>
                <label for="inputField" class="col-sm-2 control-label">所属用户组</label>
                <div class="col-sm-4">
                    <select name="info[role_id]" class="form-control input-sm"><?php echo ($info["roleOption"]); ?></select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputField" class="col-sm-2 control-label">备注</label>
                <div class="col-sm-10">
                    <textarea name="info[remark]" rows="5" class="form-control input-sm"><?php echo ($info["remark"]); ?></textarea>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm submitForm">
                <i class="fa fa-save"></i>保存</button>
            <button type="button" class="btn btn-danger btn-sm del" link="/index.php/Admin/User/remove/id/<?php echo ($info["id"]); ?>">
                <i class="fa fa-minus"></i>删除</button>
            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">
                <i class="fa fa-remove"></i>关闭</button>
        </div>
    </div>
</div>
<script src="/Public/Js/functions.js"></script>