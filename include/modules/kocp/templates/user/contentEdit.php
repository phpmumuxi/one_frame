<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>常见问题</h3>
      <ul class="tab-base">
        <li><a href="/kocp/user/content"><span>管理</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="successForm" action="/kocp/user/content_edit" enctype="multipart/form-data" id="successForm">
    <input type="hidden" name="id" value="<?=$data['id']?>" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">常见问题:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" colspan="2"> <?php Public_Tool::showKEditor('question',$data['question']); ?> 
         </td>
        </tr>              
               
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">回答:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" colspan="2">
              <?php Public_Tool::showKEditor('answer',$data['answer']); ?>              
          </td>
        </tr>  
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">  类型:</label></td>
        </tr>        
        <tr class="noborder">
            <td class="vatop rowform" colspan="2"><?php echo Dao_Site::get_select_html('type_id', $type_arr, $data['type_id'], 1); ?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"> 审核:</label></td>
        </tr>        
        <tr class="noborder">
            <td class="vatop rowform" colspan="2"><input type="text" value="<?=$data['status']?>" name="status" id="news_auth" >&nbsp;&nbsp;<font color="red">0禁止，1通过</font></td>
        </tr> 
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span>添加</span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
  //按钮先执行验证再提交表单
  $(function(){
    $("#submitBtn").click(function(){
      if($("#successForm").valid()){
       $("#successForm").submit();
      }
    });
  });
</script>
