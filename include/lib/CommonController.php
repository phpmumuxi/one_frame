<?php
/**
 * 控制器父类
 * 
 * @Author Hardy
 */
class CommonController
{
    //全局变量
    public $db = null;
    //db对象
    public $ko_site_configs = null;
    //网站系统设置
    //初始化
    function __construct()
    {
        //获取系统配置
        $this->ko_site_configs = Dao_Site::ko_get_configs(3);
    }
    /**
     * 调用模板
     * @param $n 模板文件名
     * @param $p 参数
     * @param $layout 布局模板文件名
     * @param $return 是否输出字符串
     * @Author Hardy
     */
    public function render($n = '', $p = array(), $layout = '', $return = false)
    {
        $ko_template_file = KO_MODULE_DIR . '/templates/' . KO_CONTROLLER_NAME . '/' . $n . '.php';
        if (@file_exists($ko_template_file)) {
            if (@is_array($p) && !empty($p)) {
                @extract($p, EXTR_OVERWRITE);
            }
            $ko_layout_file = KO_TEMPLATES_PATH . '/' . $layout . '.php';
            if ($return) {
                ob_start();
                ob_implicit_flush(false);
            }
            if (@file_exists($ko_layout_file)) {
                require_once $ko_layout_file;
            } else {
                require_once $ko_template_file;
            }
            if ($return) {
                return ob_get_clean();
            }
        } else {
            KO_Exception('模板文件：' . $n . '.php 不存在');
        }
    }
}
//end class