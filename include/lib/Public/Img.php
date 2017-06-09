<?php
/**
 * 客户端请求对象
 *
 * @Author Hardy
 */
class Public_Img {

    /**
     * 图片上传
     * $img：    上传图片域
     * $dir：    上传图片保存文件夹名称
     * $maxsize：上传图片最大限制(默认2M)
     */
    public static function upload($img, $dir='public', $maxsize=2) {
        $imga = array(); $err = 1;//为1表示上传成成功
        if ($img['error'] == 1) {
            $err = '图片大小超出了服务器的空间大小';
        } elseif ($img['error'] == 2) {
            $err = '图片大小超出了服务器的空间大小';
        } elseif ($img['error'] == 3) {
            $err = '图片仅部分被上传';
        } elseif ($img['error'] == 4) {
            $err = '请选择要上传的图片';
        } elseif ($img['error'] == 5) {
            $err = '服务器临时文件夹丢失';
        } elseif ($img['error'] == 6) {
            $err = '文件写入到临时文件夹出错';
        } elseif ($img['error'] == 0) {
            $postfix = '.' . Sys::get_postfix($img['name']); //获取文件后缀名
            $hzm_arr = array('.jpg','.jpeg','.gif','.png'); $info = getImageSize($img['tmp_name']);
            if (!in_array($postfix, $hzm_arr) || !$info) {
                $err = '只允许上传jpg,jpeg,gif,png格式的图片';
            } elseif ($img['size'] > $maxsize*1048576) {
                $err = '你上传的图片超过了最大限制 '.$maxsize.'MB';
            } else {
                $path = KO_UPLOAD_PATH .'/'.$dir.'/'.date('Ymd');
                Sys::create_dir($path); $new_name = time().mt_rand(0, 99999999).$postfix;
                $path .= '/'.$new_name; if (@file_exists($path)) { @unlink($path); }
                if (@move_uploaded_file($img['tmp_name'], $path) > 0) {                 
                    //self::resize($path, 650, 0); //调整图片大小
                    //Public_Img::imageWaterMark( $path ); //给图片添加水印
                    $imga['width'] = $info['0']; $imga['height'] = $info['1'];
                    $imga['name']  = $new_name;
                    //preg_replace('/.+?data/', '', $path); //保存路径[相对路径]                    
                    $imga['path']  = str_replace(KO_ROOT_PATH, '', $path); //保存路径[相对路径]
                    $imga['full']  = $path; //图片绝对路径[带文件名]
                } else {
                    $err = '图片上传失败';
                }
            }
        }
        $imga['err'] = $err; return $imga;
    }
    
    /**
     * 调整图片大小
     * @param  $old_path   带绝对路径的图片地址
     * @param  $maxW       上传图片后切割的最大宽度
     * @param  $maxH       上传图片后切割的最大高度
     * @Author  Hardy
     */
    public static function resize($old_path='', $maxW=700, $maxH=0) {
        $info = getimagesize( $old_path );
        if ($info && ($info['0']>$maxW || $info['1']>$maxH)) {
            $infunc = $outfunc = '';
            switch ($info['2']) {
                case 1:
                    $infunc = 'ImageCreateFromGif';
                    $outfunc = 'ImageGif';
                    break;
                case 2:
                    $infunc = 'ImageCreateFromJpeg';
                    $outfunc = 'ImageJpeg';
                    break;
                case 3:
                    $infunc = 'ImageCreateFromPng';
                    $outfunc = 'ImagePng';
                    break;
            }
            if ($info['0'] > $info['1']) {
                $maxW = @min($maxW, $info['0']);
                $maxH = intval( $info['1']/($info['0']/$maxW) );
            } elseif ($maxW == 0) { 
                $maxW = ($maxH / $info['1'] * $info['0']);
                $maxH = @min($maxH, $info['1']);
            } elseif ($maxH == 0) { 
                $maxW = @min($maxW, $info['0']);
                $maxH = ($maxW / $info['0'] * $info['1']);
            } else {
                $maxW = intval( $info['0']/($info['1']/$maxH) );
                $maxH = @min($maxH, $info['1']);
            }
            $img = @$infunc($old_path); $thumb = ImageCreateTrueColor($maxW, $maxH);
            ImageCopyResampled($thumb, $img, 0, 0, 0, 0, $maxW, $maxH, $info['0'], $info['1']);
            @$outfunc($thumb, $old_path); imagedestroy( $img ); imagedestroy( $thumb );
        }
    }

