<?php
/**
 * 基础管理 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_Base
{
    /**
     * 获取当前用户的角色权限
     * @param $t   0获取角色权限，1重新获取
     */
    public static function get_roles_perm($t = 0)
    {
        $a = array();
        if (isset($_SESSION['ko_htuser_info']) && $_SESSION['ko_htuser_info']['id'] > 0) {
            $cache = new Public_Cache('ko_prem');
            $mid = $_SESSION['ko_htuser_info']['id'];
            $cacheid = 'Dao_Base_get_roles_perm_' . $mid;
            $a = $cache->get($cacheid);
            if ($t == 1 || empty($a)) {
                $db = Sys::getdb();
                $roles_ids = trim($db->fetchOne('select roles_ids from {{manager}} where id=' . $mid));
                if ($roles_ids != '') {
                    if ($roles_ids == 'all') {
                        $a = 'all';
                        //所有权限
                    } else {
                        $roles_arr = explode(',', $roles_ids);
                        $mm = self::get_base_data(0, 1);
                        //获取角色信息
                        foreach ($mm as $v) {
                            if (in_array($v['id'], $roles_arr)) {
                                $mm_1 = explode('_', $v['perm_ids']);
                                $mm_2 = array();
                                if (isset($mm_1[$t])) {
                                    $mm_2 = explode(',', $mm_1[$t]);
                                }
                                if (empty($a)) {
                                    $a = $mm_2;
                                } else {
                                    $a = @array_merge($a, $mm_2);
                                }
                            }
                        }
                    }
                    $cache->set($cacheid, $a, 3600 * 24);
                }
            }
        }
        return $a;
    }
    /**
     * 获取下拉框代码
     * @param  $name    控件名称[默认值]
     * @param  $a       下拉数组
     * @param  $xuanz   选中的值
     * @param  $istree  是否显示树形： 1显示，0默认不显示
     * @param  $isfirst 是否需要第一项：1要，0默认不需要
     * @param  $js      事件JS方法名称
     */
    public static function get_select_html($name, $a, $xuanz = 0, $istree = 0, $isfirst = '1-请选择.....', $js = '')
    {
        $opt_n = '请选择.....';
        $opt_v = '';
        if (preg_match('/\\[/', $name) && preg_match('/\\]/', $name)) {
            $opt_v = preg_replace('/(.+)\\[(.*?)\\]/', '$2', $name);
            $name = preg_replace('/(.+)\\[(.*?)\\]/', '$1', $name);
        }
        $s = '<select name="' . $name . '" id="' . $name . '" ' . $js . '>';
        if (preg_match('/\\-/', $isfirst)) {
            $oa = explode('-', $isfirst);
            $isfirst = $oa['0'];
            $opt_n = $oa['1'];
        }
        if ($isfirst == 1) {
            $s .= '<option value="' . $opt_v . '">' . $opt_n . '</option>';
        }
        if (@is_array($a) && !empty($a)) {
            if ($istree == 1) {
                $tree = new Public_Tree($a);
                $a = $tree->get_tree(0);
            }
            $duoa = array();
            if ($xuanz != '') {
                $duoa = explode(',', $xuanz);
            }
            foreach ($a as $v) {
                $s .= '<option value="' . $v['id'] . '"' . ($xuanz == $v['id'] || in_array($v['id'], $duoa) ? ' selected="selected"' : '') . '>' . ($istree == 1 ? $v['nbsp'] : '') . $v['name'] . '</option>';
            }
        }
        $s .= '</select>';
        return $s;
    }
    /**
     * 判断用户是否有权限(包括增删查改)
     * @param $id 菜单ID
     */
    public static function ko_is_has_perm($id = 0)
    {
        $a = self::get_roles_perm();
        if ($a == 'all' || @in_array($id, $a)) {
            return true;
        }
        return false;
    }
    /*
     * 控制器方法权限判断
     * @param $id 菜单ID
     */
    public static function ko_controller_perm($id = 0)
    {
        $a = self::ko_is_has_perm($id);
        if (!$a) {
            showMsg('您目前没有足够的权限进行操作');
        }
    }
    /*
     * 操作权限判断
     * @param $id 菜单ID
     */
    public static function ko_is_perm($id = 0, $uid = 0)
    {
        $db = Sys::getdb();
        $a = $db->fetchRow('select mids,roles_ids from {{manager}} where id = ' . $uid);
        $mids = empty($a['mids']) ? array() : explode(',', $a['mids']);
        if (!in_array($id, $mids) && $a['roles_ids'] != 'all') {
            showMsg('您目前没有足够的权限进行操作');
        }
    }
    //遍历当前文件夹，返回文件夹下文件数组
    public static function traverse($dir)
    {
        $a = array();
        $dir = preg_replace('#/$#', '$1', $dir) . '/';
        if (@file_exists($dir)) {
            $dh = @opendir($dir);
            if ($dh) {
                while (false !== ($file = @readdir($dh))) {
                    $filename = $dir . $file;
                    if ($file == '.' || $file == '..' || @is_dir($filename)) {
                        continue;
                    } else {
                        $a[] = $filename;
                    }
                }
            }
            @closedir($dh);
        }
        return $a;
    }
    /**
     * 获取友情连接
     * @param $t     1图片，2文字，3清楚缓存
     * @param $limit 获取多少条记录
     */
    public static function get_link_data($t = 1, $limit = 10)
    {
        $cache = new Public_Cache('site');
        $cacheid = 'Dao_Base_get_link_data_' . $t;
        $a = $cache->get($cacheid);
        if (empty($a)) {
            $db = Sys::getdb();
            $sql = 'select * from {{link}} where isshow=1';
            if ($t == 1) {
                $sql .= ' and pic!=""';
            } elseif ($t == 2) {
                $sql .= ' and LENGTH(pic)=0';
            }
            $a = $db->fetchAll($sql . ' order by sort asc limit ' . $limit);
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    /**
     * 获取网站基础数据
     * @param  $lx_id   类型：1发行周期，2期刊收录，3审稿时间，4期刊荣誉，5期刊级别
     * @param  $hq      1重新生成，0获取
     */
    public static function get_base_info($lx_id = 0, $hq = 0)
    {
        $cache = new Public_Cache('base');
        $cacheid = 'Dao_Base_get_base_info_' . $lx_id;
        $a = $cache->get($cacheid);
        if ($hq == 1 || empty($a)) {
            $db = Sys::getdb();
            $a = $db->fetchAll('select * from {{base_info}} where lx_id=' . $lx_id . ' order by sort asc');
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    //判断文章的Url
    public static function getArtUrl($a = '')
    {
        if (!empty($a)) {
            if (isset($a['id'])) {
                if (isset($a['jump_url']) && $a['jump_url'] != '') {
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
     * 分解参数
     * @param type $g     参数类型
     * @param type $str   字符串
     * @param type $t     字符类型：1整型 ，2字符串
     */
    public static function getListCan($g, $list_aa, $t = 1)
    {
        $s = '';
        if (!empty($list_aa)) {
            foreach ($list_aa as $llv) {
                preg_match('/^' . $g . '(.*?)$/si', $llv, $r);
                if (isset($r['1'])) {
                    $s = $r['1'];
                }
            }
        }
        if ($t == 1) {
            return intval($s);
        } else {
            return trim($s);
        }
    }
    /**
     * 搜索
     * @param type $g     参数类型
     * @param type $aaa  字符串
     * @param type $arr
     * @param type $val 数值
     * @param type $id 分类id
     */
    public static function getArrCan($g, $aaa = array(), $arr = array(), $val = 0, $id = 1)
    {
        unset($aaa[$g]);
        $aaa[$g] = $g . '[?]';
        $aaa = implode('_', $aaa);
        array_unshift($arr, array('id' => 0, 'name' => '不限'));
        foreach ($arr as &$v) {
            if ($v['id'] == $val) {
                $v['xuan'] = 1;
            } else {
                $v['xuan'] = 0;
            }
            $v['url'] = '/list-' . $id . '-' . str_replace('[?]', $v['id'], $aaa) . '.html';
        }
        return $arr;
    }
}
//end class