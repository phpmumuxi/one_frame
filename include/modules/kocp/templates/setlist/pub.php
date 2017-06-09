<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>网站设置列表</h3>
            <ul class="tab-base">
            <?php foreach ($lx_arr as $lxv) : ?>
                <li><a href="<?php echo ($kot==$lxv['id']) ? 'javascript:;" class="current' : '/kocp/setlist/pub/kot/'.$lxv['id']; ?>"><span><?php echo $lxv['name']; ?></span></a></li>
            <?php endforeach; ?>
                <li><a href="<?php echo ($kot==0) ? 'javascript:;" class="current' : '/kocp/setlist/pub/vtype/'.$kot; ?>"><span>新增变量</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form method="post" enctype="multipart/form-data" id="ko_sub_form">
        <table class="table tb-type2">       
<?php if ($kot == 0) : ?>
            <tr class="noborder">
                <td class="required" nowrap><label class="validation">变量代码:</label></td>
                <td class="vatop rowform" width="100%"><input type="text" style="width:500px;" value="" name="code" class="txt"/></td>
            </tr>            
            <tr>
                <td class="required" nowrap><label>变量类型:</label></td>
                <td class="vatop rowform">
                    <input type="radio" checked="checked" value="1" name="vlx">文本&nbsp;
                    <input type="radio" value="2" name="vlx">多行文本&nbsp;
                    <input type="radio" value="3" name="vlx">布尔(Y/N)&nbsp;
                    <input type="radio" value="4" name="vlx">上传图片&nbsp;
                </td>
            </tr>
            <tr>
                <td class="required" nowrap><label>所属组:</label></td>
                <td class="vatop rowform"><?php echo Dao_Site::get_select_html('vtype', $lx_arr, $vtype, 0, 0); ?></td>
            </tr>
            <tr>
                <td class="required"><label>排序:</label></td>
                <td class="vatop rowform"><input type="text" style="width:380px;" value="0" name="sort" class="txt"/>(0-255,越小越靠前)</td>
            </tr>
            <tr>
                <td class="required"><label>参数说明:</label></td>
                <td class="vatop rowform"><input type="text" style="width:500px;" value="" name="name" class="txt"/></td>
            </tr>
            <tr>
                <td class="required"><label>变量值:</label></td>
                <td class="vatop rowform"><textarea name="value" style="width:500px;height:70px;"></textarea></td>
            </tr>
            <tr class="tfoot">
                <td colspan="10" ><a href="javascript:void(0);" class="btn" id="KOsubmitBtn"><span>提交</span></a></td>
            </tr>            
<?php else : if (!empty($data_arr)) : ?>
            <tr class="noborder">
                <td class="required" nowrap width="300">变量代码</td>
                <td nowrap>排序(0-255,越小越靠前)</td>
                <td nowrap>参数说明</td>
                <td nowrap width="100%">变量值</td>
            </tr>
    <?php foreach ($data_arr as $v) : ?>
            <tr>
                <td class="required" nowrap><?php echo $v['code']; ?></td>                
                <td class="rowform" nowrap><input type="text"  name="<?php echo $v['code']; ?>_sort" style="width:150px;" value="<?php echo $v['sort']; ?>" class="txt"/></td>
                <td class="rowform" nowrap><input type="text"  name="<?php echo $v['code']; ?>_name" style="width:260px;" value="<?php echo $v['name']; ?>" class="txt"/></td>
                <td class="rowform" nowrap>
                    <input type="hidden" name="code[]" value="<?php echo $v['code']; ?>"/>
                    <input type="hidden" name="<?php echo $v['code']; ?>_lx" value="<?php echo $v['lx']; ?>"/>
                <?php if ($v['lx'] == 1) : ?>
                    <input type="text" name="<?php echo $v['code']; ?>_value" style="width:500px;" value="<?php echo $v['value']; ?>" class="txt"/>
                <?php elseif ($v['lx'] == 2) : ?>
                    <textarea name="<?php echo $v['code']; ?>_value" style="width:500px;height:70px;"><?php echo $v['value']; ?></textarea>
                <?php elseif ($v['lx'] == 3) : ?>
                    <input name="<?php echo $v['code']; ?>_value" <?php echo (($v['value']==1)?'checked="checked"':''); ?> value="1" type="radio"/>是
                    &nbsp;&nbsp;&nbsp;<input name="<?php echo $v['code']; ?>_value" <?php echo ($v['value']==0?'checked="checked"':''); ?> value="0" type="radio"/>否
                <?php elseif ($v['lx'] == 4) : ?>
                    <span class="type-file-box">
                        <input type='text' name='textfield' class='type-file-text'/>
                        <input type='button' name='button' value='' class='type-file-button'/>
                        <input name="<?php echo $v['code']; ?>_value" type="file" class="type-file-file" size="30" hidefocus="true"/>
                    </span>
                    <span class="type-file-show" style="float:left;margin-left: 10px;">
                        <img class="show_image" src="/static/ht/images/preview.png">
                        <div class="type-file-preview"><img src="<?php echo $v['value']; ?>"></div>
                    </span>
                <?php endif; ?>
                </td>
            </tr>
<?php endforeach; ?>
            <tr class="tfoot">
                <td colspan="10" ><a href="javascript:void(0);" class="btn" id="KOsubmitBtn"><span>提交</span></a></td>
            </tr>      
<?php else : ?>
            暂无记录
<?php endif; endif; ?>            
        </table>            
    </form>
</div>
<script type="text/javascript">
$(function(){
    // 上传图片类型
    $('input[class="type-file-file"]').change(function(){
        var filepatd = $(this).val();
        var extStart = filepatd.lastIndexOf('.');
        var ext = filepatd.substring(extStart,filepatd.lengtd).toUpperCase();		
		if (ext!='.PNG'&&ext!='.GIF'&&ext!='.JPG'&&ext!='.JPEG') {
			alert('图片限于png,gif,jpeg,jpg格式');
            $(this).attr('value', '');
			return false;
		}
        $(this).prev().prev().val( $(this).val() );
	});
    $("#KOsubmitBtn").click(function() {
        if ($("#ko_sub_form").valid()) {
            $("#ko_sub_form").submit();
        }
    });
}); 
</script>