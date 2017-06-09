<?php
/**
 * 前台总控制器父类
 * 
 * @Author Hardy
 */
class FrontController extends CommonController
{
    //前台全局变量
    public $ko_current_menu = 0;
    //是否登录，登录为会员ID
    //初始化
    function __construct()
    {
        parent::__construct();
        //执行父类方法
        //判断网站是否关闭
        if ($this->ko_site_configs['site_status'] == 1) {
            exit(include KO_TEMPLATES_PATH . '/site_closed.php');
        }
        //栏目
        $this->ko_site_configs['ko_menu'] = Dao_Art::getCatRow(0, 2);
    }
}
//end class