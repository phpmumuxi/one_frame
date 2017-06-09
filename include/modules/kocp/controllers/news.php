<?php
/**
 * 后台 - 实验室新闻管理
 *
 * @Author wyl
 */
class newsController extends KocpController {

	//初始化
    function __construct() {
        parent::__construct(); //执行父类方法
    }
     //新闻管理
    public function content(){
        $db = Sys::getdb();
        $param['cat_arr']=$db->fetchAll('select id,name from {{category}}');         
        $s1 = 'select *';
        $s2 = 'from {{news}} where 1 = 1';
        $param['title'] = isset($_POST['title']) ? $_POST['title'] : '';
        if(!empty($param['title'])){
            $s2 .= " and title like '%{$param["title"]}%'";
        }
        $s2 .= " order by id desc";
        $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page = new Public_Page($s1,$s2,$p,10);
        $param['page_str'] = $page->getPageStr(1);
        //$param['data_arr'] = Dao_Base::getArtUrl($page->getItems());
        $param['data_arr'] = $page->getItems();
        //var_dump($param['data_arr']);die;
        $this->render('content',$param,'cp_main');
    }

    //新闻新增
    public function contentAdd(){
        //获取栏目分类
        $db = Sys::getdb();//Dao_Site::get_child_ids($arr,0);
        $datas=$db->fetchAll('select * from {{category}} where type=2 or type=3');              
        $tree = new Public_Tree($datas);
        $param['data_arr'] = $tree->get_tree(0);   
        //var_dump($param['data_arr']);die;
        $this->render('contentAdd',$param,'cp_main');
    }

    public function content_add(){
        $db = Sys::getdb();
        $this->table = 'news';
        $param['title'] = $_POST['news_title'];
        $param['parent_id'] = $_POST['parent_id'];
        $param['is_tui'] = isset($_POST['is_tui'])?intval($_POST['is_tui']):0;        
        $param['content'] = $_POST['content'];
        $param['time'] = time();        
        if ($param['title'] == '') { showMsg('请填写标题'); } 
        if ($param['content'] == '') { showMsg('请填写内容'); } 
        if ($param['parent_id']==0) { showMsg('请正确选择上级目录');}        
        if(!empty($_FILES['img']['name'])){
            $d = Public_Img::upload($_FILES['img'],'news');
            $param['img'] = $d['path'];
        }
        $data = $db->insert($this->table,$param);
        if($data){
            showMsg('编辑成功','/kocp/news/content',1);
        }
    }

    //新闻编辑
    public function contentEdit(){
        $id = intval($_GET['id']);
        if($id>0){
            $db = Sys::getdb();
            $datas=$db->fetchAll('select * from {{category}} where type=2 or type=3');          
            $tree = new Public_Tree($datas);
            $param['data_arr'] = $tree->get_tree(0);             
            $param['data'] = $db->fetchRow('select * from {{news}} where id ='.$id);
            $this->render('contentEdit',$param,'cp_main');
        }
    }

    public function content_edit(){
        $id = intval($_POST['id']);
        $db = Sys::getdb();
        $this->table = 'news';
        $param['title'] = $_POST['news_title'];
        $param['parent_id'] = $_POST['parent_id'];        
        $param['is_tui'] = isset($_POST['is_tui'])?intval($_POST['is_tui']):0;
        
        $param['content'] = $_POST['content'];              
        if ($param['title'] == '') { showMsg('请填写标题'); } 
        if ($param['content'] == '') { showMsg('请填写内容'); } 
        if ($param['parent_id']==0) { showMsg('请正确选择上级目录');}
        if(!empty($_FILES['img']['name'])){            
            $d = Public_Img::upload($_FILES['img'],'news');
            $param['img'] = $d['path'];
            $img=$db->fetchRow('select img from {{news}} where id='.$id);
            Sys::file_unlink($img['img'] ); //删除物理图片路径
        }
        $data = $db->update("news",$param,array("id"=>$id));        
        if($data || $data == 0){
            showMsg('编辑成功','/kocp/news/content',1);
        }
    }

    public function contentDel(){
        $db = Sys::getdb();
        $id = intval($_GET['id']);               
        $data = $db->delete('news',array('id' => $id));
        if($data){
            showMsg('删除成功','/kocp/news/content',1);
        }
    }
}
?>