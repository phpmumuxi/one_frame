<?php
/**
 * 网站工具 - 逻辑处理
 *
 * @Author Hardy
 */
class Public_Tool
{
    /**
     * KindEditor编辑器
     * 
     * @Author: Hardy
     */
    public static function showKEditor($id, $value = '', $width = '70%', $height = '500px', $style = 'visibility:hidden;', $upload_state = 'true', $media_open = false)
    {
        $media = '';
        if ($media_open) {
            $media = ", 'flash', 'media'";
        }
        $items = "['source', '|', 'fullscreen', 'undo', 'redo', 'print', 'cut', 'copy', 'paste',\r\n\t\t\t'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',\r\n\t\t\t'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',\r\n\t\t\t'superscript', '|', 'selectall', 'clearhtml','quickformat','|',\r\n\t\t\t'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',\r\n\t\t\t'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage'" . $media . ", 'table', 'hr', 'emoticons', 'link', 'unlink', '|', 'about']";
        echo "\r\n<textarea id=\"" . $id . "\" name=\"" . $id . "\" style=\"width:" . $width . ";height:" . $height . ";" . $style . "\">" . $value . "</textarea>";
        echo "\r\n<script src=\"" . "/static/js/kindeditor/kindeditor-min.js\" charset=\"utf-8\"></script>";
        echo "\r\n<script src=\"" . "/static/js/kindeditor/lang/zh_CN.js\" charset=\"utf-8\"></script>";
        echo "\r\n<script type=\"text/javascript\">\r\nvar js_KE;\r\nKindEditor.ready(function(K) {\r\n\tjs_KE = K.create(\"textarea[name='" . $id . "']\", {\r\n\t\titems:" . $items . ",\r\n\t\tcssPath:\"" . "/static/js/kindeditor/themes/default/default.css\",\r\n\t\tuploadJson:\"" . "/tool/keupload/\",\r\n\t\tfilterMode:false,\r\n\t\tallowImageUpload:" . $upload_state . ",\r\n\t\tallowFlashUpload:false,\r\n\t\tallowMediaUpload:false,\r\n\t\tallowFileManager:false,\r\n\t\tsyncType:\"form\",\r\n\t\tafterCreate:function(){\r\n\t\tvar self = this;\r\n\t\t\tself.sync();\r\n\t\t},\r\n\t\tafterChange:function(){\r\n\t\t\tvar self = this;\r\n\t\t\tself.sync();\r\n\t\t},\r\n\t\tafterBlur:function(){\r\n\t\t\tvar self = this;\r\n\t\t\tself.sync();\r\n\t\t}\r\n\t});";
        echo "\r\n\tjs_KE.appendHtml = function(id,val) {\r\n\t\tthis.html(this.html() + val);\r\n\t\tif (this.isCreated) {\r\n\t\t\tvar cmd = this.cmd;\r\n\t\t\tcmd.range.selectNodeContents(cmd.doc.body).collapse(false);\r\n\t\t\tcmd.select();\r\n\t\t}\r\n\t\treturn this;\r\n\t}\r\n});\r\n</script>\r\n";
        return true;
    }
    //根据字符串删除里面本地图片
    public static function del_str_img($str = '')
    {
        preg_match_all("/src=[\"|\\'|\\s]{0,}(.*?\\.(gif|jpeg|jpg|png))/is", $str, $a);
        if (!empty($a)) {
            $a = array_unique($a['1']);
            foreach ($a as $v) {
                Sys::file_unlink($v);
            }
        }
    }
    //计算一个月多少天
    //参数2016-03
    public static function getMonthDay($date)
    {
        date_default_timezone_set('PRC');
        $y = substr($date, 0, 4);
        $m = substr($date, 5, 2);
        //指定的月
        $d = date('j', mktime(0, 0, 1, $m == 12 ? 1 : $m + 1, 1, $m == 12 ? $y + 1 : $y) - 24 * 3600);
        return $d;
    }
}
//end class