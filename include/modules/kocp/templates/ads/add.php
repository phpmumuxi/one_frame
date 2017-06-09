<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>广告管理</h3>
            <ul class="tab-base">
                <li><a href="/kocp/ads/index"><span>管理广告</span></a></li>
                <li><a href="<?php echo ($t==1 ? '/kocp/ads/add' : 'javascript:;" class="current'); ?>"><span>新增广告</span></a></li>
                <li><a href="/kocp/ads/index/t/1"><span>管理广告位</span></a></li>
                <li><a href="<?php echo ($t==0 ? '/kocp/ads/add/t/1' : 'javascript:;" class="current'); ?>"><span>新增广告位</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form id="ko_sub_form" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
        <table class="table tb-type2 nobdb">
        <?php if ($t == 1) : ?>
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="name"> 广告位名称:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $row['name']; ?>" name="name" id="name" class="txt"></td>
                    <td class="vatop tips">广告位名称</td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label class="validation" for="name"> 广告位宽:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $row['width']; ?>" name="width" class="txt"></td>
                    <td class="vatop tips">广告位宽</td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label class="validation" for="name"> 广告位高:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $row['height']; ?>" name="height" class="txt"></td>
                    <td class="vatop tips">广告位高</td>
                </tr>
            </tbody>
<script type="text/javascript">
$(document).ready(function() {
    $('#ko_sub_form').validate({
        errorPlacement: function(error, element) {
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label) {
            label.addClass('valid');
        },
        rules: {
            name: {
                required: true,
                remote: {
                    url: '/kocp/ads/koajax/',
                    type: 'post',
                    data: {
                        column: 'check_cat_name',
                        value: function() {
                            return $('#name').val();
                        },
                        id: function() {
                            return $('input[name=id]').val();
                        }
                    }
                }
            },
            width: {
                required: true
            },
            height: {
                required: true
            }
        },
        messages: {
            name: {
                required: '广告位名称不能为空',
                remote: '该广告位名称已经存在了，请您换一个'
            },
            width: {
                required: '广告位宽不能为空',
            },
            height: {
                required: '广告位高不能为空'
            }
        }
    });
});
</script>            
        <?php else : ?>
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="name"> 广告标题:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $row['name']; ?>" name="name" id="name" class="txt"></td>
                    <td class="vatop tips" width="100%">广告标题</td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label class="validation" for="parent_id">所属广告位:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><?php echo Dao_Site::get_select_html('cat_id', $cat_arr, $row['cat_id']); ?></td>
                    <td class="vatop tips">选择广告所在的广告位</td>
                </tr>                
                <tr>
                    <td colspan="2" class="required"><label class="validation" for="name"> 链接地址:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $row['url']; ?>" name="url" class="txt"></td>
                    <td class="vatop tips">点击广告后打开的地址,格式如：http://www.baidu.com</td>
                </tr>
                <tr>
                    <td colspan="2"><label> 是否为幻灯片:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="onoff" nowrap>
                        <label for="is_huan1" class="cb-enable <?php echo (($row['is_huan']==1)?'selected':''); ?>"><span>是</span></label>
                        <label for="is_huan0" class="cb-disable <?php echo (($row['is_huan']==0)?'selected':''); ?>" ><span>否</span></label>
                        <input id="is_huan1" name="is_huan" <?php echo (($row['is_huan']==1)?'checked="checked"':''); ?> value="1" type="radio"/>
                        <input id="is_huan0" name="is_huan" <?php echo (($row['is_huan']==0)?'checked="checked"':''); ?> value="0" type="radio"/>
                    </td>
                    <td class="vatop tips">末默认新窗口打开</td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label class="validation" for="name"> 打开方式:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                        <input name="target" <?php echo ((!$row || $row['target']) == '_blank' ? 'checked="checked"' : ''); ?> value="_blank" type="radio"/>新窗口
                        <input name="target" <?php echo ($row['target'] == '_self' ? 'checked="checked"' : ''); ?> value="_self" type="radio"/>原窗口
                    </td>
                    <td class="vatop tips">末默认新窗口打开</td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label class="validation" for="ad_pic">图片上传:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="rowform">
                        <span class="type-file-box"><input type="file" name="ad_pic" id="ad_pic" class="type-file-file" size="30" ></span>                                            
                    </td>
                    <td class="vatop tips">
                    <?php if ($row['img'] != '') : ?>
                        <span class="type-file-show" style="float:left;">
                            <img class="show_image" src="/static/ht/images/preview.png">
                            <div class="type-file-preview"><img src="<?php echo $row['img']; ?>"></div>
                        </span>
                    <?php endif; ?>                        
                        选择要上传的广告图片</td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label for="sort">排序:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo ($row['sort']=='' ? '100' : $row['sort']); ?>" name="sort" id="sort" class="txt"></td>
                    <td class="vatop tips">数字越小越靠前，最大值999</td>
                </tr>                
            </tbody>
<script type="text/javascript">
//按钮先执行验证再提交表单
$(function() {
    var textButton = "<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    $(textButton).insertBefore("#ad_pic");
    $("#ad_pic").change(function() {
        $("#textfield1").val($("#ad_pic").val());
    });
});
$(document).ready(function() {
    $('#ko_sub_form').validate({
        errorPlacement: function(error, element) {
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label) {
            label.addClass('valid');
        },
        rules: {
            name: {
                required: true,
                remote: {
                    url: '/kocp/ads/koajax/',
                    type: 'post',
                    data: {
                        column: 'check_name',
                        value: function() {
                            return $('#name').val();
                        },
                        id: function() {
                            return $('input[name=id]').val();
                        }
                    }
                }
            },
            cat_id: {
                min: 1
            },
//            url: {
//                required: true,
//                url: true
//            }
        },
        messages: {
            name: {
                required: '广告标题不能为空',
                remote: '该广告标题已经存在了，请您换一个'
            },
            cat_id: {
                min: '请选择广告所属广告位',
            },
//            url: {
//                required: '请填写广告的链接地址',
//                url: '链接格式不正确'
//            }
        }
    });
});
</script>
        <?php endif; ?>            
            <tfoot>
                <tr class="tfoot">
                    <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span>提交</span></a></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
//按钮先执行验证再提交表单
$(function() {
    $("#submitBtn").click(function() {
        if ($("#ko_sub_form").valid()) {
            $("#ko_sub_form").submit();
        }
    });
});
</script>