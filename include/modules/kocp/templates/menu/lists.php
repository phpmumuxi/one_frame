<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>菜单列表</h3>
            <ul class="tab-base">
                <li><a href="<?php echo ($kot==0) ? 'javascript:;" class="current' : '/kocp/menu/lists'; ?>"><span>管理</span></a></li>
                <li><a href="<?php echo ($kot==1) ? 'javascript:;" class="current' : '/kocp/menu/add/kot/1'; ?>"><span><?php echo ((!empty($row)&&$kot==1) ? '修改' : '新增') ?></span></a></li>
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
                <th>链接地址</th>
                <th>排序</th>
                <th class="align-center">是否显示</th>
                <th class="align-center">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($data_arr)) : foreach ($data_arr as $v) : ?>
            <tr class="hover edit">
                <td nowrap><?php echo $v['id']; ?></td>
                <td nowrap><?php echo $v['nbsp'].$v['name']; ?></td>
                <td><?php echo $v['url']; ?></td>
                <td><?php echo $v['sort']; ?></td>
                <td class="align-center"><?php echo ($v['is_show']==1 ? '是' : '否'); ?></td>                
                <td class="align-center" nowrap>
                    <a href="/kocp/menu/add/kot/1/id/<?php echo $v['id']; ?>">编辑</a> | 
                    <a href="/kocp/menu/del/id/<?php echo $v['id']; ?>" onclick="if(confirm('删除该菜单将会同时删除该菜单的所有下级菜单，您确定要删除吗？')) return true; return false;">删除</a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
<?php elseif ($kot == 1) : ?>
    <form id="ko_sub_form" enctype="multipart/form-data" method="post">
        <table class="table tb-type2 nobdb">
            <tr class="noborder">
                <td class="required" nowrap><label class="validation">菜单名称</label></td>
                <td class="rowform" width="100%"><input type="text" value="<?php echo $row['name']; ?>" name="name" class="txt"/></td>
            </tr>
            <tr>
                <td class="required"><label for="parent_id">所属上级</label></td>
                <td><?php echo Dao_Site::get_select_html('parent_id', $data_arr, $row['parent_id'], 1); ?></td>
            </tr>
            <tr class="noborder">
                <td class="required" nowrap>链接地址</td>
                <td class="rowform"><input type="text" value="<?php echo $row['url']; ?>" name="url" class="txt"/></td>
            </tr>
            <tr class="noborder">
                <td class="required" nowrap>排序</td>
                <td class="rowform"><input type="text" value="<?php echo $row['sort']; ?>" name="sort" class="txt" style="width:100px;"/>(从小到大排序)</td>
            </tr>
            <tr class="noborder">
                <td class="required" nowrap>是否显示</td>
                <td class="onoff" nowrap>
                    <label for="is_show1" class="cb-enable <?php echo (($row['is_show']==1||empty($row))?'selected':''); ?>"><span>显示</span></label>
                    <label for="is_show0" class="cb-disable <?php echo ((isset($row['is_show']) && $row['is_show']==0)?'selected':''); ?>" ><span>不显示</span></label>
                    <input id="is_show1" name="is_show" <?php echo (($row['is_show']==1||empty($row))?'checked="checked"':''); ?> value="1" type="radio"/>
                    <input id="is_show0" name="is_show" <?php echo ((isset($row['is_show']) && $row['is_show']==0)?'checked="checked"':''); ?> value="0" type="radio"/>                
                </td>
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
                required: '请输入菜单名称'
            }
        }
    });
});
</script>    
<?php endif; ?>   
</div>