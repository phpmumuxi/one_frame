<?php
/**
 * 友情链接 - 控制器
 *
 * @Author Hardy
 */
class linkController extends KocpController {

    //初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb();
    }  

    //列表
    function index() {
        if (isset($_POST['ids'])) {
            Dao_Base::ko_controller_perm( 218 ); //判断是否有权限
            if (!is_array($_POST['ids']) || empty($_POST['ids'])) {
                showMsg('请选择要删除的选项');
            }
            foreach ($_POST['ids'] as $v) {
                $cid = intval($v);
                $pic = $this->db->fetchOne('select pic from {{link}} where id='.$cid);
                Sys::file_unlink( $pic );
                $this->db->delete('link', array('id' => $cid));
            }
            showMsg('删除成功');
        }
        Dao_Base::ko_controller_perm( 215 ); //判断是否有权限
        $param['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
        $param['t'] = isset($_GET['t']) ? intval($_GET['t']) : 0;
        $param['isshow'] = isset($_POST['isshow']) ? intval($_POST['isshow']) : 0;
		$s1 = 'select a.*'; $s2 = 'from {{link}} a where 1=1';
        $db_arr = array();
        if ($param['name'] != '') {
            $s2 .= ' and a.title like :name'; $db_arr[':name'] = '%'.$param['name'].'%';
        }
        if ($param['t'] == 1) { $s2 .= ' and a.pic!=""'; }
        if ($param['t'] == 2) { $s2 .= ' and LENGTH(a.pic)=0'; }
        if ($param['isshow'] == 1) { $s2 .= ' and a.isshow=1'; }
        if ($param['isshow'] == 2) { $s2 .= ' and a.isshow=0'; }
        $s2 .= ' order by a.sort asc';
		$p = isset($_GET['p']) ? intval($_GET['p']) : 1;
		$ko = new Public_Page($s1, $s2, $p, 20, $db_arr);
		$param['data_arr'] = $ko->getItems();
		$param['page_arr'] = $ko->getPageArr();
        $this->render('index', $param, 'cp_main');
    }

    //添加和编辑友情链接
    function add() {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $t = isset($_GET['t']) ? intval($_GET['t']) : 0;
        //查询信息
        $param['row'] = $this->db->fetchRow('select * from {{link}} where id='.$id);
        if ($t == 1) { //删除
            Dao_Base::ko_controller_perm( 218 ); //判断是否有权限
            Sys::file_unlink( $param['row']['pic'] );
            $this->db->delete('link', array('id' => $id));
            showMsg('删除成功', '' , 1);
        }
        if ($id > 0) {
            Dao_Base::ko_controller_perm( 217 ); //判断是否有权限
        } else {
            Dao_Base::ko_controller_perm( 216 ); //判断是否有权限
        }
        if ($_POST) {
            $a['title'] = isset($_POST['name']) ? trim($_POST['name']) : '';
            $a['url'] = isset($_POST['url']) ? trim($_POST['url']) : '';
            $a['isshow'] = isset($_POST['isshow']) ? intval($_POST['isshow']) : 0;
            $a['sort'] = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
            if ($a['title'] == '' || $a['url'] == '') {
                showMsg('请填写友情链接标题和地址信息');
            }
            $is_cz = $this->db->fetchCvn('link', array('id!'=>$id, 'title'=>$a['title']));
            if ($is_cz > 0) {
                showMsg('该友情链接标题已经存在了，请您换一个');
            }
            $cc = Public_Img::upload($_FILES['link_pic'], 'link');
            if ($cc['err'] == 1) {
                $a['pic'] = $cc['path'];
                Sys::file_unlink( $param['row']['pic'] );
            }
            if ($id > 0) {
                $this->db->update('link', $a, array('id' => $id));
            } else {
                $this->db->insert('link', $a);            
            }
            showMsg('保存成功', '/kocp/link/index', 1);
        }
        $this->render('add', $param, 'cp_main');
    }

    /**
     * ajax操作
     * @param $d 修改内容索引标识
     * @param $c 修改字段名
     * @param $v 修改内容
     * @return 返回true表示成功，false表示不成功
     * 
     * @Author Hardy
     */
    function koajax() {
        $d = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $c = isset($_POST['column']) ? trim($_POST['column']) : '';
        $v = isset($_POST['value']) ? trim($_POST['value']) : '';
        if ($c != '') {
            switch ($c) {
                case 'title':
                    $a = $this->db->fetchCvn('link', array('id!'=>$d, 'title'=>$v));
                    if ($a < 1) {
                        $this->db->update('link', array('title' => $v), array('id' => $d));
                        exit('true');
                    }
                    break;
                case 'isshow':
                    $this->db->update('link', array('isshow' => intval($v)), array('id' => $d));
                    exit('true');
                    break;
                case 'sort':
                    $this->db->update('link', array('sort' => intval($v)), array('id' => $d));
                    exit('true');
                    break;
                case 'check_title':
                    $a = $this->db->fetchCvn('link', array('id!'=>$d, 'title'=>$v));
                    if ($a < 1) {
                        exit('true');
                    }
                    break;
            }
        }
        exit('false');
    }

}//end class