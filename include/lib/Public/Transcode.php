<?php
/**
 * PHP - 编码转换 处理函数
 *
 * @Author Hardy
 */
class Public_Transcode
{
    /**
     * PHP - [utf-8 转unicode]
     * @param type $name  要转换的字符串
     * @param type $sign  加密前缀：默认\u, 还可以是%u
     * @return type
     */
    public static function unicode_encode($name = '', $sign = '\\u')
    {
        $name = iconv('UTF-8', 'UCS-2', $name);
        $len = strlen($name);
        $str = '';
        for ($i = 0; $i < $len - 1; $i = $i + 2) {
            $c = $name[$i];
            $c2 = $name[$i + 1];
            if (ord($c) > 0) {
                //两个字节的文字
                $str .= $sign . strtoupper(base_convert(ord($c), 10, 16) . str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT));
                //转换为大写
            } else {
                $str .= $c2;
                //$str .= $sign.str_pad(base_convert(ord($c2), 10, 16), 4, 0, STR_PAD_LEFT);
            }
        }
        return $str;
    }
    //PHP - [unicode 转 utf-8]
    public static function unicode_decode($name = '')
    {
        $name = strtolower($name);
        // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
        $pattern = '/([\\w]+)|(\\\\u([\\w]{4}))/i';
        preg_match_all($pattern, $name, $matches);
        if (!empty($matches)) {
            $name = '';
            for ($j = 0; $j < count($matches['0']); $j++) {
                $str = $matches['0'][$j];
                if (strpos($str, '\\u') === 0) {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code) . chr($code2);
                    $c = iconv('UCS-2', 'UTF-8', $c);
                    $name .= $c;
                } else {
                    $name .= $str;
                }
            }
        }
        return $name;
    }
    /**
     * PHP - UrlDecode解码
     * @param  $source  要解码的字符串
     */
    public static function utf8RawUrlDecode($source = '')
    {
        $decodedStr = '';
        $pos = 0;
        $len = strlen($source);
        while ($pos < $len) {
            $charAt = substr($source, $pos, 1);
            if ($charAt == '%') {
                $pos++;
                $charAt = substr($source, $pos, 1);
                if ($charAt == 'u') {
                    // we got a unicode character
                    $pos++;
                    $unicodeHexVal = substr($source, $pos, 4);
                    $unicode = hexdec($unicodeHexVal);
                    $entity = '&#' . $unicode . ';';
                    $decodedStr .= utf8_encode($entity);
                    $pos += 4;
                } else {
                    // we have an escaped ascii character
                    $hexVal = substr($source, $pos, 2);
                    $decodedStr .= chr(hexdec($hexVal));
                    $pos += 2;
                }
            } else {
                $decodedStr .= $charAt;
                $pos++;
            }
        }
        return $decodedStr;
    }
}
//end class