    /**
     * 创建缩略图，不变形，(如果缩略图尺寸大于原尺寸直接拷贝，但改名)
     * @param  $old_path  原文件的绝对路径
     * @param  $maxW      缩略图宽，如果为 "0-226" 表示宽自动，后面值为最小
     * @param  $maxH      缩略图高，如果为 "0-320" 表示高自动，后面值为最小
     * @param  $isSave    是否保存：1保存，0显示图片
     *
     * 返回：一个数组
     * array(
     *    'width'    => 120,
     *    'height'   => 120,
     *    'name' => '123_120x120.jpg',
     *    'path' => '/upload/ko/2009/3/21/123_120x120.jpg',
     *    'full' => 'D:/WorkSpace/www80/share/data/upload/ko/2009/3/21/123_120x120.jpg',
     * )
     */
    public static function thumb($old_path, $maxW=120, $maxH=120, $isSave=1) {
        $minW = $minH = 0;
        if (strpos($maxW, '-')) {
            $minW = substr($maxW, strpos($maxW, '-')+1); $maxW = 0;
        }
        if (strpos($maxH, '-')) {
            $minH = substr($maxH, strpos($maxH, '-')+1); $maxH = 0;
        }
        $info = getimagesize($old_path); $oldW = $info['0']; $oldH = $info['1'];
        if ($maxW==0 && $maxH==0) {
            $maxW = $oldW; $maxH = $oldH;
        } elseif($maxW == 0) {
            $maxW = @max(($maxH / $oldH * $oldW), $minW);
            $maxH = @min($maxH, $oldH);
        } elseif ($maxH == 0) {
            $maxW = @min($maxW, $oldW);
            $maxH = @max(($maxW / $oldW * $oldH), $minH);
        }
        $ratio = ($maxW / $maxH);
        if ($oldH > ($oldW / $ratio)) {
            $src_width = $oldW;
            $src_height = ($oldW / $ratio);
            $src_x = 0;
            $src_y = (($oldH - $src_height) / 2);
        } else {
            $src_width = ($oldH * $ratio);
            $src_height = $oldH;
            $src_x = (($oldW - $src_width) / 2);
            $src_y = 0;
        }
        if ($maxW>=$oldW && $maxH>=$oldH) {
            $src_x = $src_y = 0;
            $maxW = $src_width = $oldW;
            $maxH = $src_height = $oldH;
        } else {
            $maxW = @min($maxW, $src_width);
            $maxH = @min($maxH, $src_height);
        }
        $infunc = $outfunc = $top_lx = '';
        switch ($info['2']) {
            case 1:
                $infunc = 'ImageCreateFromGif';
                $outfunc = 'ImageGif';
                $top_lx = 'gif';
                break;
            case 2:
                $infunc = 'ImageCreateFromJpeg';
                $outfunc = 'ImageJpeg';
                $top_lx = 'jpeg';
                break;
            case 3:
                $infunc = 'ImageCreateFromPng';
                $outfunc = 'ImagePng';
                $top_lx = 'png';
                break;
        }
        $width = floor($maxW); $height = floor($maxH);
        $new_path = preg_replace('#^(.+)(\.[^.]+)$#','${1}_'.$width.'x'.$height.'${2}', $old_path);
        $msg = array(
            'width' => $width, 'height' => $height, 'full' => $new_path,
            'name' => preg_replace('#^.+/([^/]+)$#', '$1', $new_path),
            'path' => str_replace(KO_ROOT_PATH, '', $new_path),
        );
        if ($isSave==1 && $maxW>=$oldW && $maxH>=$oldH) {
            @copy($old_path, $new_path);
        } else {
            //重新画图
            $img = @$infunc($old_path); $thumb = ImageCreateTrueColor($maxW, $maxH);
            ImageCopyResampled($thumb, $img, 0, 0, $src_x, $src_y, $maxW, $maxH, $src_width, $src_height);
            if ($isSave == 1) {
                if (@file_exists($new_path)) { @unlink($new_path); }
                if ($top_lx == 'jpeg') {
                    @$outfunc($thumb, $new_path, 100);
                } else {
                    @$outfunc($thumb, $new_path);
                }
                imagedestroy($img); imagedestroy($thumb);
            } else {
                //缓存图片
                ob_start(); @$outfunc($thumb, false);
                if ($top_lx == 'jpeg') {
                    @$outfunc($thumb, false, 100);
                } else {
                    @$outfunc($thumb, false);
                }
                ob_implicit_flush(false); $data = ob_get_clean();
                imagedestroy($img); imagedestroy($thumb);
                header('Content-type:image/'.$top_lx); exit( $data );
            }
        }
        return $msg;
    }
    
