<?php
/**
 * 后台 - 实验室管理 产品
 *
 * @Author wyl
 */
class productController extends KocpController {

	//初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb();
    }
     //产品
    public function index() {        
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $param['kot'] = isset($_REQUEST['kot']) ? intval($_REQUEST['kot']) : 0;
        if ($param['kot'] == 1) { //查询分类信息
            $param['row'] = $this->db->fetchRow('select * from {{product}} where id='.$id);
            $param['category_arr']=$this->db->fetchAll('select * from {{category}} where parent_id = 0 and type = 1'); 
            if ($id>0 && empty($param['row'])) {
                showMsg('不存在该产品');
            }
            if ($_POST) { //保存添加和编辑                 
                $a['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
                $a['is_tui'] = !empty($_POST['is_tui']) ? intval(trim($_POST['is_tui'])) : 0;
                $a['lab_about'] = isset($_POST['lab_about']) ? trim($_POST['lab_about']) : '';
                $a['lab_member'] = isset($_POST['lab_member']) ? trim($_POST['lab_member']) : '';
                $a['lab_name'] = isset($_POST['lab_name']) ? trim($_POST['lab_name']) : '';
                $a['content'] = isset($_POST['content']) ? $_POST['content'] : '';
                $a['lab_demo'] = isset($_POST['lab_demo']) ? $_POST['lab_demo'] : '';
                $a['parent_id'] = !empty($_POST['parent_id']) ? intval(trim($_POST['parent_id'])) : 0; 
                if (empty($_POST['parent_id']) || $_POST['parent_id']==''){
                     showMsg('请选择产品分类级别');
                }                             
                if(!empty($_FILES['fileimg']['name'])){
		           $img=$this->db->fetchRow('select img from {{product}} where id='.$id);                   
                    if(!empty($img)){
                       Sys::file_unlink($img['img'] ); //删除物理图片路径
                    }
                    $d = Public_Img::upload($_FILES['fileimg'],'p_img');
                    $a['img'] = $d['path'];
                }                
                //print_r($a);die;
                if ($a['name'] == '') { showMsg('请填写产品名称'); }                          
                if ($id > 0) {
                    $this->db->update('product', $a, array('id'=>$id));
                } else {
                    $this->db->insert('product', $a);
                }
                showMsg('操作成功', '/kocp/product/index', 1);
            }
        } elseif ($param['kot'] == 2) { //删除
            if ($id > 0) {            
                $data = $this->db->fetchRow('select img from {{product}} where id='.$id);
                Sys::file_unlink($data['img'] ); //删除物理图片路径                                                 
                $this->db->query('delete from {{product}} where id='.$id);
                showMsg('删除成功', '/kocp/product/index', 1);
            }
        }  
        $param['data_arr']=$this->db->fetchAll('select * from {{product}}');
        $this->render('index', $param, 'cp_main');
    }
}