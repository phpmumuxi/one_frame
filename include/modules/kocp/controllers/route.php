<?php
/**
 * 网站规则配置 - 控制器
 *
 * @Author Hardy
 */
class routeController extends KocpController {

    //初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb();
        $this->table = 'route';
        $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $this->kot = isset($_GET['kot']) ? intval($_GET['kot']) : 0;
    }
    
    function index() {
        $param['kot'] = $this->kot; $db_arr = array();
        $param['title'] = isset($_REQUEST['title']) ? trim($_REQUEST['title']) : '';        
        $s1 = 'select *'; $s2 = 'from {{'.$this->table.'}} where 1=1';
        if ($param['title'] != '') {
            $s2 .= ' and title like :title'; $db_arr[':title'] = '%'.$param['title'].'%';
        }
        $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $ko = new Public_Page($s1, $s2, $p, 20, $db_arr);
        $ko->url_tp = 5; $ko->pageUrl = '/kocp/route/index'; $ko->param = $param;
        $param['data_arr'] = $ko->getItems();
        $param['page_arr'] = $ko->getPageArr();
        $this->render('index', $param, 'cp_main');
    }
    
    function add() {
        $param['row'] = $this->db->fetchRow('select * from {{'.$this->table.'}} where id='.$this->id);
        if ($this->id>0 && empty($param['row'])) {
            showMsg('没有该规则，请核查');
        }
        if ($_POST) {
            $a['title'] = isset($_POST['title']) ? trim($_POST['title']) : '';
            $b['rule'] = isset($_POST['rule']) ? trim($_POST['rule']) : '';
            $c['module'] = isset($_POST['module']) ? trim($_POST['module']) : '';
            $c['controller'] = isset($_POST['controller']) ? trim($_POST['controller']) : '';
            $c['action'] = isset($_POST['action']) ? trim($_POST['action']) : '';
            $d['arr'] = isset($_POST['arr']) ? trim($_POST['arr']) : '';
            $data = array($b['rule'],$c,explode(',',$d['arr']));
            $a['route'] = serialize($data);
            $is_cz = $this->db->fetchCvn($this->table, array('id!'=>$this->id, 'title'=>$a['title']));
            if ($is_cz > 0) { showMsg('该规则标题已经存在了，请您换一个试试'); }
            if ($this->id > 0) {
                $this->db->update($this->table, $a, array('id'=>$this->id));
            } else {
                $this->db->insert($this->table, $a);
            }
            Sys::route_config(1);
            showMsg('操作成功', '/kocp/route/index', 1);
        }        
        $param['kot'] = $this->kot;
        $this->render('index', $param, 'cp_main');
    }
    
     //删除
    function del() {
        $this->db->query('delete from {{'.$this->table.'}} where id='.$this->id);
        Sys::route_config(1);
        showMsg('删除成功', '', 1);
    }
}

