<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>友情链接</h3>
            <ul class="tab-base">
                <li><a href="JavaScript:void(0);" class="current"><span>管理</span></a></li>
                <li><a href="/kocp/link/add" ><span>新增</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form method="post" name="formSearch">
        <table class="tb-type1 noborder search">
            <tbody>
                <tr>
                    <th>标题</th>
                    <td><input type="text" value="<?php echo $name; ?>" name="name" class="txt"></td>
                    <th><label for="search_ac_id">显示</label></th>
                    <td>
                        <select name="isshow">
                            <option value="0">请选择...</option>
                            <option<?php if ($isshow == 1) { echo ' selected="selected";'; } ?> value="1">是</option>
                            <option<?php if ($isshow == 2) { echo ' selected="selected";'; } ?> value="2">否</option>                            
                        </select>
                    </td>
                    <td>
                        <a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="查询">&nbsp;</a>
                        <a href="/kocp/link/index" class="btns tooltip" title="全部"><span>全部</span></a> 
                        <a href="/kocp/link/index/t/1" class="btns tooltip" title="图片链接"><span>图片链接</span></a>
                        <a href="/kocp/link/index/t/2" class="btns tooltip" title="文字链接"><span>文字链接</span></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <table class="table tb-type2" id="prompt">
        <tbody>
            <tr class="space odd">
                <th colspan="12"><div class="title"><h5>操作提示</h5><span class="arrow"></span></div></th>
        </tr>
        <tr>
            <td>
                <ul>
                    <li>通过友情链接管理你可以，编辑、查看、删除友情链接信息</li>
                    <li>在搜索处点击图片则表示将搜索图片标识仅为图片的相关信息，点击文字则表示将搜索图片标识仅为文字的相关信息，点击全部则搜索所有相关信息</li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
    <form method='post' id="form_link">
        <input type="hidden" name="form_submit" value="ok" />
        <table class="table tb-type2 nobdb">
            <thead>
                <tr class="thead">
                    <th>&nbsp;</th>
                    <th>排序</th>
                    <th>标题</th>
                    <th>图片标识</th>
                    <th>链接</th>
                    <th class="align-center">是否显示</th>
                    <th class="align-center">操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($data_arr) : foreach ($data_arr as $v) : ?>
                <tr class="hover edit">
                    <td class="w24"><input type="checkbox" name="ids[]" value="<?php echo $v['id']; ?>" class="checkitem"></td>
                    <td class="w84 sort"><span title="可编辑" datatype="pint" koajax="/kocp/link/koajax/" fieldid="<?php echo $v['id']; ?>" fieldname="sort" nc_type="inline_edit" class="editable tooltip"><?php echo $v['sort']; ?></span></td>
                    <td class="name"><span title="可编辑" required="1" koajax="/kocp/link/koajax/" fieldid="<?php echo $v['id']; ?>" fieldname="title" nc_type="inline_edit" class="editable tooltip"><?php echo $v['title']; ?></span></td>
                    <td class="picture">
                    <?php if ($v['pic']!='') : ?>
                        <div class='size-88x31'><span class='thumb size-88x31'><i></i><img width="88" height="31" src='<?php echo $v['pic']; ?>'/></span></div>
                    <?php else : ?>
                        <?php echo $v['title']; ?>
                    <?php endif; ?>
                    </td>
                    <td><?php echo $v['url']; ?></td>
                    <td class="align-center power-onoff"><a title="可编辑" nc_type="inline_edit" fieldname="isshow" koajax="/kocp/link/koajax/" fieldid="<?php echo $v['id']; ?>" fieldvalue="<?php echo $v['isshow']; ?>" class="tooltip <?php echo ($v['isshow'] == 1 ? 'enabled' : 'disabled'); ?>" href="javascript:void(0);"><img src="/static/ht/images/transparent.gif"></a></td>
                    <td class="w96 align-center"><a href="/kocp/link/add/id/<?php echo $v['id']; ?>">编辑</a> | <a href="javascript:if(confirm('您确定要删除吗?'))window.location='/kocp/link/add/t/1/id/<?php echo $v['id']; ?>';">删除</a></td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
            <tfoot>
                <td class="w24"><input type="checkbox" class="checkall" id="checkallBottom"></td>
                    <td colspan="16">
                    <label for="checkallBottom">全选</label>
                    &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('确定删除')){$('#form_link').submit();}"><span>删除</span></a>
                    <div class="pagination"><?php include(KO_TEMPLATES_PATH . '/cp_page.php'); ?></div></td>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript" src="/static/js/jquery.edit.js" charset="utf-8"></script>