<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>广告管理</h3>
            <ul class="tab-base">
                <li><a href="<?php echo ($t==1 ? '/kocp/ads/index' : 'javascript:;" class="current'); ?>"><span>管理广告</span></a></li>
                <li><a href="/kocp/ads/add"><span>新增广告</span></a></li>
                <li><a href="<?php echo ($t==0 ? '/kocp/ads/index/t/1' : 'javascript:;" class="current'); ?>"><span>管理广告位</span></a></li>
                <li><a href="/kocp/ads/add/t/1"><span>新增广告位</span></a></li>
            </ul>
        </div>
    </div>
    <div class="fixed-empty"></div>
    <form method="post" name="formSearch">
        <table class="tb-type1 noborder search">
            <tbody>
                <tr>
                    <th>广告<?php echo ($t==1 ? '位名称' : '标题'); ?></th>
                    <td><input type="text" value="<?php echo $name; ?>" name="name" class="txt"></td>
                    <td>
                        <a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="查询">&nbsp;</a>
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
                        <li>添加广告时，需要指定所属广告位</li>
                        <li>将广告位调用代码放入前台页面，将显示该广告位的广告</li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    <form method='post' id="ko_sub_form">
        <table class="table tb-type2 nobdb">
    <?php if ($t == 1) : ?>
            <thead>
                <tr class="thead">
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>名称</th>
                    <th>宽</th>
                    <th>高</th>
                    <th class="align-center">操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($data_arr) : foreach ($data_arr as $v) : ?>
                <tr class="hover edit">
                    <td class="w24"><input type="checkbox" name="ids[]" value="<?php echo $v['id']; ?>" class="checkitem"></td>
                    <td><?php echo $v['id']; ?></td>
                    <td class="name"><span title="可编辑" required="1" koajax="/kocp/ads/koajax/" fieldid="<?php echo $v['id']; ?>" fieldname="cat_name" nc_type="inline_edit" class="editable tooltip"><?php echo $v['name']; ?></span></td>
                    <td class="sort"><span title="可编辑" datatype="pint" koajax="/kocp/ads/koajax/" fieldid="<?php echo $v['id']; ?>" fieldname="cat_width" nc_type="inline_edit" class="editable tooltip"><?php echo $v['width']; ?></span></td>
                    <td class="sort"><span title="可编辑" datatype="pint" koajax="/kocp/ads/koajax/" fieldid="<?php echo $v['id']; ?>" fieldname="cat_height" nc_type="inline_edit" class="editable tooltip"><?php echo $v['height']; ?></span></td>
                    <td class="w96 align-center"><a href="/kocp/ads/add/t/1/id/<?php echo $v['id']; ?>">编辑</a> | <a href="javascript:if(confirm('您确定要删除吗?'))window.location='/kocp/ads/index/t/1/ids/<?php echo $v['id']; ?>';">删除</a></td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
    <?php else : ?>
            <thead>
                <tr class="thead">
                    <th>&nbsp;</th>
                    <th>ID</th>
                    <th>标题</th>
                    <th>所属广告位</th>
                    <th>链接地址</th>
                    <th>打开方式</th>
                    <th>是幻灯片</th>
                    <th>图片</th>
                    <th>排序</th>
                    <th class="align-center">操作</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($data_arr) : foreach ($data_arr as $v) : ?>
                <tr class="hover edit">
                    <td class="w24"><input type="checkbox" name="ids[]" value="<?php echo $v['id']; ?>" class="checkitem"></td>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['name']; ?></td>
                    <td><?php echo $v['cname']; ?></td>
                    <td><?php echo $v['url']; ?></td>
                    <td><?php echo ($v['target']=='_self' ? '原窗口' : '新窗口'); ?></td>
                    <td><?php echo ($v['is_huan']==1 ? '是' : '否'); ?></td>
                    <td><a href="<?php echo $v['img']; ?>" target="_blank">查看</a></td>
                    <td><?php echo $v['sort']; ?></td>
                    <td class="w96 align-center"><a href="/kocp/ads/add/id/<?php echo $v['id']; ?>">编辑</a> | <a href="javascript:if(confirm('您确定要删除吗?'))window.location='/kocp/ads/index/ids/<?php echo $v['id']; ?>';">删除</a></td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
    <?php endif; ?>
            <tfoot>
                <!-- <tr class="tfoot">
                    <td><input type="checkbox" id="checkallBottom"></td>
                    <td colspan="16" id="batchAction"><label for="ko_checkall_Bottom">全选</label>
                        &nbsp;&nbsp; <a href="javascript:;" class="btn" onclick="if (confirm('您确定要删除吗?')) { $('#ko_sub_form').submit(); }"><span>删除</span></a>
                        <?php include(KO_TEMPLATES_PATH . '/cp_page.php'); ?>
                    </td>
                </tr> -->
                <tr>
                    <td class="w24"><input type="checkbox" class="checkall" id="checkallBottom"></td>
                    <td colspan="16">
                    <label for="checkallBottom">全选</label>
                    &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('确定删除')){$('#ko_sub_form').submit();}"><span>删除</span></a>
                    <div class="pagination"><?php include(KO_TEMPLATES_PATH . '/cp_page.php'); ?></div></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript" src="/static/js/jquery.edit.js" charset="utf-8"></script>