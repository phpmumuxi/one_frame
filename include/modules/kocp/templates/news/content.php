<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>新闻管理</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>管理</span></a></li>
        <li><a href="/kocp/news/contentAdd"><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="formSearch">
    <table class="tb-type1 noborder search">
        <tbody>
            <tr>
                <td nowrap>
                    标题<input type="text" value="" name="title" class="w100"/>
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
          <th>新闻标题</th>                 
          
          <th>上级分类</th>
         
          <th>发布时间</th>
          <th class="w60 align-center">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($data_arr as $vo): ?>
        <tr class="hover">
          <td><?php echo $vo['id']; ?></td>
          <td><?php echo $vo['title']; ?></td>                  
          
          <?php if(!empty($cat_arr)){ foreach ($cat_arr as $vv){ if($vv['id']==$vo['parent_id']){ ?>
          <td><?php echo $vv['name']; ?></td>
          <?php } } }?>
         
          <td><?php echo date('Y-m-d H:i:s',$vo['time']); ?></td>
          <td class="align-center" nowrap>
            <a href="/kocp/news/contentEdit/id/<?php echo $vo['id']; ?>">编辑</a>
            | <a href="/kocp/news/contentDel/id/<?php echo $vo['id']; ?>" onclick="if(confirm('您确定要删除吗？')) return true; return false;">删除</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="20"><?php echo $page_str; ?></td>
        </tr>
      </tfoot>
    </table>  
</div>