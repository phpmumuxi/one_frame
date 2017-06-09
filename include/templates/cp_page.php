<div class="pagination">

<?php if ($page_arr['itemCount'] > 0) : ?>

    <ul>

<!--        <li><span>[<?php echo '每页'.$page_arr['pageSize'].'条，共'.$page_arr['itemCount'].'条，'.$page_arr['current'].'/'.$page_arr['pageCount'].'页'; ?>]</span></li>-->

    <?php if ($page_arr['current'] == 1) : ?>

        <li><span>首页</span></li><li><span>上一页</span></li>

    <?php else : ?>

        <li><a class="demo" href="<?php echo $page_arr['first']; ?>"><span>首页</span></a></li>

        <li><a class="demo" href="<?php echo $page_arr['previous']; ?>"><span>上一页</span></a></li>

    <?php endif; ?>

    <?php foreach ($page_arr['page'] as $v) : ?>

        <?php if ($page_arr['current'] == $v) : ?>

            <li><span class="currentpage"><?php echo $v; ?></span></li>

        <?php else : ?>

          <?php if ($v == '...') : ?>

            <li><span>...</span></li>

          <?php else : ?>

            <li><a class="demo" href="<?php echo $page_arr['url'].$v; ?>"><span><?php echo $v; ?></span></a></li>

          <?php endif; ?>

        <?php endif; ?>

    <?php endforeach; ?>

    <?php if ($page_arr['current'] == $page_arr['pageCount']) : ?>

        <li><span>下一页</span></li><li><span>末页</span></li>

    <?php else : ?>

        <li><a class="demo" href="<?php echo $page_arr['next']; ?>"><span>下一页</span></a></li>

        <li><a class="demo" href="<?php echo $page_arr['last']; ?>"><span>末页</span></a></li>

    <?php endif; ?>

    </ul>

<?php else : ?>

    暂无相关记录

<?php endif; ?>


</div>