    /**
     * 功能：PHP图片水印 (水印支持图片或文字)
     * 参数：
     *       $groundImage    背景图片(绝对路径)，即需要加水印的图片，暂只支持GIF,JPG,PNG格式；
     *       $waterPos       水印位置，有10种状态，0为随机位置；
     *                       1为顶端居左，2为顶端居中，3为顶端居右；
     *                       4为中部居左，5为中部居中，6为中部居右；
     *                       7为底端居左，8为底端居中，9为底端居右；
     *       $waterImage     图片水印(绝对路径)，即作为水印的图片，暂只支持GIF,JPG,PNG格式；
     *       $waterText      文字水印，即把文字作为为水印，支持ASCII码，不支持中文；
     *       $fontSize       文字大小，值为1、2、3、4或5，默认为5；
     *       $textColor      文字颜色，值为十六进制颜色值，默认为#CCCCCC(白灰色)；
     *       $fontfile       ttf字体文件，即用来设置文字水印的字体。使用windows的用户在系统盘的目录中
     *                       搜索*.ttf可以得到系统中安装的字体文件，将所要的文件拷到网站合适的目录中,
     *                       默认是当前目录下arial.ttf。
     *       $xOffset        水平偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果你想留给水印留
     *                       出水平方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向右移2个单位,-2 表示向左移两单位
     *       $yOffset        垂直偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果你想留给水印留
     *                       出垂直方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向下移2个单位,-2 表示向上移两单位
     * 返回值：
     *        0   水印成功
     *        1   水印图片格式目前不支持
     *        2   要水印的背景图片不存在
     *        3   需要加水印的图片的长度或宽度比水印图片或文字区域还小，无法生成水印
     *        4   字体文件不存在
     *        5   水印文字颜色格式不正确
     *        6   水印背景图片格式目前不支持
     * 修改记录：
     *         
     * 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG
     *       $waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。
     *       当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。
     *       加水印后的图片的文件名和 $groundImage 一样。
     *
     *
     * @Author Hardy
     */    
    public static function imageWaterMark($groundImage, $waterPos=0, $waterImage='', $waterText='', $fontSize=12, $textColor='#FF0000', $fontfile='jiankai.ttf', $xOffset=0, $yOffset=0) {
        $isWaterImage = false; $xta = Dao_Site::ko_get_configs( 3 );
        if ($xta['ko_upload_watermark'] == 1) {
            $waterPos = (($waterPos>9 || $waterPos<1) ? $xta['ko_watermark_pos'] : $waterPos);
            $marktrans = ($xta['ko_photo_marktrans']>100||$xta['ko_photo_marktrans']<1) ? 100 : $xta['ko_photo_marktrans'];
            if ($xta['ko_photo_marktype'] == 1) {
                $waterImage = ($waterImage=='' ? KO_ROOT_PATH.$xta['ko_watermark_pic'] : $waterImage);
            } else {            
                $waterText = ($waterText=='' ? $xta['ko_photo_watertext'] : $waterText);
                $fontSize = ($fontSize=='' ? $xta['ko_photo_fontsize'] : $fontSize);
                $textColor = ($textColor=='' ? $xta['ko_photo_fontcolor'] : $textColor);
                $fontfile = KO_INCLUDE_PATH.'/font/'.$fontfile;
            }
            //读取水印文件
            if (!empty($waterImage) && file_exists($waterImage)) {
                $isWaterImage = true;
                $water_info = getimagesize( $waterImage );
                $water_w = $water_info['0'];//取得水印图片的宽
                $water_h = $water_info['1'];//取得水印图片的高
                switch ($water_info['2']) { //取得水印图片的格式  
                    case 1:$water_im = imagecreatefromgif($waterImage);break;
                    case 2:$water_im = imagecreatefromjpeg($waterImage);break;
                    case 3:$water_im = imagecreatefrompng($waterImage);break;
                    default:return 1;
                }
            }
            //读取背景图片
            if (!empty($groundImage) && file_exists($groundImage)) {
                $ground_info = getimagesize($groundImage);
                $ground_w = $ground_info['0'];//取得背景图片的宽
                $ground_h = $ground_info['1'];//取得背景图片的高
                switch ($ground_info['2']) {    //取得背景图片的格式  
                    case 1:$ground_im = imagecreatefromgif($groundImage);break;
                    case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
                    case 3:$ground_im = imagecreatefrompng($groundImage);break;
                    default:return 1;
                }
            } else {
                return 2;
            }
            //水印位置
            if ($isWaterImage) { //图片水印  
                $w = $water_w; $h = $water_h;
            } else {
                //文字水印
                if (!file_exists($fontfile)) { return 4; }
                $temp = imagettfbbox($fontSize, 0, $fontfile, $waterText);//取得使用 TrueType 字体的文本的范围
                $w = $temp['2'] - $temp['6'];
                $h = $temp['3'] - $temp['7'];
                unset($temp);
            }
            if ( ($ground_w < $w) || ($ground_h < $h) ) {
                return 3;
            }
            switch ($waterPos) {
                case 1://1为顶端居左
                    $posX = 0;
                    $posY = 0;
                    break;
                case 2://2为顶端居中
                    $posX = ($ground_w - $w) / 2;
                    $posY = 0;
                    break;
                case 3://3为顶端居右
                    $posX = $ground_w - $w;
                    $posY = 0;
                    break;
                case 4://4为中部居左
                    $posX = 0;
                    $posY = ($ground_h - $h) / 2;
                    break;
                case 5://5为中部居中
                    $posX = ($ground_w - $w) / 2;
                    $posY = ($ground_h - $h) / 2;
                    break;
                case 6://6为中部居右
                    $posX = $ground_w - $w;
                    $posY = ($ground_h - $h) / 2;
                    break;
                case 7://7为底端居左
                    $posX = 0;
                    $posY = $ground_h - $h;
                    break;
                case 8://8为底端居中
                    $posX = ($ground_w - $w) / 2;
                    $posY = $ground_h - $h;
                    break;
                case 9://9为底端居右
                    $posX = $ground_w - $w;
                    $posY = $ground_h - $h;
                    break;
                default://随机
                    $posX = rand(0,($ground_w - $w));
                    $posY = rand(0,($ground_h - $h));
                    break;     
            }
            //设定图像的混色模式
            imagealphablending($ground_im, true);

            if ($isWaterImage) { //图片水印
                imagecopy($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h);//拷贝水印到目标文件         
            } else { //文字水印
                if( !empty($textColor) && (strlen($textColor)==7) ) {
                    $R = hexdec(substr($textColor, 1, 2));
                    $G = hexdec(substr($textColor, 3, 2));
                    $B = hexdec(substr($textColor, 5));
                } else {
                    return 5;
                }
                imagettftext ( $ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
            }
            //生成水印后的图片
            @unlink( $groundImage );
            switch ($ground_info['2']) {//取得背景图片的格式
                case 1:imagegif($ground_im, $groundImage);break;
                case 2:imagejpeg($ground_im, $groundImage, $marktrans);break;
                case 3:imagepng($ground_im, $groundImage);break;
                default: return 6;
            }
            //释放内存
            if (isset($water_info)) { unset($water_info); }
            if (isset($water_im)) { imagedestroy($water_im); }
            unset($ground_info); imagedestroy($ground_im);
            return 0;
        }
    }

    //合成图片
    public static function ko_mergeimg($nickname, $tou_img, $code_img) {
        //默认图像处理
        $xta = Dao_Site::ko_get_configs( 3 );
        $default_img = KO_ROOT_PATH.$xta['ko_default_background_img'];
        
        $canvasInfo = self::ko_getImageInfo($default_img);
        $canvasCreateFun = 'imagecreatefrom'.$canvasInfo['type'];
        $canvasImage = $canvasCreateFun($default_img);

        $fontfile = KO_INCLUDE_PATH.'/font/jiankai.ttf'; //载入字体
        
        //文字颜色
        $R = hexdec(substr($xta['ko_nick_img_color'], 1, 2));
        $G = hexdec(substr($xta['ko_nick_img_color'], 3, 2));
        $B = hexdec(substr($xta['ko_nick_img_color'], 5));
        $ufcolor = imagecolorallocate($canvasImage, $R, $G, $B);
        
        $nickname = $xta['ko_nick_img_prefix'].$nickname;
        $nickname = mb_convert_encoding($nickname, 'html-entities', 'utf-8');
        //在图片中插入文字(图像，字形尺寸，字形角度，x坐标，y坐标，颜色，字体文件名称，字符串)
        imagettftext($canvasImage, $xta['ko_nick_img_fontsize'], 0, $xta['ko_nick_img_left'], $xta['ko_nick_img_top'], $ufcolor, $fontfile, $nickname);

        //头像图像处理
        $avatarInfo = self::ko_getImageInfo($tou_img);
        $avatarCreateFun = 'imagecreatefrom'.$avatarInfo['type'];
        $avatarImage = $avatarCreateFun($tou_img);
        //源图像，添加的图像，源图像x坐标，源图像y坐标，添加的图片的x左边，添加的图片的y坐标，添加的图片的宽度，添加的图片的高度，角度
        imagecopymerge($canvasImage, $avatarImage, $xta['ko_avatar_img_left'], $xta['ko_avatar_img_top'], 0, 0, $avatarInfo['width'], $avatarInfo['height'], 100);

        //二维码图像处理
        $codeInfo = self::ko_getImageInfo($code_img);
        $codeCreateFun = 'imagecreatefrom'.$codeInfo['type'];
        $codeImage = $codeCreateFun($code_img);
        imagecopymerge($canvasImage, $codeImage, $xta['ko_code_img_left'], $xta['ko_code_img_top'], 0, 0, $codeInfo['width'], $codeInfo['height'], 100);

        //设定图像的保持透明色
        imagealphablending($canvasImage, false);
        imagesavealpha($canvasImage, true);

        //输出图像
        $ImageFun = 'Image'.$canvasInfo['type'];
        $ImageFun($canvasImage, $code_img);

        //销毁对象
        imagedestroy($canvasImage);
        imagedestroy($avatarImage);
        imagedestroy($codeImage);
    }    
    
    //获取图片信息
    public static function ko_getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo['2']), 1));
            $imageSize = filesize($img);
            return array(
                'width' => $imageInfo['0'], 'height' => $imageInfo['1'],
                'type' => $imageType, 'size' => $imageSize, 'mime' => $imageInfo['mime']
            );
        } else {
            return false;
        }
    }
    
} //end class