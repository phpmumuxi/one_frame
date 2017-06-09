<?php

    /** 
     * 首页 - 控制器
     *
     * @Author  Hardy
     */

    class productController extends FrontController {

        //初始化
        function __construct() {
            parent::__construct(); //执行父类方法
            $this->ko_current_menu = 0;
        }

         //肿瘤基因检测
         public function index(){
           $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;           
            if($id==20){  //遗传易感基因检测  乳腺癌
               $this->render('product20','','main'); 
            }elseif($id==21){   //遗传易感基因检测  其他癌种
               $this->render('product21','','main');
            }elseif($id==10){   //预后诊断和复发风险预估  乳腺癌
               $this->render('product10','','main');
            }elseif($id==11){   //预后诊断和复发风险预估  结直肠癌
               $this->render('product11','','main');
            }elseif($id==12){           //预后诊断和复发风险预估     其他癌种  
                $this->render('product12','','main');
            }else{    //肿瘤个体化用药下的其他癌种
                 $this->render('product1','','main');
            }              
        } 
        public function pinfo(){
            $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;
            $param['data']=Dao_Product::get_info($id);           
            $this->render('pinfo',$param,'main');
        }
        
        public function research(){
            $db = Sys::getdb();        
            $keywords= trim($_POST['keywords']);  
            if(empty($keywords)){ showMsg('请填写你要搜索的关键词','/'); }
            if( !empty($_POST['submit']) && !empty($keywords) && strpos($_POST['sub_key'], 'keywords')){ 
               $param['data']=$db->fetchRow("select * from {{product}} where name like '%".$keywords."%' limit 0,1");
               if($param['data']){
                   $this->render('pinfo',$param,'main'); 
               }else{
                   showMsg('很抱歉，没有搜索到！','/');
               }                          
            }
        }
        
    } //end class