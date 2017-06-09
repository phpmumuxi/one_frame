<?php
/**
 * 广告 - 控制器管理
 *
 * @Author Hardy
 */
class adsController extends KocpController {

    //初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb();
    }  

    //列表
    function index() {        
        $param['t'] = $t = isset($_GET['t']) ? intval($_GET['t']) : 0;
        $param['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
        $db_arr = array(); $s1 = $s2 = '';
        
        if ((isset($_GET['ids']) && $_GET['ids']!='') || (isset($_POST['ids']) && @is_array($_POST['ids']) && !empty($_POST['ids']))) {
            $tn = 'ads_con';
            if ($t == 1) { 
                $tn = 'ads_cat';
            }
            @$ss = $_GET['ids']; if ($_POST['ids']) { $ss = implode(',', $_REQUEST['ids']); }
            if ($t == 0) {
                $delarr = $this->db->fetchAll('select img from {{ads_con}} where id in ('.$ss.')');
                if (!empty($delarr)) {
                    foreach ($delarr as $delv) {
                        Sys::file_unlink( $delv['img'] );
                    }
                }
            }
            $this->db->query('delete from {{'.$tn.'}} where id in ('.$ss.')');
            if ($t != 1) {                
                $cache = new Public_Cache('ads');
                $cache->clearAll();
            }
            showMsg('删除成功', '', 1);
        }
        
        if ($t == 1) {
            $s1 = 'select *'; $s2 = 'from {{ads_cat}} where 1=1';
            if ($param['name'] != '') {
                $s2 .= ' and name like :name'; $db_arr[':name'] = '%'.$param['name'].'%';
            }            
        } else {
            $s1 = 'select a.*,b.name cname';
            $s2 = 'from {{ads_con}} a left join {{ads_cat}} b on a.cat_id=b.id where 1=1';        
            if ($param['name'] != '') {
                $s2 .= ' and a.name like :name'; $db_arr[':name'] = '%'.$param['name'].'%';
            }
            $s2 .= ' order by a.sort asc';
        }
        
		$p = isset($_GET['p']) ? intval($_GET['p']) : 1;
		$ko = new Public_Page($s1, $s2, $p, 20, $db_arr);
		$param['data_arr'] = $ko->getItems();
		$param['page_arr'] = $ko->getPageArr();
        $this->render('index', $param, 'cp_main');
    }

    //添加和编辑
    function add() {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $param['t'] = $t = isset($_GET['t']) ? intval($_GET['t']) : 0;
        $tn = 'ads_con';
        if ($t == 1) { 
            $tn = 'ads_cat';
        }
        //查询信息
        $param['row'] = $this->db->fetchRow('select * from {{'.$tn.'}} where id=' . $id);
        if ($_POST) {
            $a['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
            if ($t == 1) {
                $a['width'] = isset($_POST['width']) ? intval($_POST['width']) : 0;
                $a['height'] = isset($_POST['height']) ? intval($_POST['height']) : 0;
            } else {
                $a['url'] = isset($_POST['url']) ? trim($_POST['url']) : '';
                $a['target'] = isset($_POST['target']) ? trim($_POST['target']) : '';
                $a['sort'] = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
                $a['cat_id'] = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;
                $a['is_huan'] = isset($_POST['is_huan']) ? intval($_POST['is_huan']) : 0;
            }
            if (($t==1 && $a['name'] == '') || ($t==0 && ($a['name']=='' || $a['cat_id']<1 || $a['url']==''))) {
                showMsg('请填写全信息，带*的为必填');
            }
            if ($t==0 && ($id<1 || !empty($_FILES['ad_pic']['name']))) {
                $cc = Public_Img::upload($_FILES['ad_pic'], 'ad_pic');
                if ($cc['err'] != 1) {
                    showMsg( $cc['err'] );
                } else {
                    $a['img'] = $cc['path'];
                    Sys::file_unlink( $param['row']['img'] );
                }
            }
            
            $is_cz = $this->db->fetchCvn($tn, array('id!'=>$id, 'name'=>$a['name']));
            if ($is_cz > 0) {
                showMsg('该广告'.($t==1 ? '位名称' : '标题').'已经存在了，请您换一个');
            }
            if ($id > 0) {
                $this->db->update($tn, $a, array('id' => $id));
                if ($t != 1) { //更新缓存
                    Dao_Ads::get_ads($param['row']['cat_id'], 0, 1); $a= Dao_Ads::get_ads($param['row']['cat_id'], 1, 1);
                }
            } else {
                $this->db->insert($tn, $a); $id = $this->db->getlastInsertId();
            }
            
            showMsg('保存成功', '/kocp/ads/index'.($t==1 ? '/t/1' : ''), 1);
        }
        if ($t == 0) {
            $param['cat_arr'] = Dao_Ads::getCatAll();
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
                case 'cat_name':
                    $a = $this->db->fetchCvn('ads_cat', array('id!'=>$d, 'name'=>$v));
                    if ($a < 1) {
                        $this->db->update('ads_cat', array('name' => $v), array('id' => $d));
                        exit('true');
                    }
                    break;
                case 'cat_width':
                    $this->db->update('ads_cat', array('width' => intval($v)), array('id' => $d));
                    exit('true');
                    break;
                case 'cat_height':
                    $this->db->update('ads_cat', array('height' => intval($v)), array('id' => $d));
                    exit('true');
                    break;
                case 'check_cat_name':
                    $a = $this->db->fetchCvn('ads_cat', array('id!'=>$d, 'name'=>$v));
                    if ($a < 1) {
                        exit('true');
                    }
                    break;
                case 'name':
                    $a = $this->db->fetchCvn('ads_con', array('id!'=>$d, 'name'=>$v));
                    if ($a < 1) {
                        $this->db->update('ads_con', array('name' => $v), array('id' => $d));
                        exit('true');
                    }
                    break;
                case 'sort':
                    $this->db->update('ads_con', array('sort' => intval($v)), array('id' => $d));
                    exit('true');
                    break;
                case 'check_name':
                    $a = $this->db->fetchCvn('ads_con', array('id!'=>$d, 'name'=>$v));
                    if ($a < 1) {
                        exit('true');
                    }
                    break;
            }
        }
        exit('false');
    }

}//end class