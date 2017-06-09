<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>管理员</h3>
      <ul class="tab-base">
        <li><a href="<?php echo ($kot==0) ? 'javascript:;" class="current' : '/kocp/admin/index'; ?>"><span>管理</span></a></li>
        <li><a href="<?php echo ($kot==1) ? 'javascript:;" class="current' : '/kocp/admin/index/kot/1'; ?>"><span><?php echo ((!empty($row)&&$kot==1) ? '修改' : '新增') ?></span></a></li>
        <?php if ($kot==3) : ?><li><a href="JavaScript:void(0);" class="current"><span>设置用户角色</span></a></li><?php endif; ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>    
<?php if ($kot == 1) : ?>
   <form id="ko_save_submit_form" method="post">
    <table class="table tb-type2">
        <tr class="noborder">
            <td class="required" width="300" nowrap><label class="validation">用户名:</label></td>            
            <td class="vatop rowform" width="100%"><input type="text" value="<?php echo $row['users']; ?>" name="name"<?php if ($row) {echo ' readonly="true"';} ?> class="txt"/></td>
        </tr>
        <tr>
            <td class="required" nowrap><label<?php if (empty($row)) { echo ' class="validation"'; } ?>>登录密码:</label></td>
            <td class="vatop rowform"><input type="password" value="" autocomplete="off" placeholder="修改时为空默认不修改" name="pwd" class="txt"/></td>
        </tr>     
         <tr>
            <td class="required" nowrap><label<?php if (empty($row)) { echo ' class="validation"'; } ?>>邮箱:</label></td>
            <td class="vatop rowform"><input type="text" value="<?php echo $row['email']; ?>" name="email" class="txt"/></td>
        </tr>     
        <tr>
            <td class="required"><label class="validation">姓名:</label></td>
            <td class="vatop rowform"><input type="text" value="<?php echo $row['nick']; ?>" name="nick" class="txt"/></td>          
        </tr><?php if ($row['id']!=1) : ?>
        <tr>
            <td class="required" nowrap><label>账号状态:</label></td>            
            <td class="vatop onoff" nowrap>
                <label for="status1" class="cb-enable <?php echo (($row['status']==1||empty($row))?'selected':''); ?>"><span>正常</span></label>
                <label for="status2" class="cb-disable <?php echo ($row['status']==2?'selected':''); ?>" ><span>冻结</span></label>
                <input id="status1" name="status" <?php echo (($row['status']==1||empty($row))?'checked="checked"':''); ?> value="1" type="radio"/>
                <input id="status2" name="status" <?php echo ($row['status']==2?'checked="checked"':''); ?> value="2" type="radio"/>                
            </td>
        </tr><?php endif; ?>
        <tr class="tfoot">
          <td colspan="2"><a href="javascript:void(0);" class="btn" id="submitBtn"><span>提交保存</span></a></td>
        </tr>
    </table>
  </form>
