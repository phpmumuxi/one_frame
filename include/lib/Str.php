<?php
/**
 * 系统字符串函数库
 * 
 * @Author: Hardy
 */
class Str
{
    /**
     * 返回第几天或后几天的[凌晨，结束]的时间戳
     * @param $t  0为当天，正数为第$t天，负数为前$t天
     * @param $h  0凌晨，否则为结束 
     * @Author Hardy
     */
    public static function get_day_time($t = 0, $h = 0)
    {
        $t = strtotime(intval($t) . ' day');
        if (intval($h) == 0) {
            return mktime(0, 0, 0, date('m', $t), date('d', $t), date('Y', $t));
        } else {
            return mktime(23, 59, 59, date('m', $t), date('d', $t), date('Y', $t));
        }
    }
    /**
     * 时间转换函数
     * @param	int	     $t    时间戳
     * @return  string  形如: 刚刚
     * @Author Hardy
     */
    public static function tran_time($t = 0)
    {
        $s = $dtime = date('Y-m-d H:i', $t);
        $rtime = date('m-d H:i', $t);
        $htime = date('H:i', $t);
        $kotime = time() - $t;
        if ($kotime < 60) {
            $s = $kotime . '秒前';
        } else {
            if ($kotime < 60 * 60) {
                $s = floor($kotime / 60) . '分钟前';
            } else {
                if ($kotime < 60 * 60 * 24) {
                    $s = floor($kotime / (60 * 60)) . '小时前' . $htime;
                } else {
                    if ($kotime < 60 * 60 * 24 * 3) {
                        $d = floor($kotime / (60 * 60 * 24));
                        if ($d == 1) {
                            $s = '昨天' . $rtime;
                        } else {
                            $s = '前天' . $rtime;
                        }
                    }
                }
            }
        }
        return $s;
    }
    //附件大小单位换算
    public static function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
        } elseif ($bytes >= 1048576) {
            $bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
        } elseif ($bytes >= 1024) {
            $bytes = round($bytes / 1024 * 100) / 100 . 'KB';
        } else {
            $bytes = $bytes . 'Bytes';
        }
        return $bytes;
    }
    /**
     * 计算 中英文字符串 长度
     * @param	string	$str     要计算长度的字符串
     * @param	int	    $scount  1个汉字算作几个个英文字符
     * @return int	             返回字符串长度
     * @Author Hardy
     */
    public static function str_length($str, $scount = 1)
    {
        $s1 = preg_replace('/[\\x{4e00}-\\x{9fa5}]/u', '', $str);
        $c1 = strlen($s1);
        $c2 = (mb_strlen($str, 'UTF-8') - $c1) * $scount;
        return intval($c1 + $c2);
    }
    /**
     * 汉字转化成拼音 或者 返回输入每个汉字的首字母
     * @param	$str    要转化的汉字
     * @param	$w      1返回每个汉字的首字母，其它返回全拼
     * 输入：我是谁
     * 返回：woshishui  或者 wss
     * @Author Hardy
     */
    public static function get_pinyin($str, $w = 0)
    {
        $len = self::str_length($str);
        $s = '';
        for ($i = 0; $i < $len; $i++) {
            $k = Public_PinYin::get()->{mb_substr($str, $i, 1, 'UTF-8')};
            if ($w == 1) {
                $s .= mb_substr($k, 0, 1, 'UTF-8');
            } else {
                $s .= $k;
            }
        }
        return $s;
    }
    /**
     *	截取 中英文字符串
     *	@param	string	$str	  要截取的字符串
     *	@param  int		$start    截取初始位置
     *	@param  int		$length   截取字符串的长度
     *	@param  bool	$suffix   是否显示省略号
     *	@param	int   	$scount   1个汉字算作几个个英文字符
     *	@return string	          返回截取后的字符串
     *	@Author Hardy
     */
    public static function cut_str($str, $start = 0, $length = 10, $suffix = true, $scount = 1)
    {
        $pos = $start;
        $bytenum = 0;
        $out = $suffix_str = '';
        $len = self::str_length($str, $scount);
        while ($length) {
            $ko = mb_substr($str, $pos, 1, 'UTF-8');
            if (strlen($ko) == 1) {
                $pos++;
                $bytenum++;
                if ($bytenum > $length) {
                    break;
                }
                $out .= $ko;
            } else {
                $pos++;
                $bytenum = $bytenum + $scount;
                if ($bytenum > $length) {
                    break;
                }
                $out .= $ko;
            }
        }
        if ($suffix && $len > $length) {
            $suffix_str = '...';
        }
        return $out . $suffix_str;
    }
    /**
     *	判断字符串中是否有图片
     *	@param	string	$str	  要判断的字符串
     *	@return int	              返回 1有， 0没有
     *	@Author hardy
     */
    public static function is_str_img($s = '')
    {
        $s = trim($s);
        if ($s != '' && preg_match('|<img[^>]+>|i', $s)) {
            return 1;
        }
        return 0;
    }
    /**
     * 将数组转换为json字符串（兼容中文），要下面的arrayRecursive方法配合使用
     * @param	array	$array	要转换的数组
     * @return  string		    转换得到的json字符串
     * @Author  Hardy
     */
    public static function json($a)
    {
        self::arrayRecursive($a, 'urlencode', true);
        $json = json_encode($a);
        return urldecode($json);
    }
    /**
     * 使用特定function对数组中所有元素做处理 (配合上面json方法使用)
     * @param	string	&$array		要处理的字符串
     * @param	string	$function	要执行的函数
     * @return boolean	$apply_to_keys_also		是否也应用到key上
     * @Author Hardy
     */
    private static function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
    {
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                self::arrayRecursive($array[$key], $function, $apply_to_keys_also);
            } else {
                $array[$key] = $function($value);
            }
            if ($apply_to_keys_also && is_string($key)) {
                $new_key = $function($key);
                if ($new_key != $key) {
                    $array[$new_key] = $array[$key];
                    unset($array[$key]);
                }
            }
        }
        $recursive_counter--;
    }
    /**
     * 重要的转义函数1，用途
     * 1、主要用于拼写sql，2、用于输出html
     * @param {string} $s     原始字符串
     * @param {int}    $level 级别越高(最大10，最小0)，过滤越多
     * @return {string} 转义后的字符串
     * @Author  Hardy
     */
    public static function changeHTML($s, $level = 0)
    {
        if ($level == 0) {
            return $s;
        } elseif ($level == 1) {
            return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
        } elseif ($level == 2) {
            return htmlentities($s, ENT_QUOTES, 'UTF-8');
        } elseif ($level == 3) {
            return strip_tags($s);
        } elseif ($level == 4) {
            //更加彻底的删除标签和特殊字符
            return htmlentities(strip_tags($s), ENT_QUOTES, 'UTF-8');
        } elseif ($level == 5) {
            //更加彻底的删除标签和特殊字符,去除空白 , 谢烨：用于标题
            $s = preg_replace('/\\s+/', '', $s);
            return htmlentities(strip_tags($s), ENT_QUOTES, 'UTF-8');
        } elseif ($level == 6) {
            //用于like
            $s = preg_replace('/\\s+/', '', $s);
            $s = preg_replace('/[^\\x{4e00}-\\x{9fa5}0-9a-zA-Z.]/u', '', $s);
            return htmlentities(strip_tags($s), ENT_QUOTES, 'UTF-8');
        } elseif ($level == 9) {
            //更加彻底的删除标签和特殊字符,只剩下[0-9a-zA-Z_]
            $s = preg_replace('/\\W+/', '', $s);
            return htmlentities(strip_tags($s), ENT_QUOTES, 'UTF-8');
        } elseif ($level == 10) {
            //用于描述
            $s = preg_replace('/\\s+/', '', $s);
            $s = htmlentities(strip_tags($s), ENT_QUOTES, 'UTF-8');
            $s = preg_replace('#(&|nbsp;|amp;)#', '', $s);
            return $s;
        }
    }
    /**
     * php 二维数组按键值排序
     * @param   $arr    排序数组
     * @param   $keys   要排序的键
     * @param   $type   desc是降序，asc升序
     * @param   $zz     取值前几项，默认0全部
     * @param   $unk    0保留原键名，1使用新键名
     * @Author  Hardy
     */
    public static function array_sort($arr, $keys, $type = 'asc', $zz = 0, $unk = 0)
    {
        $a = $b = array();
        if (!empty($arr)) {
            foreach ($arr as $k => $v) {
                $a[$k] = $v[$keys];
            }
            if ($type == 'asc') {
                asort($a);
            } else {
                arsort($a);
            }
            reset($a);
            $c = 0;
            foreach ($a as $k => $v) {
                if ($unk == 1) {
                    $newkey = $c;
                } else {
                    $newkey = $k;
                }
                $b[$newkey] = $arr[$k];
                $c++;
                if ($zz > 0 && $c == $zz) {
                    break;
                }
            }
        }
        return $b;
    }
    /**
     * 取一维数组前几项值
     * @param   $arr    数组
     * @param   $p      几项
     * @Author  Hardy
     */
    public static function get_arr_top($arr, $p = 5)
    {
        $new = array();
        $c = 0;
        foreach ($arr as $key => $ko) {
            $c++;
            $new[$key] = $ko;
            if ($c == $p) {
                break;
            }
        }
        return $new;
    }
    /**
     * Ajax输出JSON
     * @param $data   返回信息，可以是字符串和数组
     * @param $status 状态：0错误，1成功，2未登录
     */
    public static function ajax_json($data = '请输入正确的方法操作', $status = 0)
    {
        exit(json_encode(array('status' => $status, 'data' => $data)));
    }
    /**
     * 字符串加密解密函数
     * @param $string： 要加密的字符串
     * @param $operation：DECODE表示解密,其它表示加密
     * @param $key： 密匙
     * @param $expiry：密文有效期：0为不限时间
     */
    public static function ko_auth_code($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        //动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $ckey_length = 9;
        $key = trim($key);
        $ko_authcode_key = 'TDS1+@+!++~+GF$66%9&8F(DS&*()rstu‰vwx4y±zA)BCD~`+=,EFGH34-64F3=43.DS$';
        $key = md5($key && $key != '' ? $key : $ko_authcode_key);
        //密匙
        $keya = md5(substr($key, 0, 16));
        //密匙a会参与加解密
        $keyb = md5(substr($key, 16, 16));
        //密匙b会用来做数据完整性验证
        //密匙c用于变化生成的密文
        $keyc = $ckey_length ? $operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length) : '';
        //参与运算的密匙
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
        //明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
        //如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        //产生密匙簿
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        //用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        //核心加解密部分
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            //从密匙簿得出密匙进行异或，再转成字符
            $result .= chr(ord($string[$i]) ^ $box[($box[$a] + $box[$j]) % 256]);
        }
        if ($operation == 'DECODE') {
            //substr($result, 0, 10) == 0 验证数据有效性
            //substr($result, 0, 10) - time() > 0 验证数据有效性
            //substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
            //验证数据有效性，请看未加密明文的格式
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            //把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
            //因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }
    
}
//end class