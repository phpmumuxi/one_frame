<?php

    /** 
     * 首页 - 控制器
     *
     * @Author  Hardy
     */

    class newsController extends FrontController {

        //初始化
        function __construct() {

            parent::__construct(); //执行父类方法           
        }

      
        public function detail(){
            $id=isset($_GET['id']) ? intval($_GET['id']) : 1; 
            $db = Sys::getdb();
            $cat = $db->fetchRow('select parent_id from {{news}} where id=' . $id);
            $param['pre_info']=$db->fetchRow('select id,title from {{news}} where parent_id='.$cat['parent_id'].' and id <' . $id .' order by id desc limit 0,1');
            $param['next_info']=$db->fetchRow('select id,title from {{news}} where parent_id='.$cat['parent_id'].' and id >' . $id .' order by id asc limit 0,1');
            $param['info']=Dao_News::get_info($id);
            $param['tui_arr']=Dao_News::getTuiAll(0,$cat['parent_id']);            
            $this->render('detail',$param,'main');
        }

}