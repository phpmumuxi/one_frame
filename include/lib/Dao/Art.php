<?php
/**
 * 单页面 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_Art
{
    /**
     * 获取所有栏目分类
     * @param $t    0获取缓存分类，1重新查询
     * @param $lx_id   1获取文章类型栏目，2获取期刊类型栏目
     */
    public static function getCatAll($t = 0, $lx_id = 0)
    {
        $cache = new Public_Cache('art');
        $cacheid = 'Dao_Art_getCatAll_' . $lx_id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            if ($lx_id == 0) {
                $db = Sys::getdb();
                $a = $db->fetchAll('select * from {{art_type}} order by parent_id asc,sort asc');
                if (!empty($a)) {
                    foreach ($a as &$v) {
                        if ($v['site_url'] != '') {
                            $v['url'] = $v['site_url'];
                        } else {
                            $v['url'] = '/list-' . $v['id'] . '.html';
                        }
                        //                        $child_ids = Dao_Site::get_child_ids($a, $v['id']);
                        //                        $b = array(
                        //                            'child_ids' => $child_ids,
                        //                        );
                        //                        $db->update('art_type', $b, array('id'=>$v['id']));
                    }
                }
            } elseif ($lx_id > 0) {
                $a = array();
                $b = self::getCatAll();
                if (!empty($b)) {
                    foreach ($b as $v) {
                        if ($v['lx_id'] == $lx_id) {
                            $a[] = $v;
                        }
                    }
                }
            }
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    /**
     * 获取单页面详细信息
     * @param type $id 文章ID
     * @param type $tt  0获取，1重新生成
     */
    public static function get_info($id = 0, $qa = 0)
    {
        $cache = new Public_Cache('site');
        $cacheid = 'Dao_Art_get_info_' . $id;
        $a = $cache->get($cacheid);
        if ($qa == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchRow('select * from {{pagehtml}} where id=' . $id);
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    //商品根据分类获取面包屑导航
    public static function get_navigate($id = 0, $b = array())
    {
        $id = min(explode(',', $id));
        $crow = self::getCatRow($id, 1);
        if (isset($crow['id']) && $crow['id'] > 0) {
            //array_unshift() 函数在数组开头插入一个或多个元素
            //array_push()    函数在数组尾部添加一个或多个元素
            @array_unshift($b, $crow);
        }
        if (isset($crow['parent_id']) && $crow['parent_id'] > 0) {
            return self::get_navigate($crow['parent_id'], $b);
        }
        return $b;
    }
    //判断文章的Url
    public static function getArtUrl($a = '')
    {
        if (!empty($a)) {
            if (isset($a['id'])) {
                if ($a['jump_url'] != '') {
                    $a['url'] = $a['jump_url'];
                } else {
                    $a['url'] = '/detail-' . $a['id'] . '.html';
                }
            } else {
                foreach ($a as &$v) {
                    $b = self::getArtUrl($v);
                    $v['url'] = $b['url'];
                }
            }
        }
        return $a;
    }
    /**
     * 文章内容处理
     * 下载远程图片和资源，删除非站内链接，提取第一个图片为缩略图，图片是否加水印
     * @return  返回数组
     */
    public static function handle_body($body = '', $litpic = '', $remote = 1, $dellink = 0, $autolitpic = 1, $add_watermark = 0)
    {
        if ($remote == 1) {
            //远程图片本地化
            $body = self::GetCurContent($body, 'artcon');
        }
        if ($dellink == 1) {
            //删除非站内链接
            $allow_urls = array($_SERVER['HTTP_HOST']);
            $cca = Dao_Site::ko_get_configs(3);
            $allow_urls = array_merge($allow_urls, explode("\n", $cca['ko_arc_allowlink']));
            //允许的超链接
            $body = self::Replace_Links($body, $allow_urls);
        }
        if ($autolitpic == 1 && $litpic == '') {
            //自动获取缩略图
            $litpic = self::GetImgFromBody($body);
        }
        return array('body' => $body, 'pic' => $litpic);
    }
    /**
     * 远程图片本地化
     * @param string $body
     * @param array $allow_urls
     * @return string
     */
    public static function GetCurContent($body = '', $dir = 'comm')
    {
        preg_match_all("/src=[\"|'|\\s]{0,}(http:\\/\\/([^>]*)\\.(gif|jpeg|jpg|png))/isU", $body, $a);
        $a = array_unique($a['1']);
        if (!empty($a)) {
            foreach ($a as $k => $v) {
                if (preg_match("#" . "#i", $v) || !preg_match("#^http:\\/\\/#i", $v)) {
                    continue;
                }
                $uma = self::ko_add_remote($v);
                if ($uma != '') {
                    $body = str_replace($v, $uma, $body);
                }
            }
        }
        return $body;
    }
    /**
     * 删除非站内链接
     * @param     string  $body  内容
     * @param     array  $allow_urls  允许的超链接(数组)
     * @return    string
     */
    public static function Replace_Links($body, $allow_urls = array())
    {
        $host_rule = join('|', $allow_urls);
        $host_rule = preg_replace("#[\n\r]#", '', $host_rule);
        $host_rule = str_replace('.', "\\.", $host_rule);
        $host_rule = str_replace('/', "\\/", $host_rule);
        preg_match_all("#<a([^>]*)>(.*)<\\/a>#iU", $body, $arr);
        if (is_array($arr['0'])) {
            $rparr = array();
            $tgarr = array();
            foreach ($arr['0'] as $i => $v) {
                if ($host_rule != '' && preg_match('#' . $host_rule . '#i', $arr[1][$i])) {
                    continue;
                } else {
                    $rparr[] = $v;
                    $tgarr[] = $arr['2'][$i];
                }
            }
            if (!empty($rparr)) {
                $body = str_replace($rparr, $tgarr, $body);
            }
        }
        return $body;
    }
    /**
     *  取第一个图片为缩略图
     *
     * @access    public
     * @param     string  $body  文档内容
     * @return    string
     */
    public static function GetImgFromBody($body)
    {
        preg_match_all("/src=[\"|'| ]([^>]+\\.(gif|jpeg|jpg|png))/isU", $body, $img);
        $img = isset($img['1']) ? $img['1'] : array();
        $litpic = '';
        if (count($img) > 0) {
            $litpic = self::ko_add_remote($img['0']);
        }
        return $litpic;
    }
    /*
     * 保存远程图片到本地
     * @param   $pic    图片绝对路径
     * @param   $maxW   图片最大宽度，0自适应，-1不使用
     * @param   $maxH   图片最大高度，0自适应
     */
    public static function ko_add_remote($pic = '', $maxW = 650, $maxH = 0)
    {
        $path = KO_UPLOAD_PATH . '/art/' . date('Ymd') . '/';
        if (!preg_match('/http\\:\\/\\//is', $pic)) {
            $pic = KO_DOMAIN_URL . $pic;
        }
        Sys::create_dir($path);
        $path .= time() . mt_rand(10000, 99999999) . '.' . Sys::get_postfix($pic);
        if (copy($pic, $path)) {
            if ($maxW >= 0) {
                Public_Img::resize($path, $maxW, $maxH);
                //调整图片大小
            }
        } else {
            $path = '';
        }
        return str_replace(KO_ROOT_PATH, '', $path);
    }
    /**
     * 根据父ID获取分类数组，或者单个分类信息
     * @param $fid  父ID
     * @param $t    类型：1单个分类信息,2获取分类数组
     */
    public static function getCatRow($fid = 0, $t = 1)
    {
        $cids = explode(',', $fid);
        if (isset($cids['0'])) {
            $fid = $cids['0'];
        }
        $cache = new Public_Cache('art');
        $cacheid = 'Dao_Art_getCatRow_' . $fid . '_' . $t;
        $b = $cache->get($cacheid);
        if (empty($b) || $t == 1) {
            $a = self::getCatAll();
            if (!empty($a)) {
                foreach ($a as $v) {
                    if ($t == 1) {
                        if ($v['id'] == $fid) {
                            $b = $v;
                            break;
                        }
                    } elseif ($t == 2) {
                        if ($v['parent_id'] == $fid) {
                            $b[] = $v;
                        }
                    }
                }
                $cache->set($cacheid, $b);
            }
        }
        return $b;
    }
    /**
     * 获取文章详情新
     * @param type $id 文章ID
     * @param type $tt  0获取，1重新生成
     */
    public static function get_art_info($id = 0, $tt = 0)
    {
        $cache = new Public_Cache('site');
        $cacheid = 'Dao_Art_get_art_info_' . $id;
        $a = $cache->get($cacheid);
        if ($tt == 1 || empty($a)) {
            $db = Sys::getdb();
            $a = $db->fetchRow('select * from {{art_con}} where isshow=1 and id=' . $id);
            if (!empty($a)) {
                $a = Dao_Art::getArtUrl($a);
                $a['cat_row'] = Dao_Art::getCatRow($a['cat_id'], 1);
                if ($a['cat_row']['lx_id'] == 2) {
                    $a['qk_info'] = $db->fetchRow('select * from {{art_qikan}} where art_id=' . $a['id']);
                    $a['qk_info']['cycle'] = $db->fetchOne('select name from {{base_info}} where id=' . intval($a['qk_info']['cycle_id']));
                    $a['qk_info']['speed'] = $db->fetchOne('select name from {{base_info}} where id=' . intval($a['qk_info']['speed_id']));
                    $income_arr = explode(',', $a['qk_info']['income_id']);
                    $a['qk_info']['income'] = '';
                    foreach ($income_arr as $v) {
                        $a['qk_info']['income'] .= $db->fetchOne('select name from {{base_info}} where id=' . intval($v)) . '&nbsp&nbsp&nbsp&nbsp';
                    }
                }
            }
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    //删除文章内容图片
    public static function DelImgBody($body)
    {
        preg_match_all("/src=[\"|'| ]([^>]+\\.(gif|jpeg|jpg|png))/isU", $body, $img);
        $img = isset($img['1']) ? $img['1'] : array();
        if (count($img) > 0) {
            foreach ($img as $v) {
                if (!preg_match('/http\\:\\/\\//is', $v)) {
                    Sys::file_unlink($v);
                }
            }
        }
    }
    /*
     * 获取同类型期刊
     * @param type $cat_id  类型ID
     * @param type $tt  0获取，1重新生成
     */
    public static function get_tlqk($art_id = 0, $cat_id, $tt = 0)
    {
        $cache = new Public_Cache('art');
        $cacheid = 'Dao_Art_get_tlqk_' . $art_id;
        $a = $cache->get($cacheid);
        if ($tt == 1 || empty($a)) {
            $db = Sys::getdb();
            $s1 = 'select a.id,a.title,a.thumb,a.jump_url from {{art_con}} a where a.isshow=1 and a.cat_id in (' . $cat_id . ') order by rand() limit 12';
            $a = Dao_Base::getArtUrl($db->fetchAll($s1));
            $cache->set($cacheid, $a, 3600 * 12);
        }
        return $a;
    }
    //获取右侧 - 推荐期刊
    public static function get_tui_data($t = 0)
    {
        $cache = new Public_Cache('art');
        $cacheid = 'Dao_Art_get_tui_data';
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $sql = 'select id,title,thumb,jump_url from {{art_con}} where ' . 'istui=1 and lx_id=2 and isshow=1 order by rand() limit 10';
            $a = Dao_Base::getArtUrl($db->fetchAll($sql));
            $cache->set($cacheid, $a, 3600);
        }
        return $a;
    }
    //获取推荐文章
    public static function get_tjwz($t = 0)
    {
        $cache = new Public_Cache('art');
        $cacheid = 'Dao_Art_get_tjwz';
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $s1 = 'select a.id,a.title,a.thumb,a.lx_id from {{art_con}} a ' . 'left join {{art_type}} c on c.id=a.cat_id where a.lx_id = 1 and a.istui = 1 and isshow=1 and a.lx_id = 1

                    order by rand() limit 10';
            $a = Dao_Base::getArtUrl($db->fetchAll($s1));
            $cache->set($cacheid, $a, 3600 * 12);
        }
        return $a;
    }
    //获取网站咨询
    public static function get_wzzx($t = 0)
    {
        $cache = new Public_Cache('art');
        $cacheid = 'Dao_Art_get_wzzx';
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $s1 = 'select a.id,a.title,a.thumb,a.lx_id from {{art_con}} a ' . 'left join {{art_type}} c on c.id=a.cat_id where a.lx_id = 1 and a.istui = 1 and a.isshow=1 and a.lx_id = 1 and a.cat_id = 167

                    order by rand() limit 8';
            $a = Dao_Base::getArtUrl($db->fetchAll($s1));
            $cache->set($cacheid, $a, 3600 * 12);
        }
        return $a;
    }
    //返回基础数据名称
    public static function get_base_name($id = 0, $t = 0)
    {
        $cache = new Public_Cache('art');
        $cacheid = 'get_base_name' . $id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = trim($db->fetchOne('select name from {{base_info}} where id = ' . $id));
            $cache->set($cacheid, $a, 3600 * 12);
        }
        return $a;
    }
    /*
     * 获取不同级别期刊
     * @param type $t  0缓存1重新生成
     * @param type $level_id  级别ID
     * @param type $limit  期刊条数
     */
    public static function getQikan($t = 0, $level_id = 0, $limit = 2)
    {
        $cache = new Public_Cache('art');
        $cacheid = 'getQikan' . $level_id;
        $a = $cache->get($cacheid);
        if ($t == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchAll('select a.id,a.title,a.thumb,b.level_id,b.income_id,b.cn,b.issn,b.fu_yz,b.zh_yz from {{art_con}} a left join {{art_qikan}} b on a.id = b.art_id where a.lx_id = 2 and b.level_id = ' . $level_id . ' order by rand() limit ' . $limit);
            foreach ($a as $k => $vv) {
                $income_arr = explode(',', $vv['income_id']);
                $level_arr = explode(',', $vv['level_id']);
                $a[$k]['income'] = '';
                $a[$k]['level'] = '';
                $a[$k]['url'] = 'detail-' . $vv['id'] . '.html';
                foreach ($income_arr as $v) {
                    $a[$k]['income'] .= $db->fetchOne('select name from {{base_info}} where id=' . intval($v)) . '&nbsp&nbsp&nbsp&nbsp';
                }
                foreach ($level_arr as $v2) {
                    $a[$k]['level'] .= $db->fetchOne('select name from {{base_info}} where id=' . intval($v2)) . '&nbsp&nbsp&nbsp&nbsp';
                }
            }
            $cache->set($cacheid, $a, 3600 * 12);
        }
        return $a;
    }
}
//end class