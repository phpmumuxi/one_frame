<?php
 header('Content-Type: text/html; charset=utf-8');
?>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>产品管理</h3>
            <ul class="tab-base">
                <li><a href="<?php echo ($kot==0) ? 'javascript:;" class="current' : '/kocp/product/index'; ?>"><span>管理</span></a></li>                
                <li><a href="<?php echo ($kot==1) ? 'javascript:;" class="current' : '/kocp/product/index/kot/1'; ?>"><span>新增</span></a></li>               
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form method='post' id="ko_sub_form" enctype="multipart/form-data">
<?php if ($kot == 0) : ?>
       <table class="table tb-type2">
            <thead>
                <tr class="thead">                    
                    <th width="8%" class="w48">ID</th>
                    <th width="15%">名称</th>                                   
                    <th >描述</th>                        
                    <th width="15%">图片</th>                                 
                    <th width="22%" class="w96 align-center">操作</th>
                </tr>
            </thead>
            <tbody id="treet1">
               <?php if (!empty($data_arr)) : foreach ($data_arr as $v) : ?>
                    <tr class="hover edit">
                        <td><?php echo $v['id']; ?></td>                      
                        <td><?php echo $v['name']; ?></td>                                                                                                     
                        <td><?php echo strlen(strip_tags($v['lab_about']))>60?mb_substr(strip_tags($v['lab_about']),0,60,'utf-8').'...':$v['lab_about']; ?></td>                                         
                        <td><img src='<?php echo $v['img']; ?>' width='100px' /></td>                                                
                        <td class="align-center">
                            <a href="/kocp/product/index/kot/1/id/<?php echo $v['id']; ?>">编辑</a>
                            | <a href="javascript:if(confirm('您确定要删除吗？'))window.location='/kocp/product/index/kot/2/id/<?php echo $v['id']; ?>';">删除</a>
                        </td>
                    </tr>  
               <?php endforeach; endif; ?>  
            </tbody>
        </table>
<?php elseif ($kot == 1) : ?>
        <table class="table tb-type2">
            <tr>
                <td class="required" width='18%'><label  for="name">名称:</label></td>
                <td class="vatop rowform" width="100%"><input type="text" value="<?php echo $row['name']; ?>" name="name" class="txt" /></td>
            </tr>
            
            <tr>
                <td class="required"><label > 推荐:</label></td>
                <td><input type="text" value="<?php echo $row['is_tui']; ?>" name="is_tui" class="txt" />默认不推荐 （1推荐）</td>                
            </tr>
            <tr>
                <td class="required"><label > 分类:</label></td>
                <td><?php echo Dao_Site::get_select_html('parent_id', $category_arr, $row['parent_id'], 1); ?></td>                
            </tr>
            <tr>
                <td class="required">产品图片:</td>
                <td class="vatop rowform"><input type="file" multiple="multiple" name="fileimg" ></td>
             </tr>
             <?php if(!empty($row['img'])){ ?>
             <tr>
                <td class="required">预览图片:</td>
                <td class="vatop rowform"><img src="<?php echo $row['img']; ?>" width='100px'></td>
             </tr>
             <?php }?> 
             <tr class="noborder">
                <td class="required" nowrap>实验介绍：</td>
                <td class="vatop rowform"><textarea name='lab_about' rows="20" cols="20"><?php echo $row['lab_about']; ?> </textarea></td>
            </tr>
            <tr class="noborder">
                <td class="required" nowrap>实验员资深：</td>
                <td class="vatop rowform"><textarea name='lab_member' rows="20" cols="20"><?php echo $row['lab_member']; ?></textarea></td>
            </tr>
            <tr class="noborder">
                <td class="required" nowrap>实验名称：</td>
                <td class="vatop rowform"><textarea name='lab_name' rows="20" cols="20"><?php echo $row['lab_name']; ?></textarea></td>
            </tr>
            <tr class="noborder">
                <td class="required" nowrap>实验内容：</td>
                <td class="vatop rowform"><?php Public_Tool::showKEditor('content',$row['content']); ?></td>
            </tr>
             <tr class="noborder">
                <td class="required" nowrap>成功案例：</td>
                <td class="vatop rowform"><?php Public_Tool::showKEditor('lab_demo',$row['lab_demo']); ?></td>
            </tr>
                       
            <tr class="tfoot">
                <td colspan="2" ><a href="javascript:void(0);" class="btn" id="KOsubmitBtn"><span>提交</span></a></td>
            </tr>
        </table>
<script type="text/javascript">
    $(function() {
        $("#KOsubmitBtn").click(function() {
            if ($("#ko_sub_form").valid()) {
                $("#ko_sub_form").submit();
            }
        });
    });        
</script>
<?php endif; ?>
    </form>
</div>