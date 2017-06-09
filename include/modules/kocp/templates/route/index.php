<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>网站规则配置</h3>
      <ul class="tab-base">
        <li><a href="<?php echo ($kot==0) ? 'javascript:;" class="current' : '/kocp/route/index'; ?>"><span>管理</span></a></li>
        <li><a href="<?php echo ($kot==1) ? 'javascript:;" class="current' : '/kocp/route/add/kot/1'; ?>"><span><?php echo ((!empty($row)&&$kot==1) ? '修改' : '新增') ?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
<?php if ($kot == 1) : ?>
<form id="ko_save_submit_form" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id'] ?>"/>
    <table class="table tb-type2">
        <tr>
            <td class="required" width="300" nowrap><label class="validation">标题:</label></td>            
            <td class="vatop rowform" width="100%"><input type="text" value="<?php echo $row['title']; ?>" name="title" class="txt" style="width:350px;"/></td>
        </tr>
        <?php $data = unserialize($row['route']);?>
        <tr>
            <td class="required" nowrap>规则</td>
            <td class="vatop rowform"><input type="text" value="<?php echo $data[0]; ?>" name="rule" class="txt" style="width:350px;"/></td>
        </tr>
        <tr>
            <td class="required" nowrap>模块</td>
            <td class="vatop rowform"><input type="text" value="<?php echo $data[1]['module']; ?>" name="module" class="txt" style="width:350px;"/></td>
        </tr>
        <tr>
            <td class="required" nowrap>控制器</td>
            <td class="vatop rowform"><input type="text" value="<?php echo $data[1]['controller']; ?>" name="controller" class="txt" style="width:350px;"/></td>
        </tr>
        <tr>
            <td class="required" nowrap>方法</td>
            <td class="vatop rowform"><input type="text" value="<?php echo $data[1]['action']; ?>" name="action" class="txt" style="width:350px;"/></td>
        </tr>
        <tr>
            <td class="required" nowrap>参数</td>
            <td class="vatop rowform"><input type="text" value="<?php echo isset($data[2])?implode(',',$data[2]):''; ?>" name="arr" class="txt" style="width:350px;"/></td>
        </tr>
        <tr class="tfoot">
            <td colspan="2"><a href="javascript:void(0);" class="btn" id="KOsubmitBtn"><span>提交保存</span></a></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
$(function() {
    $('#KOsubmitBtn').click(function() {
        if ($('#ko_save_submit_form').valid()) {
            $('#ko_save_submit_form').submit();
        }
    });
    $('#ko_save_submit_form').validate({
        errorPlacement: function(error, element) { error.appendTo( element.parent() ); },
        success: function(label) { label.addClass('valid'); },
        rules: {
            title: {
                required: true
            }
        },
        messages: {
            title: {
                required: '文章标题不能为空'
            }
        }
    });        
});
</script>
<?php else : ?>
  <form method="post" name="formSearch">
    <table class="tb-type1 noborder search">
        <tbody>
            <tr>
                <td nowrap>
                    标题<input type="text" value="<?php echo $title; ?>" name="title" class="w100"/>
                    <a href="javascript:document.formSearch.submit();" class="btns tooltip" title="查询"><span>立即查询</span></a>
                </td>
            </tr>
        </tbody>
    </table>
  </form>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th>ID</th>
          <th>标题</th>
          <th>规则</th>
          <th>模块</th>
          <th>控制器</th>
          <th>方法</th>
          <th>参数</th>
          <th class="w60 align-center">操作</th>
        </tr>
      </thead>
      <tbody>
    <?php if (!empty($data_arr)) : foreach ($data_arr as $v) : ?>      
        <tr class="hover">
          <td><?php echo $v['id']; ?></td>
          <td><?php echo $v['title']; ?></td>
          <?php $data = unserialize($v['route']); ?>
          <td><?php echo $data[0]; ?></td>
          <td><?php echo $data[1]['module']; ?></td>
          <td><?php echo $data[1]['controller']; ?></td>
          <td><?php echo $data[1]['action']; ?></td>
          <td><?php echo implode(',',$data[2]); ?></td>
          <td class="align-center" nowrap>
            <a href="/kocp/route/add/kot/1/id/<?php echo $v['id']; ?>">编辑</a>
            | <a href="/kocp/route/del/id/<?php echo $v['id']; ?>" onclick="if(confirm('您确定要删除吗？')) return true; return false;">删除</a>
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