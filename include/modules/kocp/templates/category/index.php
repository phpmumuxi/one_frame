<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>产品分类</h3>
            <ul class="tab-base">
                <li><a href="<?php echo ($kot==0) ? 'javascript:;" class="current' : '/kocp/category/index'; ?>"><span>管理</span></a></li>                
                <li><a href="<?php echo ($kot==1) ? 'javascript:;" class="current' : '/kocp/category/index/kot/1'; ?>"><span>新增</span></a></li>               
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form method='post' id="ko_sub_form">
<?php if ($kot == 0) : ?>
       <table class="table tb-type2">
            <thead>
                <tr class="thead">                    
                    <th class="w48" width="15%">ID</th>                    
                    <th  width="30%">分类名称</th> 
                    <th  width="20%">类型</th>                        
                    <th class="w96 align-center">操作</th>
                </tr>
            </thead>
            <tbody id="treet1">
               <?php if (!empty($data_arr)) : foreach ($data_arr as $v) : ?>
                    <tr class="hover edit">
                        <td class="sort"><?php echo $v['id']; ?></td>                        
                        <td class="name" nowrap><?php echo $v['nbsp'].$v['name']; ?></td> 
                        <td class="sort">
                        <?php if($v['type']==1 ){echo '实验平台'; ?>
                        <?php }elseif($v['type']==2 ){echo '文章列表'; ?>                       
                        <?php }else{ echo '其他'; } ?>
                        </td>                                                
                        <td class="align-center">
                            <a href="/kocp/category/index/kot/1/id/<?php echo $v['id']; ?>">编辑</a>
                            | <a href="javascript:if(confirm('删除该分类将会同时删除该分类的所有下级分类，您确定要删除吗？'))window.location='/kocp/category/index/kot/2/id/<?php echo $v['id']; ?>';">删除</a>
                        </td>
                    </tr>  
               <?php endforeach; endif; ?>  
            </tbody>
        </table>
<?php elseif ($kot == 1) : ?>
        <table class="table tb-type2">
            <tr>
                <td class="required" nowrap><label class="validation" for="name">分类名称:</label></td>
                <td class="vatop rowform" width="100%"><input type="text" value="<?php echo $row['name']; ?>" name="name" class="txt" /></td>
            </tr> 
            <tr>
                <td class="required" nowrap><label class="validation" for="type"> 分类类型:</label></td>
                <td class="vatop rowform" width="100%"><label >1，实验平台2，文章列表3，其他</label><input type="text" value="<?php echo $row['type']; ?>" name="type" class="txt" /></td>
            </tr>            
            <tr>
                <td class="required"><label for="parent_id">上级分类:</label></td>
                <td><?php echo Dao_Site::get_select_html('parent_id', $data_arr, $row['parent_id'], 1); ?></td>                
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