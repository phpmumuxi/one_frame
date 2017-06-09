<?php
/**
 * 客户端请求对象
 *
 * @Author Hardy
 */
class Public_Annex
{
    /**
     * 上传文件
     * $img：    上传域
     * $dir：    上传保存文件夹名称
     * $maxsize：上传最大限制(默认5M) 
     */
    public static function ko_upload($img, $dir = 'public', $maxsize = 5)
    {
        $imga = array();
        $err = 1;
        //为1表示上传成成功
        if ($img['error'] == 1) {
            $err = '文件大小超出了服务器的空间大小';
        } elseif ($img['error'] == 2) {
            $err = '文件大小超出了服务器的空间大小';
        } elseif ($img['error'] == 3) {
            $err = '文件仅部分被上传';
        } elseif ($img['error'] == 4) {
            $err = '请选择要上传的文件';
        } elseif ($img['error'] == 5) {
            $err = '服务器临时文件夹丢失';
        } elseif ($img['error'] == 6) {
            $err = '文件写入到临时文件夹出错';
        } elseif ($img['error'] == 0) {
            $postfix = '.' . ($imga['suffix'] = Sys::get_postfix($img['name']));
            //获取文件后缀名
            if ($img['size'] > $maxsize * 1048576) {
                $err = '你上传的文件超过了最大限制 ' . $maxsize . 'MB';
            } else {
                $path = KO_UPLOAD_PATH . '/' . $dir . '/' . date('Ymd');
                Sys::create_dir($path);
                $path .= '/' . time() . mt_rand(0, 99999999) . $postfix;
                if (@file_exists($path)) {
                    @unlink($path);
                }
                if (@move_uploaded_file($img['tmp_name'], $path) > 0) {
                    $imga['full'] = $path;
                    //绝对路径[带文件名]
                } else {
                    $err = '文件上传失败';
                }
            }
        }
        $imga['err'] = $err;
        return $imga;
    }
}
//end class