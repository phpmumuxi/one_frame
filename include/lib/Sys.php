<?php
/**
 * 系统公用方法 函数库
 * 
 * @Author: Hardy
 */
class Sys
{
    //连接本地MySql数据库
    public static function getdb()
    {
        static $db = null;
        if ($db == null) {
            $a = Sys::get_config_data('database');
            if (PHP_OS == 'Linux') {
                //服务器环境
                $b = $a['database_1'];
            } else {
                //本地开发环境
                $b = $a['database_2'];
            }
            $db = new Public_PdoMysql($b);
        }
        return $db;
    }
    //连接本地MySql数据库
    public static function getdb2()
    {
        static $db = null;
        if ($db == null) {
            $a = Sys::get_config_data('database');
            $b = $a['database_1'];
            $b['dbhost'] = '106.185.53.133';
            $db = new Public_PdoMysql($b);
        }
        return $db;
    }
    //生成目录(可以多级目录)
    public static function create_dir($dir = '')
    {
        if (!@is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }
    //删除文件
    public static function file_unlink($n)
    {
        if (!@is_dir || !@is_file($n)) {
            $n = KO_ROOT_PATH . $n;
        }
        if (@file_exists($n)) {
            @unlink($n);
        }
    }
    /**
     * 生成文件
     * @param string $n 文件名称，绝对路径
     * @param string $t 文件内容
     */
    public static function create_file($n, $s = '')
    {
        $p = preg_replace('/(\\/[^\\/]+)\\/?$/', '$2', $n);
        self::create_dir($p);
        file_put_contents($n, $s);
    }
    //判断是否为空目录
    public static function is_empty_dir($dir)
    {
        $dir = preg_replace('/\\/$/', '', $dir) . '/';
        if (($a = @scandir($dir)) && @count($a) <= 2) {
            return true;
        }
        return false;
    }
    //删除空目录
    public static function del_empty_dir($dir)
    {
        $dir = preg_replace('/\\/$/', '', $dir) . '/';
        if (self::is_empty_dir($dir)) {
            @rmdir($dir);
        } else {
            if (@file_exists($dir)) {
                $dh = @opendir($dir);
                if ($dh) {
                    while (false !== ($file = @readdir($dh))) {
                        $path = str_replace('\\', '/', $dir . $file);
                        if ($file == '.' || $file == '..') {
                            continue;
                        } elseif (@is_dir($path)) {
                            if (self::is_empty_dir($path)) {
                                @rmdir($path);
                            } else {
                                self::del_empty_dir($path);
                            }
                        }
                    }
                }
                @closedir($dh);
                if (self::is_empty_dir($dir)) {
                    @rmdir($dir);
                }
            }
        }
    }
    //生成单号，百万几率重复(20位)
    public static function create_num()
    {
        return date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', mt_rand(0, 99));
    }
    //获取文件的后缀名，转化成小写
    public static function get_postfix($file)
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }
    /**
     * 根据缩略图路径获取图片宽和高
     * @param $p  缩略图路径带文件名
     * @param $t  1获取宽度，2获取高度
     */
    public static function get_W_H($p, $t = 2)
    {
        if ($t == 1) {
            return preg_replace('#^.*?/[^/].*?_(\\d+)x(\\d+).(.*?)$#', '$1', $p);
        } elseif ($t == 2) {
            return preg_replace('#^.*?/[^/].*?_(\\d+)x(\\d+).(.*?)$#', '$2', $p);
        }
    }
    /**
     * 密码扰乱字符串
     * @param $u  用户名
     * @param $s  密码字符串
     * @param $t  0前台，1后台
     */
    public static function pwd_key($u = '', $p = '', $t = 0)
    {
        return md5('ko.546554@' . $t . '#!g+6]98%~/f*gds' . $p . '@4.4%@@!-9*6-d' . $u . 'dko');
    }
    /*
     * 生成随机字符串md5加密
     * @param $length 生成多少位字符串，默认9位
     */
    public static function make_chars($length = 9)
    {
        //密码字符集，可任意添加需要的字符
        $chars = 'abcdefg.;:/?hijklmnopq#$%^&*()rstu‰vwxy±zABCD~`+=,EFGHI!@JKLM4567φNOPQRSTUαVWXY]{}Z012389-_ [<>|';
        $s = '';
        for ($i = 0; $i < $length; $i++) {
            $s .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return md5(time() . $s . mt_rand(0, 10000));
    }
    //保留两位小数，不四舍五入
    public static function num_format($num, $n = 2)
    {
        return number_format((int) ($num * 100) / 100, $n);
    }
    //删除字符串中的空格
    public static function trimall($str = '')
    {
        $a = array(" ", "　", "\t", "\n", "\r");
        $b = array('', '', '', '', '');
        return str_replace($a, $b, $str);
    }
    /**
     * 判断是否手机或者电脑访问网站
     * 
     * @return boolean  true:手机访问，false：电脑访问
     */
    public static function is_mobile_request()
    {
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
        $mobile_browser = 0;
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }
        if (isset($_SERVER['HTTP_ACCEPT']) and strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false) {
            $mobile_browser++;
        }
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            $mobile_browser++;
        }
        if (isset($_SERVER['HTTP_PROFILE'])) {
            $mobile_browser++;
        }
        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array('w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');
        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) {
            $mobile_browser++;
        }
        // Pre-final check to reset everything if the user is on Windows
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) {
            $mobile_browser = 0;
        }
        // But WP7 is also Windows, with a slightly different characteristic
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) {
            $mobile_browser++;
        }
        if ($mobile_browser > 0) {
            return true;
        } else {
            return false;
        }
    }
    //获取配置文件路径
    public static function get_config_path($n = 'system')
    {
        return KO_INCLUDE_PATH . '/configs/' . $n . '.php';
    }
    //获取配置文件数据
    public static function get_config_data($n = 'system')
    {
        static $data = array();
        if (!isset($data[$n])) {
            $file = self::get_config_path($n);
            if (@is_file($file)) {
                $data[$n] = (require_once $file);
            } else {
                return false;
            }
        }
        return $data[$n];
    }
    /**
     * session方法，设置，获取   
     * @param   $n    名称
     * @param   $v    '___get'获取值， '___clear'清空， 其它值为要设置的值
     * @param   $t    设置过期时间(单位秒)，默认0和系统设置过期时间一样
     * @Author  Hardy
     */
    public static function session($n, $v = '___get', $t = 0)
    {
        if (!@session_id()) {
            @session_start();
        }
        //开启会话
        //清除过期的
        if (isset($_SESSION['___KO'])) {
            foreach ($_SESSION['___KO'] as $sn => $sv) {
                if (isset($sv['time']) && time() > $sv['time']) {
                    unset($_SESSION['___KO'][$sn]);
                }
            }
        }
        switch ($v) {
            case '___clear':
                //清空
                unset($_SESSION['___KO'][$n]);
                break;
            case '___get':
                //获取
                if (isset($_SESSION['___KO'][$n]['code']) && (!isset($_SESSION['___KO'][$n]['time']) || isset($_SESSION['___KO'][$n]['time']) && $_SESSION['___KO'][$n]['time'] > time())) {
                    return $_SESSION['___KO'][$n]['code'];
                }
                unset($_SESSION['___KO'][$n]);
                return null;
                break;
            default:
                //存储
                $a = array('code' => $v);
                $t = intval($t);
                if ($t > 0) {
                    $a['time'] = time() + $t;
                }
                $_SESSION['___KO'][$n] = $a;
                break;
        }
    }
    /*
     * 网站规则读取
     */
    public static function route_config($t = 0)
    {
        $cache = new Public_Cache('sys');
        $cacheid = 'route_config';
        $a = $cache->get($cacheid);
        if ($t == 1 || empty($a)) {
            $db = Sys::getdb();
            $arr = $db->fetchAll("select route from {{route}}");
            foreach ($arr as $v) {
                $a[] = unserialize($v['route']);
            }
            $cache->set($cacheid, $a);
        }
        return $a;
    }
}
//end class