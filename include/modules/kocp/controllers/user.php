<?php
/**
 * 后台 - 实验室新闻管理
 *
 * @Author wyl
 */
class userController extends KocpController {

	//初始化
    function __construct() {
        parent::__construct(); //执行父类方法
    }
     
    public function info(){
        $db = Sys::getdb();                
        $s1 = 'select * ';
        $s2 = 'from {{line_price}} where 1 = 1';
        $param['name'] = isset($_POST['name']) ? $_POST['name'] : '';
        if(!empty($param['name'])){
            $s2 .= " and name like '%{$param["name"]}%'";
        }
        $s2 .= " order by id desc";
        $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page = new Public_Page($s1,$s2,$p,10);
        $param['page_str'] = $page->getPageStr(1);        
        $param['data_arr'] = $page->getItems();        
        $this->render('info',$param,'cp_main');
    }
    
    //问题回答
    public function content(){
        $db = Sys::getdb();               
        $s1 = 'select *';
        $s2 = 'from {{question}} where 1 = 1';
        $param['question'] = isset($_POST['question']) ? $_POST['question'] : '';
        if(!empty($param['question'])){
            $s2 .= " and question like '%{$param["question"]}%'";
        }
        $s2 .= " order by id desc";
        $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page = new Public_Page($s1,$s2,$p,10);
        $param['page_str'] = $page->getPageStr(1);        
        $param['data_arr'] = $page->getItems(); 

        $this->render('content',$param,'cp_main');
    }

    //新闻新增
    public function contentAdd(){ 
        $db = Sys::getdb(); 
        $param['type_arr']=$db->fetchAll('select * from {{category}} where parent_id = 0 and type = 2');       
        $this->render('contentAdd',$param,'cp_main');
    }

    public function content_add(){
        $db = Sys::getdb();
        $this->table = 'question';
        $param['question'] = isset($_POST['question'])?$_POST['question']:''; 
        $param['answer'] = isset($_POST['answer'])?$_POST['answer']:'';
        $param['status'] = isset($_POST['status'])?intval($_POST['status']):'';        
        $param['type_id'] = isset($_POST['type_id'])?intval($_POST['type_id']):'';               
        $param['time'] = time(); 

        if ($param['status'] === '') { showMsg('请填写审核状态'); } 
        if ($param['type_id'] == '') { showMsg('请填写类型'); } 

        $data = $db->insert($this->table,$param);
            if($data){
                showMsg('编辑成功','/kocp/user/content',1);
            } 
    }

    //新闻编辑
    public function contentEdit(){
        $id = intval($_GET['id']);
        if($id>0){
            $db = Sys::getdb();
            $param['type_arr']=$db->fetchAll('select * from {{category}} where parent_id = 0 and type = 2');                          
            $param['data'] = $db->fetchRow('select * from {{question}} where id ='.$id);
            $this->render('contentEdit',$param,'cp_main');
        }
    }

    public function content_edit(){
        $id = intval($_POST['id']);
        $db = Sys::getdb();        
        $param['question'] = isset($_POST['question'])?$_POST['question']:''; 
        $param['answer'] = isset($_POST['answer'])?$_POST['answer']:'';
        $param['status'] = isset($_POST['status'])?intval($_POST['status']):''; 
        $param['type_id'] = isset($_POST['type_id'])?intval($_POST['type_id']):'';       
        $param['time'] = time(); 
        if ($param['type_id'] == '') { showMsg('请填写类型'); }            
        if ($param['status'] === '') { showMsg('请填写审核状态'); }
        $data = $db->update("question",$param,array("id"=>$id));        
        if($data || $data == 0){
            showMsg('编辑成功','/kocp/user/content',1);
        }
    }

    public function contentDel(){
        $db = Sys::getdb();
        $id = intval($_GET['id']);               
        $data = $db->delete('question',array('id' => $id));
        if($data){
            showMsg('删除成功','/kocp/user/content',1);
        }
    }
    
    
}
?>