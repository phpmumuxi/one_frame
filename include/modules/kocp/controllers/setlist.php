<?php
/**
 * 网站设置分类列表 - 控制器
 *
 * @Author Hardy
 */
class setlistController extends KocpController {
    
    //初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb();
    }

    //站点设置
    function pub() {
        $param['lx_arr'] = Dao_Site::get_set_cat_data();
        $param['kot'] = isset($_REQUEST['kot']) ? intval($_REQUEST['kot']) : 0;
        $param['vtype'] = $a['cid'] = isset($_REQUEST['vtype']) ? intval($_REQUEST['vtype']) : 0; $tz_url = '';
		if ($_POST) {
            if ($param['kot'] == 0) {
                $a['code'] = isset($_POST['code']) ? trim($_POST['code']) : ''; $a['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
                $a['value'] = isset($_POST['value']) ? trim($_POST['value']) : ''; $a['lx'] = isset($_POST['vlx']) ? intval($_POST['vlx']) : 0;
                $a['sort'] = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
                if ($a['code'] == '') {
                    showMsg('变量代码不能为空且必须是唯一');
                }
                if ($a['cid']<1) {
                    showMsg('请选择所属组');
                }
                $is_cz = $this->db->fetchCvn('configs', array('code'=>$a['code']));
                if ($is_cz > 0) {
                    showMsg('该变量代码已经存在了，请您换一个');
                }
                $this->db->insert('configs', $a); $tz_url = '/kocp/setlist/pub/kot/'.$a['cid'];
            } else {
                unset( $_POST['textfield'] ); $a = isset($_POST['code']) ? $_POST['code'] : array();
                foreach ($a as $v) {
                    $b = array(); $lx = isset($_POST[$v.'_lx']) ? intval($_POST[$v.'_lx']) : 0;
                    $b['name'] = isset($_POST[$v.'_name']) ? trim($_POST[$v.'_name']) : '';
                    $b['sort'] = isset($_POST[$v.'_sort']) ? intval($_POST[$v.'_sort']) : 0;
                    if ($lx == 4) {
                        $ua = Public_Img::upload($_FILES[$v.'_value'], 'system');
                        if ($ua['err'] == 1) {
                            $b['value'] = $ua['path']; $oa = Dao_Site::ko_get_configs(2, $v);
                            if ($oa) {
                                Sys::file_unlink( $oa['value'] );
                            }
                        }
                    } else {
                        $b['value'] = isset($_POST[$v.'_value']) ? trim($_POST[$v.'_value']) : '';
                    }
                    $this->db->update('configs', $b, array('code'=>$v));
                }
            }
            Dao_Site::ko_get_configs( 1 ); //更新缓存
            Dao_Site::ko_get_configs( 3, 1 ); //更新缓存
            showMsg('保存成功', $tz_url, 1);
		}
        $a = Dao_Site::ko_get_configs(); $param ['data_arr'] = array();
        if (!empty($a)) {
            foreach ($a as $v) {
                if ($v['cid'] == $param ['kot']) {
                    $param ['data_arr'][] = $v;
                }
            }
        }
		$this->render('pub', $param, 'cp_main');
    }


} //end class