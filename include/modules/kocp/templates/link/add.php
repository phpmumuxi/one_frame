<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>友情链接</h3>
            <ul class="tab-base">
                <li><a href="/kocp/link/index" ><span>管理</span></a></li>
                <li><a href="JavaScript:void(0);" class="current"><span>新增</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form id="ko_sub_form" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
        <table class="table tb-type2 nobdb">
            <tbody>
                <tr class="noborder">
                    <td colspan="2" class="required"><label class="validation" for="name"> 标题:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo $row['title']; ?>" name="name" id="name" class="txt"></td>
                    <td class="vatop tips">友情链接的名称</td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label class="validation" for="url"> 链接:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo ($row['url']=='' ? 'http://' : $row['url']); ?>" name="url" id="url" class="txt"></td>
                    <td class="vatop tips">友情链接的链接地址,格式如：http://www.baidu.com</td>
                </tr>
                <tr>
                    <td colspan="2" class="required"><label for="link_pic">图片标识:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform">
                    <?php if ($row['pic'] != '') : ?>
                        <span class="type-file-show">
                            <img class="show_image" src="/static/ht/images/preview.png">
                            <div class="type-file-preview"><img src="<?php echo $row['pic']; ?>"></div>
                        </span>
                    <?php endif; ?>
                        <span class="type-file-box"><input type="file" name="link_pic" id="link_pic" class="type-file-file" size="30" ></span>
                    </td>
                    <td class="vatop tips">友情链接的标志图片，100px * 35px</td>
                </tr>
                <tr>
                    <td colspan="2" class="required">是否显示:</td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform onoff" colspan="2"><label for="show1" class="cb-enable <?php echo ($row['isshow'] == 1 ? 'selected' : ''); ?>" ><span>显示</span></label>
                        <label for="show0" class="cb-disable <?php echo ($row['isshow'] == 0 ? 'selected' : ''); ?>"><span>不显示</span></label>
                        <input id="show1" name="isshow" <?php echo ($row['isshow'] == 1 ? 'checked="checked"' : ''); ?> value="1" type="radio"/>
                        <input id="show0" name="isshow" <?php echo ($row['isshow'] == 0 ? 'checked="checked"' : ''); ?> value="0" type="radio"/>
                    </td>
                </tr>                
                <tr>
                    <td colspan="2" class="required"><label for="sort">排序:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="<?php echo ($row['sort']=='' ? '255' : $row['sort']); ?>" name="sort" id="sort" class="txt"></td>
                    <td class="vatop tips">数字越小越靠前</td>
                </tr>
            </tbody>
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
    var textButton = "<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    $(textButton).insertBefore("#link_pic");
    $("#link_pic").change(function() {
        $("#textfield1").val($("#link_pic").val());
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
                    url: '/kocp/link/koajax/',
                    type: 'post',
                    data: {
                        column: 'check_title',
                        value: function() {
                            return $('#name').val();
                        },
                        id: function() {
                            return $('input[name=id]').val();
                        }
                    }
                }
            },
            url: {
                required: true,
                url: true
            },
            sort: {
                number: true
            }
        },
        messages: {
            name: {
                required: '友情链接标题不能为空',
                remote: '该友情链接标题已经存在了，请您换一个'
            },
            url: {
                required: '请填写友情链接的链接地址',
                url: '链接格式不正确'
            },
            sort: {
                number: '排序仅能为数字'
            }
        }
    });
});
</script>