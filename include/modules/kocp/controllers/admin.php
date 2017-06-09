<?php
/**
 * 管理员控制器管理
 *
 * @Author Hardy
 */
class adminController extends KocpController {

    //初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb();
    }  

    //管理员
    function index() {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $param['kot'] = isset($_REQUEST['kot']) ? intval($_REQUEST['kot']) : 0;
        $param['user'] = $a['users'] = isset($_REQUEST['name']) ? trim($_REQUEST['name']) : '';
        $param['nick'] = $a['nick'] = isset($_REQUEST['nick']) ? trim($_REQUEST['nick']) : '';
        $param['email'] = $a['email'] = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
        $param['status'] = $a['status'] = isset($_REQUEST['status']) ? intval($_REQUEST['status']) : 0;
        if ($param['kot']==1 || $param['kot']==3) { //查询
            if ($param['kot']==1) {
                if ($id > 0) {
                    Dao_Base::ko_is_perm( 33,$_SESSION['ko_htuser_info']['id'] ); //判断是否有权限
                } else {
                    Dao_Base::ko_is_perm( 36,$_SESSION['ko_htuser_info']['id'] ); //判断是否有权限
                }
            }
            $param['row'] = $this->db->fetchRow('select * from {{manager}} where id='.$id);
            if ($id>0 && empty($param['row'])) {
                showMsg('该管理员不存在，请核查');
            }
            if ($param['kot']==3) {
//                if ($id == 1) {
//                    showMsg('当前用户已是最高权限，不能更改');
//                }
                Dao_Base::ko_is_perm( 35,$_SESSION['ko_htuser_info']['id'] ); //判断是否有权限
                $param['manager'] = $this->db->fetchAll('select id,users,uids,nick from {{manager}}');
                if ($_POST) {
                    $jsa['uids'] = isset($_POST['uids']) ? implode(',', $_POST['uids']) : ''; //用户权限
                    $jsa['mids'] = isset($_POST['mids']) ? implode(',', $_POST['mids']) : ''; //菜单权限
                    $jsa['bms'] = isset($_POST['bms']) ? implode(',', $_POST['bms']) : '';//部门权限
                    $this->db->update('manager', $jsa, array('id'=>$id));
                    $cache = new Public_Cache('ko_prem'); $cache->clearAll(); //清空缓存                    
                    showMsg('设置用户权限成功', '/kocp/admin/index', 1);
                }
            }
            if ($param['kot']==1 && $_POST) {
                $p = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';                
                if ($a['users']=='' || $a['nick']=='') {
                    showMsg('请填写用户名，笔名');
                }
                if ($id<1 && $p=='') {
                    showMsg('请填写登录密码');
                }
                $is_cz = $this->db->fetchCvn('manager', array('id!'=>$id, 'users'=>$a['users']));
                if ($is_cz > 0) {
                    showMsg('该用户名已经存在了，请您换一个试试');
                }
                $is_cz = $this->db->fetchCvn('manager', array('id!'=>$id, 'nick'=>$a['nick']));
                if ($is_cz > 0) {
                    showMsg('该笔名已经存在了，请您换一个试试');
                }
                if ($p != '') {
                    $a['passwd'] = Sys::pwd_key($a['users'], $p, 1);
                }
                if ($id == 1) {
                    unset($a['status']);
                }
                if ($id > 0) {
                    unset($a['users']); $this->db->update('manager', $a, array('id'=>$id));
                } else {
                    $this->db->insert('manager', $a);
                    $this->db->update('manager',array('uids'=>$this->db->getlastInsertId()),array('id'=>$this->db->getlastInsertId()));
                }
                showMsg('操作成功', '/kocp/admin/index', 1);
            }
        } elseif ($param['kot'] == 2) { //删除会员
            Dao_Base::ko_is_perm( 34,$_SESSION['ko_htuser_info']['id'] ); //判断是否有权限
            if ($id < 1) {
                showMsg('请选择要删除的选项');
            }
            if ($id == 1) {
                showMsg('该管理员为系统数据不能删除');
            }
            $this->db->query('delete from {{manager}} where id='.$id);
            showMsg('删除成功', '', 1);
        } elseif ($param['kot'] == 0) {
            $db_arr = array(); $s1 = 'select *'; $s2 = 'from {{manager}} where 1=1';
            if ($param['user'] != '') {
                $s2 .= ' and users like :uu'; $db_arr[':uu'] = '%'.$param['user'].'%';
            }
            if ($param['nick'] != '') {
                $s2 .= ' and nick like :nick'; $db_arr[':nick'] = '%'.$param['nick'].'%';
            }
            if ($param['status'] == 1) { $s2 .= ' and status=1'; }
            if ($param['status'] == 2) { $s2 .= ' and status=2'; }
            $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
            $ko = new Public_Page($s1, $s2, $p, 30, $db_arr);
            $param['data_arr'] = $ko->getItems();
            $param['page_arr'] = $ko->getPageArr();
        }
        $this->render('index', $param, 'cp_main');
    }


}//end class