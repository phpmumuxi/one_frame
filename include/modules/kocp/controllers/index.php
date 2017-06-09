<?php

	/**
	 * 后台 - 入口控制器
	 *
	 * @Author Hardy
	 */

	class indexController extends KocpController {

		//后台首页
		function index() {

			$a1 = Dao_Site::get_backmenu_data(2, 0); //获取后台菜单
			$param['content_1'] = $param['content_3'] = ''; $param['content_2'] = '<ul>';
	        if(empty($_SESSION['ko_htuser_info']['mids'])) {

	            $aaa = array();
	        }else{
	            $aaa = explode(',',$_SESSION['ko_htuser_info']['mids']);
	        }

			foreach ($a1 as $k1 => $v1) {

	            if ($v1['is_show']==1 && (in_array($v1['id'],$aaa ) || $_SESSION['ko_htuser_info']['id'] == 1) ) {
	                $param['content_2'] .= '<li><a class="link" id="ko_nav_'.$k1.'" onclick="ko_open_Item(1, '.$k1.', 0);" href="javascript:;"><span>'.$v1['name'].'</span></a></li>';
	                $param['content_1'] .= '<dl><dt>'.$v1['name'].'</dt>';
	                $param['content_3'] .= '<ul id="ko_sort_'.$k1.'"><li><dl><dd><ol>';
	                $a2 = Dao_Site::get_backmenu_data(2, $v1['id']);
	                if (!empty($a2)) { 

	                    foreach ($a2 as $k2 => $v2) {

	                        if ($v2['is_show']==1 && (in_array($v2['id'],$aaa) || $_SESSION['ko_htuser_info']['id'] == 1)) {

	                            $param['content_1'] .= '<dd><a onclick="ko_open_Item(2, '.$k1.', '.$k2.');" href="javascript:;">'.$v2['name'].'</a></dd>';
	                            $param['content_3'] .= '<li><a href="javascript:;" id="ko_item_'.$k1.$k2.'" onclick="ko_open_Item(2, '.$k1.', '.$k2.');" url="'.$v2['url'].'">'.$v2['name'].'</a></li>';
	                        }
	                    }
	                }
	                $param['content_1'] .= '</dl>';
	                $param['content_3'] .= '</ol></dd></dl></li></ul>';
	            }
	        }
			$param['content_2'] .= '</ul>'; $this->render('index', $param);
		}

		//清除所有缓存
		function clearcache() {        

	        Dao_Site::clearCacheAll();
	        showMsg('更新缓存成功', '', 1);
		}

		//欢迎页面
		function welcome() {

			$db = Sys::getdb();
			$param['sql_version'] = $db->fetchOne('select VERSION()'); //数据库版本
			$this->render('welcome', $param, 'cp_main');
		}

		//系统介绍
		function about() {

			$this->render('about', array(), 'cp_main');

		}

		//修改密码
		function pwd() {

			if ($_POST) {

				$p = isset($_POST['old_pw']) ? trim($_POST['old_pw']) : '';
				$p1 = isset($_POST['new_pw']) ? trim($_POST['new_pw']) : '';
				$p2 = isset($_POST['new_pw2']) ? trim($_POST['new_pw2']) : '';
				if ($p=='' || $p1=='' || $p2=='') { showMsg('请输入原密码，新密码和确认密码'); }
				if ($p2 != $p1) { showMsg('两次输入的密码不一致，请重新输入'); }
				$db = Sys::getdb(); $u = $_SESSION['ko_htuser_info']['users'];
	            $mid = $_SESSION['ko_htuser_info']['id']; $p = Sys::pwd_key($u, $p, 1);
	            $old = $db->fetchOne('select passwd from {{manager}} where id='.$mid);
				if ($p != $old) { showMsg('原密码输入错误'); }
				$db->update('manager', array('passwd'=>Sys::pwd_key($u, $p1, 1)), array('id'=>$mid));
				showMsg('密码修改成功', '', 1);
			}

			$this->render('pwd', array(), 'cp_main');
		}

		//登录系统 
		function login() {

			if (isset($_SESSION['ko_htuser_info'])) { tiao_goto('/kocp/index'); } //已登录跳转到首页
			if ($_POST && isset($_SESSION['ko_login'])) {

				//检测是否非法登录
				$ko_hash = isset($_POST[$_SESSION['ko_login']['ko_n1']]) ? trim($_POST[$_SESSION['ko_login']['ko_n1']]) : '';
				if ($ko_hash=='' || !isset($_SESSION['ko_login']['ko_v1']) || $ko_hash!=$_SESSION['ko_login']['ko_v1']) {

					unset($_SESSION['ko_login']['ko_v1']); showMsg('请使用正确方法登录管理中心');
				}
				unset($_SESSION['ko_login']['ko_v1']);

	            //用户判断
				$a[':u'] = isset($_POST[$_SESSION['ko_login']['ko_n2']]) ? trim($_POST[$_SESSION['ko_login']['ko_n2']]) : '';
				$p = isset($_POST[$_SESSION['ko_login']['ko_n3']]) ? trim($_POST[$_SESSION['ko_login']['ko_n3']]) : '';
				$c = isset($_POST[$_SESSION['ko_login']['ko_n4']]) ? trim($_POST[$_SESSION['ko_login']['ko_n4']]) : '';
				if ($a[':u']=='' || $p=='' || $c=='') { showMsg('请输入用户名，密码和验证码'); }
	            $c_msg = Dao_Site::check_yzm( $c ); if ($c_msg != 1) { showMsg( $c_msg ); }
				$db = Sys::getdb(); Sys::session('ko_captcha', '___clear'); //清空验证码
				$r = $db->fetchRow('select * from {{manager}} where users=:u', $a);
				if (empty($r)) { showMsg('该管理员不存在'); }
				$id = intval($r['id']); $n1 = 5; $n2 = intval($r['err_num']);
				if (date('Y-m-d', $r['err_at'])==date('Y-m-d') && $n2>=$n1) {

					showMsg('今天已经没有机会尝试登录了，请明天继续');
				}

				$p = Sys::pwd_key($r['users'], $p, 1);//加密密码
	            $last_at = time();
	            $ip = Public_Http::get_client_ip();

				if ($p != $r['passwd']) {

					$db->query('update {{manager}} set err_num=err_num+1,err_at='.time().' where id='.$id);
					showMsg('管理员密码输入错误，您还有'.($n1-$n2-1).'次尝试机会');
				}

				$db->query('update {{manager}} set err_num=0,err_at=0 where id='.$id);
				if ($r['status'] == 2) { showMsg('该管理员当前已冻结，暂不能登录'); }

				unset( $r['passwd'] ); //清空登录密码
				unset( $_SESSION['ko_login'] ); //清空登录表单
	            $r['login_num'] += 1; $r['last_at'] = $last_at; $r['last_ip'] = $ip;
				$_SESSION['ko_htuser_info'] = $r; //保存已登录用户信息

				//修改登录后信息
				$m1 = array(				

					'last_at'   => $last_at,
					'last_ip'   => $ip,
					'login_num' => $r['login_num'],
				);

				$m2 = array(

					'id' => $id,
				);

				$db->update('manager', $m1, $m2);
				tiao_goto('/kocp/index');
			}

	        $_SESSION['ko_login']['ko_n1'] = 'ko_hash_' . mt_rand(0, 10000);
	        $_SESSION['ko_login']['ko_v1'] = Sys::make_chars(15);
	        $_SESSION['ko_login']['ko_n2'] = 'ko_user_' . mt_rand(0, 10000);
	        $_SESSION['ko_login']['ko_n3'] = 'ko_pwd_' . mt_rand(0, 10000);
	        $_SESSION['ko_login']['ko_n4'] = 'ko_yzm_' . mt_rand(0, 10000);

	        $this->render('login');
		}

		//退出后台管理系统
		function logout() {

	        Sys::session('ko_captcha', '___clear'); //清空验证码
			$_SESSION['ko_login'] = ''; unset( $_SESSION['ko_login'] );
			$_SESSION['ko_htuser_info'] = ''; unset( $_SESSION['ko_htuser_info'] );
			tiao_goto('/kocp/index/login');
		}

	} //end class