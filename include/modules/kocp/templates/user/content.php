<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>常见问题</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>管理</span></a></li>
        <li><a href="/kocp/user/contentAdd"><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="formSearch">
    <table class="tb-type1 noborder search">
        <tbody>
            <tr>
                <td nowrap>
                    问题<input type="text" value="" name="question" class="w100"/>
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
          <th>常见问题</th>                  
          <th>回答</th>
          <th>类型</th>
          <th>审核状态</th>          
          <th>时间</th>
          <th class="w60 align-center">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($data_arr as $vo): ?>
        <tr class="hover">
          <td><?php echo $vo['id']; ?></td>
          <td><?=mb_substr(strip_tags($vo['question']),0,30,'utf-8').(strlen(strip_tags($vo['question']))>30?'...':'') ?></td>                  
          <td><?=mb_substr(strip_tags($vo['answer']),0,30,'utf-8').(strlen(strip_tags($vo['answer']))>30?'...':'') ?></td>
          <td>            
              <?php if($vo['type_id']==9 ){echo '细胞实验'; ?>
              <?php }elseif($vo['type_id']==10 ){echo '蛋白质实验'; ?>                       
              <?php }elseif($vo['type_id']==11 ){echo '分子生物实验'; ?> 
              <?php }elseif($vo['type_id']==12 ){echo '动物实验'; ?>                      
              <?php }else{ echo '用户提交'; } ?>
          </td>
          <?php if($vo['status']==1){  ?>
          <td><font color='blue'>通过</font></td>
          <?php  }else{ ?>
          <td><font color='red'>禁止</font></td>
           <?php  } ?>
          <td><?php echo date('Y-m-d H:i:s',$vo['time']); ?></td>
          <td class="align-center" nowrap>
            <a href="/kocp/user/contentEdit/id/<?php echo $vo['id']; ?>">编辑</a>
            | <a href="/kocp/user/contentDel/id/<?php echo $vo['id']; ?>" onclick="if(confirm('您确定要删除吗？')) return true; return false;">删除</a>
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