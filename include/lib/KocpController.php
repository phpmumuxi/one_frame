<?php
/**
 * 后台总控制器父类
 * 
 * @Author Hardy
 */
class KocpController extends CommonController
{
    public $ko_admin_id = 0;
    //管理员登录后ID
    //初始化
    function __construct()
    {
        parent::__construct();
        //执行父类方法
        //判断是否登录
        if (!isset($_SESSION['ko_htuser_info']) || empty($_SESSION['ko_htuser_info']) || $_SESSION['ko_htuser_info']['id'] < 1) {
            if (KO_MODULE_NAME == 'kocp' && KO_CONTROLLER_NAME == 'index' && KO_ACTION_NAME == 'login') {
                //登录页面不用判断
            } else {
                tiao_goto('/kocp/index/login');
            }
        } else {
            $this->ko_admin_id = $_SESSION['ko_htuser_info']['id'];
        }
    }
}
//end class