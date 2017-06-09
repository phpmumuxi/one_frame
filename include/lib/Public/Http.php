<?php
/**
 * 客户端请求对象
 *
 * @Author Hardy
 */
class Public_Http
{
    /**
     * 获取当前页面完整URL
     * @param $t   0不加密，1加密(base64_encode)
     * @Author Hardy
     */
    public static function get_self_url($t = 0)
    {
        $s = strtolower($_SERVER['SERVER_PROTOCOL']);
        $s = substr($s, 0, stripos($s, '/'));
        $s .= empty($_SERVER['HTTPS']) ? '' : $_SERVER['HTTPS'] == 'on' ? 's' : '';
        $s .= '://' . $_SERVER['SERVER_NAME'];
        $s .= $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
        if (isset($_SERVER['REQUEST_URI'])) {
            $s .= $_SERVER['REQUEST_URI'];
        } else {
            if (isset($_SERVER['argv'])) {
                $s .= $_SERVER['PHP_SELF'] . '?' . $_SERVER['argv']['0'];
            } elseif (isset($_SERVER['QUERY_STRING'])) {
                $s .= $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
            }
        }
        if ($t == 1) {
            $s = base64_encode($s);
        }
        return $s;
    }
    /**
     * CURL发送请求
     * @param $url     请求地址
     * @param $data    请求参数可以是数组或字符串
     * @param $method  请求方式 get和post
     * @param $follow  是否抓取跳转后的页面：1是，0否
     * @param $referer 设置访问来路：默认随机
     * @param $ref_ip  设置访问IP：默认随机，-1不使用
     * @param $cookie  是否启用：0不启用，1获取cookie，2取出cookie一起提交给服务器
     * @param $cookname cookie文件名称
     * @param $is_daili  1使用代理，0不使用
     * @Author Hardy
     */
    public static function curl($url, $data = '', $method = 'get', $follow = 1, $referer = '', $ref_ip = '', $cookie = 0, $cookname = '', $is_daili = 0)
    {
        $referer_arr = array('http://www.jd.com/', 'http://www.qq.com/', 'http://www.sogou.com/', 'http://www.baidu.com/', 'http://www.paipai.com/', 'http://www.suning.com/', 'http://www.mogujie.com/', 'http://www.meilishuo.com/');
        if (empty($referer)) {
            $referer = $referer_arr[mt_rand(0, count($referer_arr) - 1)];
        }
        $agent_arr = array('Mozilla/5.0 (Windows NT 6.1; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/6.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729)');
        $agent = $agent_arr[mt_rand(0, count($agent_arr) - 1)];
        $ip = self::create_ip();
        $cookie_path = KO_COOKIE_PATH . '/';
        Sys::create_dir($cookie_path);
        //创建文件夹
        $cookie_jar = $cookie_path . 'ko_' . md5(empty($cookname) ? time() : $cookname);
        $cdh = @opendir($cookie_path);
        //删除当天之前的所有文件
        if ($cdh) {
            while (false !== ($cfile = @readdir($cdh))) {
                $cpath = $cookie_path . $cfile;
                if ($cfile == '.' || $cfile == '..' || @is_dir($cpath)) {
                    continue;
                } else {
                    $ft = filectime($cpath);
                    if (!$ft || $ft <= strtotime('-1 days')) {
                        @unlink($cpath);
                    }
                }
            }
        }
        @closedir($cdh);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //不显示头部信息
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        //设置超时限制防止死循环(秒)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //返回字符串数据：1是，0否
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        //设置访问来路
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        //设置访问浏览器
        //curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate'); //解释gzip压缩内容
        if ($is_daili == 1) {
            //通过代理访问
            $daili_a = self::get_daili_ip();
            if (!empty($daili_a)) {
                curl_setopt($ch, CURLOPT_PROXY, $daili_a['0']);
                curl_setopt($ch, CURLOPT_PROXYPORT, $daili_a['1']);
            }
        }
        if ($ref_ip != -1) {
            if ($ref_ip != '') {
                $ip = $ref_ip;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip, 'REAL_IP:' . $ip, 'X_FORWARD_FOR:' . $ip, 'PROXY_USER:' . $ip));
            //设置访问IP
        }
        if ($cookie == 1) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
            //将cookie存入文件
        } elseif ($cookie == 2) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
            //取出cookie一起提交给服务器
        }
        if (stripos(strtolower($url), 'https://') !== false) {
            //不认证SSH
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        if ($data && $method == 'post') {
            //POST方式请求
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($follow == 1) {
            //抓取跳转后的页面
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            //            if (ini_get('open_basedir')=='' && ini_get('safe_mode'=='Off')) {
            //                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            //            } else {
            //                self::curl_redir_exec($ch);
            //            }
        }
        $out = curl_exec($ch);
        curl_close($ch);
        return $out;
    }
    //follow on location problems workaround
    public static function curl_redir_exec($ch)
    {
        static $curl_loops = 0;
        static $curl_max_loops = 20;
        if ($curl_loops++ >= $curl_max_loops) {
            $curl_loops = 0;
            return false;
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $debbbb = $data;
        list($header, $data) = explode("\n\n", $data, 2);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 301 || $http_code == 302) {
            $matches = array();
            preg_match('/Location:(.*?)\\n/', $header, $matches);
            $url = @parse_url(trim(array_pop($matches)));
            if (!$url) {
                $curl_loops = 0;
                return $data;
            }
            $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
            $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query'] ? '?' . $url['query'] : '');
            curl_setopt($ch, CURLOPT_URL, $new_url);
            return self::curl_redir_exec($ch);
        } else {
            $curl_loops = 0;
            return $debbbb;
        }
    }
    //GBK转UTF-8
    public static function gbk_to_utf8($s = '')
    {
        return mb_convert_encoding($s, 'UTF-8', 'GBK');
    }
    //UTF-8转GBK
    public static function utf8_to_gbk($s = '')
    {
        return mb_convert_encoding($s, 'GBK', 'UTF-8');
    }
    //获取服务器的IP地址
    public static function get_server_ip()
    {
        static $serverip = null;
        if ($serverip !== null) {
            return $serverip;
        }
        if (isset($_SERVER)) {
            if (isset($_SERVER['SERVER_ADDR'])) {
                $serverip = $_SERVER['SERVER_ADDR'];
            } else {
                $serverip = '0.0.0.0';
            }
        } else {
            $serverip = getenv('SERVER_ADDR');
        }
        return $serverip;
    }
    //获得客户端的真实IP地址
    public static function get_client_ip()
    {
        static $clientip = null;
        if ($clientip !== null) {
            return $clientip;
        }
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arr as $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $clientip = $ip;
                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $clientip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                if (isset($_SERVER['REMOTE_ADDR'])) {
                    $clientip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $clientip = '0.0.0.0';
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $clientip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $clientip = getenv('HTTP_CLIENT_IP');
            } else {
                $clientip = getenv('REMOTE_ADDR');
            }
        }
        preg_match('/[\\d\\.]{7,15}/', $clientip, $onlineip);
        return !empty($onlineip['0']) ? $onlineip['0'] : '0.0.0.0';
    }
    //动态生成IP
    public static function create_ip()
    {
        return mt_rand(1, 255) . '.' . mt_rand(1, 255) . '.' . mt_rand(1, 255) . '.' . mt_rand(1, 255);
    }
    //获取代理IP和端口
    public static function get_daili_ip()
    {
        $url = 'http://erwx.daili666.com/ip/?tid=556413365455049&num=1';
        $str = trim(Public_Http::curl($url));
        $a = array();
        if ($str != '') {
            $a = explode(':', $str);
        }
        return $a;
    }
}
//end class