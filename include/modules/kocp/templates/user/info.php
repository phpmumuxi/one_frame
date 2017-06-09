<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>用户资料</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>管理</span></a></li>
        <li><a href=""><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="formSearch">
    <table class="tb-type1 noborder search">
        <tbody>
            <tr>
                <td nowrap>
                    用户名<input type="text" value="" name="name" class="w100"/>
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
          <th> 实验名称</th>                  
          <th> 姓名</th>                  
          <th>邮箱</th>
          <th>手机号</th>
          <th>qq号</th>
          <th>备注</th>
          <th>创建时间</th>
          <!--<th class="w60 align-center">操作</th>-->
        </tr>
      </thead>
      <tbody>
        <?php foreach($data_arr as $vo): ?>
        <tr class="hover">
          <td><?php echo $vo['id']; ?></td>
          <td><?php echo $vo['lab_name']; ?></td>          
          <td><?php echo $vo['name']; ?></td>                  
          <td><?php echo $vo['email']; ?></td>         
          <td><?php echo $vo['tel']; ?></td>
          <td><?php echo $vo['qq']; ?></td>          
          <td><?php echo $vo['des']; ?></td>          
          <td><?php echo date('Y-m-d H:i:s',$vo['time']); ?></td>
          <!-- <td class="align-center" nowrap>
            <a href="">编辑</a>
            | <a href="" onclick="if(confirm('删除该消息类型将会同时删除该消息的所有图文信息，您确定要删除吗？')) return true; return false;">删除</a>
          </td> -->
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