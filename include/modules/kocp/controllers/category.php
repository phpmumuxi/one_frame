<?php
/**
 * 后台 - 实验室管理 产品分类
 *
 * @Author wyl
 */
class categoryController extends KocpController {

	//初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb();
    }
     //产品分类
    public function index() {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $param['kot'] = isset($_REQUEST['kot']) ? intval($_REQUEST['kot']) : 0;        
        if ($param['kot'] == 1) { //查询分类信息
            $param['row'] = $this->db->fetchRow('select * from {{category}} where id='.$id);           
            if ($id>0 && empty($param['row'])) {
                showMsg('不存在该栏目分类');
            }
            if ($_POST) { //保存添加和编辑
                $a['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
                $a['type'] = !empty($_POST['type']) ? trim($_POST['type']) : 1;
                $a['parent_id'] = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
                if ($a['name'] == '') { showMsg('请填写分类名称'); } 
                
                // $is_cz = $this->db->fetchCvn('category', array('id!'=>$id,'name'=>$a['name']));                
                // if ($is_cz > 0) {
                //     showMsg('该栏目分类已经存在了，请您换一个');
                // }   
                
                if ($id > 0) {
                    $this->db->update('category', $a, array('id'=>$id));
                } else {
                    $this->db->insert('category', $a);
                }
                showMsg('操作成功', '/kocp/category/index', 1);
            }
        } elseif ($param['kot'] == 2) { //删除栏目分类
            if ($id < 1) {
                showMsg('请选择要删除的选项');
            }
            if(!empty($id)&&$id>0){
                $data=$this->db->fetchAll('select * from {{category}}');
                $tree = new Public_Tree($data);
                $carr = $tree->get_tree($id);
                if(empty($carr)){
                    $arr['child_ids']=$id;
                }else{
                    $arr['child_ids']='';
                    foreach ($carr as $key => $value) {
                        $arr['child_ids'].=$value['id'].',';
                    }
                    $arr['child_ids'].=$id;
                }
            }            
            $this->db->query('delete from {{category}} where id in ('.$arr['child_ids'].')');
            showMsg('删除成功', '', 1);
        }
        //获取栏目分类
        $data=$this->db->fetchAll('select * from {{category}}');
        $tree = new Public_Tree($data);
        $param['data_arr'] = $tree->get_tree( 0 ); 
        $this->render('index', $param, 'cp_main');
    }
}