<script type="text/javascript">
//按钮先执行验证再提交表单
$(function(){
	$('#submitBtn').click(function(){
	    if ($('#ko_save_submit_form').valid()) {
			$('#ko_save_submit_form').submit();
		}
	});
});
$(document).ready(function(){
	$('#ko_save_submit_form').validate({
        errorPlacement: function(error, element){
			error.appendTo( element.parent() );
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
        <?php if (empty($row)) : ?>
            pwd : {
                required : true
            },
        <?php endif; ?>            
            name : {
                required : true
            },
            nick : {
                required : true
            }
        },
        messages : {
        <?php if (empty($row)) : ?>    
            pwd : {
                required : '登录密码不能为空'
            },
        <?php endif; ?>    
            name : {
                required : '用户名不能为空'
            },
            nick : {
                required : '姓名不能为空'
            }
        }
    });
});
</script>
<?php elseif ($kot == 3) : ?>
<script type="text/javascript">
$(function(){
    $("#xz").click(function(){
        if($(this).is(':checked')) {
            $("input[name='uids[]']").prop('checked', true);
        }else{
            $("input[name='uids[]']").prop('checked', false);
        }
    });
    $("#xz1").click(function(){
        if($(this).is(':checked')) {
            $("input[name='mids[]']").prop('checked', true);
        }else{
            $("input[name='mids[]']").prop('checked', false);
        }
    });
})
</script>
  <form method="post" id="ko_save_class_form">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
    <table class="table tb-type2">
        <tr class="noborder">
            <td class="required" width="300" nowrap><label>当前用户:</label></td>
            <td class="required" width="100%" nowrap><label>用户昵称:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform"><input type="text" value="<?php echo $row['users']; ?>" disabled="true" class="txt"/></td>          
            <td class="vatop rowform"><input type="text" value="<?php echo $row['nick']; ?>" disabled="true" class="txt"/></td>
        </tr>
        
        <!-- 权限设置  -->        
        <tr><td class="required" nowrap colspan="2"><label>设置菜单权限：</label></td></tr>
        <tr class="noborder">
        <td><input type="checkbox"  id="xz1" />全选</td>
        <td nowrap>
        <?php $mids=array(); if ($row['mids']!='') { $mids = explode(',', $row['mids']); } $a_left = Dao_Site::get_backmenu_data(1,0); if (!empty($a_left)) : foreach($a_left as $qxk => $qxv) :  ?>
        <input type="checkbox" name="mids[]"<?php if (in_array($qxv['id'], $mids)) { echo ' checked="checked"';} ?> value="<?php echo $qxv['id']; ?>" /><?php echo $qxv['name']; ?>&nbsp;<?php if (($qxk+1)%5==0) { echo '<br>'; } ?>
        <?php endforeach; ?>
        </td>
        </tr>
        <?php endif; ?>
        
        <tr>
            <td class="required" colspan="2" nowrap><label>设置用户权限:</label></td>
        </tr>
        <tr class="noborder">
            <td><input type="checkbox"  id="xz" />全选</td>
            <td class="vatop rowform" nowrap colspan="2">
        <?php $uids=array(); if ($row['uids']!='') { $uids = explode(',', $row['uids']); } foreach($manager as $jk => $v) : ?>
                <?php if($v['id'] == 1) continue;?>
                <input type="checkbox" name="uids[]"<?php if (in_array($v['id'], $uids)) { echo ' checked="checked"';} ?> value="<?php echo $v['id']; ?>"/><?php echo $v['nick']; ?>&nbsp;&nbsp;<?php if (($jk+1)%6==0) { echo '<br>'; } ?>
        <?php endforeach;?>                
            </td>
        </tr>
        
        <tr>
            <td class="required" colspan="2" nowrap><label>设置部门权限:</label></td>
        </tr>
        <tr class="noborder">
            <td><input type="checkbox" />全选</td>
            <td class="vatop rowform" nowrap colspan="2">
                <?php $bms=array(); if ($row['bms']!='') { $bms = explode(',', $row['bms']); } ?>
                <input type="checkbox" name="bms[]"<?php if (in_array(1, $bms)) { echo ' checked="checked"';} ?> value="1"/>移动线上事业部&nbsp;&nbsp;
                <input type="checkbox" name="bms[]"<?php if (in_array(2, $bms)) { echo ' checked="checked"';} ?> value="2"/>PC线上事业部&nbsp;&nbsp;
                <input type="checkbox" name="bms[]"<?php if (in_array(3, $bms)) { echo ' checked="checked"';} ?> value="3"/>市场部&nbsp;&nbsp;
                <input type="checkbox" name="bms[]"<?php if (in_array(4, $bms)) { echo ' checked="checked"';} ?> value="4"/>信息技术部&nbsp;&nbsp;
            </td>
        </tr>
        
        <tr class="tfoot">
            <td colspan="2" ><a href="javascript:void(0);" onclick="$('#ko_save_class_form').submit();" class="btn"><span>提交保存</span></a></td>
        </tr>
    </table>
  </form>
<?php else : ?>
  <form method="post" name="formSearch">
    <table class="tb-type1 noborder search">
        <tbody>
            <tr>
                <th><label for="search_title">用户名</label></th>
                <td><input type="text" value="<?php echo $user; ?>" name="name" class="w200"></td>
                <th><label for="search_title">姓名</label></th>
                <td><input type="text" value="<?php echo $nick; ?>" name="nick" class="w200"></td>
                <th><label for="search_ac_id">账号状态</label></th>
                <td><?php echo Dao_Site::get_select_html('status', array(array('id'=>1,'name'=>'正常'),array('id'=>2,'name'=>'冻结')), $status); ?></td>
                <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="查询">&nbsp;</a></td>
            </tr>
        </tbody>
    </table>
  </form>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>ID</th>
          <th>用户名</th>
          <th>姓名</th>
          <th>状态</th>
          <th>登录次数</th>
          <th class="align-center">最后登录IP</th>
          <th class="align-center">最后登录时间</th>
          <th class="w60 align-center">操作</th>
        </tr>
      </thead>
      <tbody>
    <?php if (!empty($data_arr)) : foreach ($data_arr as $v) : ?>      
        <tr class="hover">
          <td><?php echo $v['id']; ?></td>
          <td><?php echo $v['users']; ?></td>
          <td><?php echo $v['nick']; ?></td>          
          <td><?php echo ($v['status']==1 ? '正常' : '冻结'); ?></td>
          <td><?php echo $v['login_num']; ?></td>
          <td class="nowrap align-center"><?php echo $v['last_ip']; ?></td>
          <td class="nowrap align-center"><?php echo ($v['last_at']>0 ?date('Y-m-d H:i:s', $v['last_at']) : ''); ?></td>
          <td class="align-center" nowrap>
              <a href="/kocp/admin/index/kot/1/id/<?php echo $v['id']; ?>">编辑</a>
              | <a href="<?php echo '/kocp/admin/index/kot/3/id/'.$v['id']; ?>">设置权限</a>
              | <a href="javascript:if(confirm('您确定要删除该管理员吗？'))window.location='/kocp/admin/index/kot/2/id/<?php echo $v['id']; ?>';">删除</a>
          </td>
        </tr>
    <?php endforeach; endif; ?>    
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="20"><?php include(KO_TEMPLATES_PATH . '/cp_page.php'); ?></td>
        </tr>
      </tfoot>
    </table>
<?php endif; ?>  
</div>