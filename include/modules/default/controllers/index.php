<?php

    /** 
     * 首页 - 控制器
     *
     * @Author  Hardy
     */

    class indexController extends FrontController {

        //初始化
        function __construct() {

            parent::__construct(); //执行父类方法           
        }

        //首页
         public function index(){
            $db = Sys::getdb(); 
            $param['data_info']=$db->fetchAll('select id,name from {{product}} order by rand() limit 8');          
            $param['question_data']= Dao_Que::getTuiAll();          
            $param['product_hot']=Dao_Product::getHotProduct(0,8);
            $param['title']='德亨文生物科技有限公司';
            $this->render('index',$param,'main');
         }
         //首页ajax获取栏目
         public function info(){
            $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1; 
            $db = Sys::getdb();             
            $cat_arr = $db->fetchRow('select id,name from {{category}}  where type=1 and id='.$id);
            $cat_arr =  array_merge(array(array('id'=>$cat_arr['id'],'name'=>$cat_arr['name'])),Dao_Product::getProductAll($id));               
            $str="<h4><a href='/lists-".$cat_arr[0]['id']."-1.html'>" . $cat_arr[0]['name'] . "</a></h4>";
            array_shift($cat_arr);
            $str.=" <ul>";
            foreach ($cat_arr as $v) {
                $str.="  <li><a href='/detail-".$v['id'].".html'>" . $v['name'] . "</a></li>";
            }
            $str.=" </ul>";
            $str.=" <a href='javascript:;'>&gt;&gt;点击咨询</a>";
            echo $str;
    }
    
        //实验平台列表页      
        public function lists(){
            $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;
            $db = Sys::getdb();
            $param['data'] = $db->fetchRow('select * from {{category}}  where type=1 and id='.$id);
            $s1 = 'select id,name,img,lab_about ';         
            $s2 = 'from {{product}} where parent_id='.$id;    
            $s2 .= " order by id desc";
            $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
            $page = new Public_Page($s1,$s2,$p,5);            
            $page->url_tp = 4; //$page->pageUrl = '/index/lists/id/'.$id.'/p/';
             $page->pageUrl = '/lists-'.$id.'-[?].html';
            //$param['page_arr'] = $page->getPageArr();
             $param['page_arr'] = $page->getPageStr(1);
            $param['page_data'] = $page->getItems();    
            $param['hot_arr']= Dao_Product::getHotProduct();
            $param['title']='德亨文生物科技有限公司_实验平台';
            $this->render('lists',$param,'main');
        }

        
          //实验平台详情页
        public function detail(){
            $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;
            $param['data_info']=Dao_Product::get_info($id);
            $param['parent_info']=Dao_Product::get_parent_info($param['data_info']['parent_id']);
            if($param['parent_info']['id']==1){
                $param['hot_news']=Dao_News::getAllArts(9,7);  
            }elseif($param['parent_info']['id']==2){
                $param['hot_news']=Dao_News::getAllArts(10,7);
            }elseif($param['parent_info']['id']==3){
                $param['hot_news']=Dao_News::getAllArts(11,7);
            }elseif($param['parent_info']['id']==4){
                $param['hot_news']=Dao_News::getAllArts(12,7);
            }            
            $param['hot_arr']=Dao_Product::getHotProduct($param['data_info']['parent_id']);
            $param['title']='德亨文生物科技有限公司_实验';
            $this->render('detail',$param,'main');  
        }
        
         //公司简介
        public function about(){
            $param['title']='公司介绍';
            $this->render('about',$param,'main');          
        }
        //在线报价
        public function lineSale(){
            $param['title']='在线报价';
            $this->render('lineSale',$param,'main');          
        }
        //行业资讯
        public function artInfo(){
            $s1 = 'select * ';         
            $s2 = 'from {{news}} where parent_id=18 and is_tui=1';    
            $s2 .= " order by id desc";
            $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
            $page = new Public_Page($s1,$s2,$p,9);
            $param['page_arr'] = $page->getPageStr(1);          
            $param['page_data'] = $page->getItems(); 
            $param['title']='行业资讯';
            $this->render('artInfo',$param,'main');          
        }
         public function art_info(){
            $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
            $db = Sys::getdb();
            $param['data']= $db->fetchRow('select * from {{news}} where parent_id=18 and id='.$id);
            $param['dataArr']= Dao_Product::getHotProduct();
            $param['title']='德亨文生物科技有限公司_资讯文章';
            $this->render('art_info',$param,'main');          
        }
         //服务流程
        public function server(){
            $param['title']='服务流程';
            $this->render('server',$param,'main');          
        }
          //常见问题
        public function question(){
            $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;            
            $db = Sys::getdb();               
            $s1 = 'select * ';
            if($id>1){
                $s2 = 'from {{question}} where status=1 and type_id='.$id;
                $param['type_info'] =  $db->fetchRow('select * from {{category}}  where type=2 and id='.$id);
            }else{
                $s2 = 'from {{question}} where status=1';
            }                    
            $s2 .= " order by id asc";        
            $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
            $page = new Public_Page($s1,$s2,$p,10);
            if($id>1){
                $page->url_tp = 4; 
                $page->pageUrl = '/question-'.$id.'-[?].html';
                //$page->pageUrl = '/index/question/p/';                
            }
            $param['page_arr'] = $page->getPageStr(1);
            //$param['page_arr'] = $page->getPageArr();
            $param['p']=$p;
            $param['question_arr'] = $page->getItems();
            $param['question_type'] =  $db->fetchAll('select * from {{category}}  where type=2 and parent_id=0');
            $param['title']='常见问题'; 
            $this->render('question',$param,'main');
        }
        
          //实验文章
        public function infomation(){             
            $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 9;
            $db = Sys::getdb();
            $param['infomation'] = $db->fetchRow('select * from {{category}}  where type=2 and id='.$id);
            if($param['infomation']['parent_id']>0){
                $a = $db->fetchRow('select id from {{category}}  where type=2 and id='.$param['infomation']['parent_id']);
                $param['arr']= Dao_News::getCategoryAll($a['id']); 
                $param['parent_info']= Dao_News::parent_info($param['infomation']['id']);                
            }else{               
               $param['arr']= Dao_News::getCategoryAll($param['infomation']['id']); 
               $param['parent_info'][]= $param['infomation'];               
            }             
            $arrs=$db->fetchAll('select * from {{category}}');
            $data=Dao_Site::get_child_ids($arrs,$id);
            $s1 = 'select id,title,img,parent_id ';         
            $s2 = 'from {{news}} where parent_id in('.$data.')';    
            $s2 .= " order by id desc";
            $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
            $page = new Public_Page($s1,$s2,$p,5);            
            $page->url_tp = 4; 
            $page->pageUrl = '/infomation-'.$id.'-[?].html';
            $param['page_data'] = $page->getItems();
            //$param['page_arr'] = $page->getPageArr();
            $param['page_arr'] = $page->getPageStr(1);
            //$param['page_arr']['url'] = '/infomation-'.$id.'-'.$p.'.html';
           // print_r($param['page_arr']);die;
            $param['hot_news_arr']= Dao_Product::getHotProduct();
            $param['title']='德亨文生物科技有限公司_实验技术平台';
            $this->render('infomation',$param,'main');           
        }
         //实验平台详情页
        public function single(){
            $id= isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;            
            $param['news_info']=Dao_News::get_info($id);
            $param['arr']= Dao_News::getNewsAll($param['news_info']['parent_id']);            
            $param['parent_info']= Dao_News::parent_info($param['news_info']['parent_id']);
            if($param['parent_info'][1]['id']==9){
                $param['hot_arr']=Dao_Product::getHotProduct(1,3);
                $param['question_arr']=Dao_Que::getTuiAll(9);
            } elseif ($param['parent_info'][1]['id']==10) {
                $param['hot_arr']=Dao_Product::getHotProduct(2,3);
                $param['question_arr']=Dao_Que::getTuiAll(10);
            }elseif ($param['parent_info'][1]['id']==11) {
                $param['hot_arr']=Dao_Product::getHotProduct(3,3);
                $param['question_arr']=Dao_Que::getTuiAll(11);
            }elseif ($param['parent_info'][1]['id']==12) {
                $param['hot_arr']=Dao_Product::getHotProduct(4,3);
                $param['question_arr']=Dao_Que::getTuiAll(12);
            }
            $param['title']='德亨文生物科技有限公司_实验文章';
            $this->render('single',$param,'main');  
        }
        
        
          // 搜索页
        public function search(){
            $param['search_type']=  isset($_GET['search_type'])?intval($_GET['search_type']):1;
            $param['key_words']= isset($_GET['key_words'])?urldecode($_GET['key_words']):'';
            if(empty($param['key_words'])){  showMsg('请输入你要收索关键词'); }
            $db = Sys::getdb();
            $s1 = 'select * ';             
            if($param['search_type']==2){
                $s2 = "from {{news}} where title like :name";
            }else {
                $s2  ="from {{product}} where name like :name";
            }            
            $db_arr[':name'] = '%'.$param['key_words'].'%';
            $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
            $page = new Public_Page($s1,$s2,$p,9,$db_arr);            
            $page->url_tp = 4; $page->pageUrl = '/index/search/search_type/'.$param['search_type'].'/key_words/'.$param['key_words'].'/p/';             
            $param['page_arr'] = $page->getPageArr(); 
            $param['page_data'] = $page->getItems(); 
            $param['hot_arr'] =Dao_Product::getHotProduct(0,2);
            $param['title']='德亨文生物科技有限公司';
            $this->render('search',$param,'main');
        }       
  
} //end class