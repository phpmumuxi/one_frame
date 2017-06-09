<?php
/**
 * 后台菜单 - 控制器
 *
 * @Author Hardy
 */
class menuController extends KocpController {

    //初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb(); $this->tn = 'backmenu';
        $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $this->kot = isset($_GET['kot']) ? intval($_GET['kot']) : 0;
        $tree = new Public_Tree( Dao_Site::get_backmenu_data(1) );
        $this->data_arr = $tree->get_tree( 0 );
    }

    //列表
    function lists() {
        $param['kot'] = $this->kot;
        $param['data_arr'] = $this->data_arr;        
        $this->render('lists', $param, 'cp_main');
    }

    //添加和编辑
    function add() {
        $param['row'] = $this->db->fetchRow('select * from {{'.$this->tn.'}} where id='.$this->id);
        if ($this->id>0 && empty($param['row'])) {
            showMsg('没有该菜单信息，请核查');
        }
        if ($_POST) {
            $a['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
            $a['url'] = isset($_POST['url']) ? trim($_POST['url']) : '';
            $a['parent_id'] = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
            $a['is_show'] = isset($_POST['is_show']) ? intval($_POST['is_show']) : 0;
            $a['sort'] = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
            if ($a['name'] == '') {
                showMsg('请填写菜单名称');
            }
            $is_cz = $this->db->fetchCvn($this->tn, array('id!'=>$this->id, 'name'=>$a['name']));
            if ($is_cz > 0) {
                showMsg('该菜单名称已经存在了，请您换一个');
            }
            if ($this->id > 0) {
                $this->db->update($this->tn, $a, array('id'=>$this->id));
            } else {
                $this->db->insert($this->tn, $a);
            }
            Dao_Site::get_backmenu_data(1, 1);
            showMsg('保存成功', '/kocp/menu/lists', 1);
        }
        $param['kot'] = $this->kot;
        $param['data_arr'] = $this->data_arr;
        $this->render('lists', $param, 'cp_main');
    }

    //删除
    function del() {
        if ($this->id < 20) {
            showMsg('数据为系统数据不能删除');
        }
        $this->db->query('delete from {{'.$this->tn.'}} where id='.$this->id);
        $this->db->query('delete from {{'.$this->tn.'}} where parent_id='.$this->id);
        Dao_Site::get_backmenu_data(1, 1); showMsg('删除成功', '', 1);
    }

}//end class