<?php

    /** 
     * 首页 - 控制器
     *
     * @Author  Hardy
     */

    class otherController extends FrontController {

        //初始化
        function __construct() {

            parent::__construct(); //执行父类方法
            $this->ko_current_menu = 0;
        }

        //首页
         public function index(){
           $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;           
           if($id==2){
               $this->render('others2','','main');           
            }elseif($id==3){
               $this->render('others3','','main'); 
            }elseif($id==4){
               $this->render('others4','','main');
            }elseif($id==5){
               $this->render('others5','','main');
            }else{                  
                $this->render('others','','main');
            }           
        } 

	

       
    } //end class