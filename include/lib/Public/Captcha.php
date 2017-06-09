<?php
//if (!@session_id()) { @session_start(); }
/**
 * 验证码类
 *
 * @Author Hardy
 */
class Public_Captcha
{
    public $num;
    //验证码长度
    public $width;
    //宽度
    public $height;
    //高度
    public $fontsize;
    //字体大小
    //生成随机码
    private function createCode()
    {
        $s1 = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789';
        //随机因子
        //$s1 = 'abcdefg@hijkmnpq#rstuvwxyz$ABCDEFG%HJKLMNPQ*RSTUVWXYZ?123456789'; //随机因子
        $s2 = '';
        for ($i = 0; $i < $this->num; $i++) {
            $s2 .= $s1[mt_rand(0, strlen($s1) - 1)];
        }
        Sys::session('ko_captcha', strtolower($s2), 100);
        //转化小写保存到session中，100秒有效期
        return $s2;
    }
    //默认验证
    private function yan($a = '', $b, $c)
    {
        if ($a == '') {
            return $c;
        } elseif (intval($a) < $b) {
            return $b;
        }
        return intval($a);
    }
    //生成图片
    public function doimg()
    {
        $font = KO_INCLUDE_PATH . '/font/texb.ttf';
        //设置字体路径
        $this->num = $this->yan($this->num, 4, 4);
        $this->width = $this->yan($this->width, 50, 85);
        $this->height = $this->yan($this->height, 20, 38);
        $this->fontsize = $this->yan($this->fontsize, 10, 20);
        //生成背景
        $img = @imagecreatetruecolor($this->width, $this->height);
        $color = @imagecolorallocate($img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        @imagefilledrectangle($img, 0, $this->height, $this->width, 0, $color);
        $code = $this->createCode();
        //获取随机码
        //生成线条
        for ($i = 0; $i < floor($this->height / 5); $i++) {
            $color = @imagecolorallocate($img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            @imageline($img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
        }
        //生成雪花
        for ($i = 0; $i < floor($this->width / 5); $i++) {
            $color = @imagecolorallocate($img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            @imagestring($img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '*', $color);
        }
        //生成文字
        $_x = $this->width / $this->num;
        for ($i = 0; $i < $this->num; $i++) {
            $fontcolor = @imagecolorallocate($img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            $a = $_x * $i + mt_rand(1, 5);
            $b = $this->height / 1.4;
            @imagettftext($img, $this->fontsize, mt_rand(-30, 30), $a, $b, $fontcolor, $font, $code[$i]);
        }
        //输出
        header('content-type: image/png');
        @imagepng($img);
        @imagedestroy($img);
    }
}
//end class