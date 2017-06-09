<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>新闻管理</h3>
      <ul class="tab-base">
        <li><a href="/kocp/news/content"><span>管理</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="successForm" action="/kocp/news/content_add" enctype="multipart/form-data" id="successForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">新闻标题:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="news_title" id="news_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>  
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">新闻图片:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="file" value="" name="img" class="txt"></td>
          <td class="vatop tips"></td>
        </tr> 
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">上级分类:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo Dao_Site::get_select_html('parent_id', $data_arr, 0, 1); ?></td> 
          <td class="vatop tips"></td>
        </tr>
        
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"> 热门推荐:</label></td>
        </tr>        
        <tr class="noborder">
            <td class="vatop rowform"><input type="text" value="" name="is_tui" id="news_auth" >&nbsp;&nbsp;<font color="red">推荐新闻，0不推荐，1推荐（默认不推荐）</font></td>
          <td class="vatop tips"></td>
        </tr>      

        <tr>
          <td colspan="2" class="required"><label class="validation">新闻内容:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform">
              <?php Public_Tool::showKEditor('content'); ?>

          </td>
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
<!--<script type="text/javascript" src="<?php echo KO_DOMAIN_URL; ?>/static/js/upload.js"></script>-->
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
