<?php
/**
 * 网站综合 - 逻辑处理
 *
 * @Author Hardy
 */
class Dao_Site
{
    /**
     * 校验 - 验证码
     * @param   $c 要验证的字符串
     * @return  返回空表示输入成功，其它为为错误则提示错误信息
     */
    public static function check_yzm($c = '')
    {
        $c = trim(strtolower($c));
        $s = 1;
        if ($c == '') {
            $s = '请输入验证码';
        } elseif (Sys::session('ko_captcha') === null) {
            $s = '验证码已经过期，请点击刷新';
        } elseif ($c != Sys::session('ko_captcha')) {
            $s = '验证码输入错误，请重新输入';
        }
        return $s;
    }
    //查询网站设置分类
    public static function get_set_cat_data($qk = 0)
    {
        $cache = new Public_Cache('setcat');
        $cacheid = 'Dao_Site_get_set_cat_data';
        $a = $cache->get($cacheid);
        if ($qk == 1 || !$a) {
            $db = Sys::getdb();
            $a = $db->fetchAll('select * from {{set_cat}} order by sort asc');
            $cache->set($cacheid, $a);
        }
        return $a;
    }
    /**
     * 获取后台菜单数据
     * @param  $t   1获取所有，2根据ID获取子菜单，3获取单个信息
     * @param  $qk  0：获取，1清空在查询
     */
    public static function get_backmenu_data($t = 1, $qk = 0)
    {
        $a = array();
        if ($t == 1) {
            $cache = new Public_Cache('backmenu');
            $cacheid = 'Dao_Site_get_backmenu_data';
            $a = $cache->get($cacheid);
            if ($qk == 1 || !$a) {
                $db = Sys::getdb();
                $a = $db->fetchAll('select * from {{backmenu}} order by parent_id asc,sort asc');
                $cache->set($cacheid, $a);
            }
        } elseif ($t == 2) {
            $b = self::get_backmenu_data(1);
            if (!empty($b)) {
                foreach ($b as $v) {
                    if ($v['parent_id'] == intval($qk)) {
                        $a[] = $v;
                    }
                }
            }
        } elseif ($t == 3) {
            $b = self::get_backmenu_data(1);
            if (!empty($b)) {
                foreach ($b as $v) {
                    if ($v['id'] == intval($qk)) {
                        return $v;
                    }
                }
            }
        }
        return $a;
    }
    /*
     * 获取子级ID
     * @param $a    数据数组
     * @param $cid  数据ID
     */
    public static function get_child_ids($a, $cid)
    {
        $cid = intval($cid);
        $s = $cid;
        if (!empty($a)) {
            foreach ($a as $v) {
                if ($v['parent_id'] && $v['parent_id'] == $cid) {
                    $s .= ',' . self::get_child_ids($a, $v['id']);
                }
            }
        }
        return $s;
    }
    //更新网站所有缓存
    public static function clearCacheAll()
    {
        $cache = new Public_Cache();
        $cache->clearAll(KO_CACHE_PATH);
        Sys::del_empty_dir(KO_UPLOAD_PATH);
        //删除空目录
    }
    /**
     * 获取系统所有配置
     * @param  $t  0获取所有，1重新获取所有，2获取单个配置，3列出所有配置可直接获取($code=1为重新生成获取)
     */
    public static function ko_get_configs($t = 0, $code = '')
    {
        $a = array();
        if ($t == 2) {
            $b = self::ko_get_configs();
            if (!empty($b)) {
                foreach ($b as $v) {
                    if ($v['code'] == $code) {
                        $a = $v;
                        break;
                    }
                }
            }
        } elseif ($t == 3) {
            $cache = new Public_Cache('configs');
            $cacheid = 'Dao_Site_ko_get_configs3';
            $a = $cache->get($cacheid);
            if ($code == 1 || !$a) {
                $b = self::ko_get_configs();
                if (!empty($b)) {
                    foreach ($b as $k => $v) {
                        $a[$v['code']] = $v['value'];
                    }
                }
            }
        } else {
            $cache = new Public_Cache('configs');
            $cacheid = 'Dao_Site_ko_get_configs0';
            $a = $cache->get($cacheid);
            if ($t == 1 || !$a) {
                $db = Sys::getdb();
                $a = $db->fetchAll('select * from {{configs}} order by sort asc');
                $cache->set($cacheid, $a);
            }
        }
        return $a;
    }
    //网站总成交 - 每天自动增加
    public static function auto_banner_value($a)
    {
        $b = explode('-', $a['ko_stie_totle_clinch']);
        $date = isset($b['1']) ? intval($b['1']) : 0;
        $now = date('Ymd');
        $vv = intval($b['0']);
        $s = '';
        if ($now > $date) {
            $db = Sys::getdb();
            $vv += mt_rand(1, 30);
            $db->query('update {{configs}} set value="' . $vv . '-' . $now . '" where code="ko_stie_totle_clinch"');
            self::ko_get_configs(1);
            //更新缓存
            self::ko_get_configs(3, 1);
            //更新缓存
        }
        for ($i = 0; $i < strlen($vv); $i++) {
            $s .= '<span>' . substr($vv, $i, 1) . '</span>';
        }
        return $s;
    }
    /**
     * 获取下拉框代码
     * @param  $name    控件名称[第一项默认值]
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
}
//end class