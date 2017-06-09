<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>网站设置分类列表</h3>
            <ul class="tab-base">
                <li><a href="<?php echo ($kot==0) ? 'javascript:;" class="current' : '/kocp/setcat/lists'; ?>"><span>管理</span></a></li>
                <li><a href="<?php echo ($kot==1) ? 'javascript:;" class="current' : '/kocp/setcat/add/kot/1'; ?>"><span><?php echo ((!empty($row)&&$kot==1) ? '修改' : '新增') ?></span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
<?php if ($kot == 0) : ?>
    <table class="table tb-type2 nobdb">
        <thead>
            <tr class="thead">
                <th>ID</th>
                <th>名称</th>
                <th class="align-center">排序</th>
                <th class="align-center">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($data_arr)) : foreach ($data_arr as $v) : ?>
            <tr class="hover edit">
                <td nowrap><?php echo $v['id']; ?></td>
                <td nowrap><?php echo $v['name']; ?></td>
                <td class="align-center" nowrap><?php echo $v['sort']; ?></td>
                <td class="align-center" nowrap>
                    <a href="/kocp/setcat/add/kot/1/id/<?php echo $v['id']; ?>">编辑</a> | 
                    <a href="/kocp/setcat/del/id/<?php echo $v['id']; ?>" onclick="if(confirm('删除该菜单将会同时删除该菜单的所有下级菜单，您确定要删除吗？')) return true; return false;">删除</a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
<?php elseif ($kot == 1) : ?>
    <form id="ko_sub_form" enctype="multipart/form-data" method="post">
        <table class="table tb-type2 nobdb">
            <tr class="noborder">
                <td class="required" nowrap><label class="validation">分类名称</label></td>
                <td class="rowform" width="100%"><input type="text" value="<?php echo $row['name']; ?>" name="name" class="txt"/></td>
            </tr>
            <tr class="noborder">
                <td class="required" nowrap>排序</td>
                <td class="rowform"><input type="text" value="<?php echo $row['sort']; ?>" name="sort" class="txt"/></td>
            </tr>
            <tr class="tfoot">
                <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="ko_submitBtn"><span>提交保存</span></a></td>
            </tr>
        </table>
    </form>
<script type="text/javascript">
$(function() {
    $('#ko_submitBtn').click(function() {
        if ($('#ko_sub_form').valid()) {
            $('#ko_sub_form').submit();
        }
    });
});
$(document).ready(function() {
    $('#ko_sub_form').validate({
        errorPlacement: function(error, element) {
            error.appendTo( element );
        },
        success: function(label) {
            label.addClass('valid');
        },
        rules: {
            name: {
                required: true                
            }
        },
        messages: {
            name: {
                required: '请输入分类名称'
            }
        }
    });
});
</script>    
<?php endif; ?>   
</div>