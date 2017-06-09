<?php
/** 
 * 网站工具 - 控制器
 *
 * @Author  Hardy
 */
class toolController extends FrontController
{
    //显示验证码
    function yzm()
    {
        $y = new Public_Captcha();
        $y->num = isset($_GET['n']) ? intval($_GET['n']) : 0;
        $y->width = isset($_GET['w']) ? intval($_GET['w']) : 0;
        $y->height = isset($_GET['h']) ? intval($_GET['h']) : 0;
        $y->fontsize = isset($_GET['s']) ? intval($_GET['s']) : 0;
        $y->doimg();
    }
    //获取期刊评论
    function show_comment()
    {
        $t = isset($_GET['t']) ? intval($_GET['t']) : 1;
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $p = isset($_GET['p']) ? $_GET['p'] : '';
        if ($t == 1) {
            $n = isset($_GET['n']) ? trim($_GET['n']) : '';
            $c = isset($_GET['c']) ? trim($_GET['c']) : '';
            $yc = Dao_Site::check_yzm($c);
            if ($p == '') {
                exit('请填写要发表的内容');
            }
            if ($yc != 1) {
                exit($yc);
            }
            $db = Sys::getdb();
            $is_cz = $db->fetchCvn('art_con', array('id' => $id, 'lx_id' => 2));
            if ($is_cz < 1) {
                exit('不存在该期刊');
            }
            $a = array('art_id' => $id, 'name' => $n ? $n : '匿名', 'content' => $p, 'add_at' => time());
            $db->insert('art_comment', $a);
            echo 1;
        } else {
            echo Dao_Base::getComment($id, intval($p));
        }
        exit;
    }
    //kindeditor编辑器上传图片
    function keupload()
    {
        $save_path = KO_UPLOAD_PATH . '/keditor/';
        //文件保存目录路径
        $save_url = str_replace(KO_ROOT_PATH, '', $save_path);
        //文件保存目录URL
        $ext_arr = array('gif', 'jpg', 'jpeg', 'png');
        //定义允许上传的文件扩展名
        $max_size = 2;
        //最大文件大小，单位M
        $arr = array('error' => 1, 'message' => '请选择要上传的图片。');
        if (empty($_FILES) === false) {
            $file_name = $_FILES['imgFile']['name'];
            $tmp_name = $_FILES['imgFile']['tmp_name'];
            $file_size = $_FILES['imgFile']['size'];
            Sys::create_dir($save_path);
            //创建目录
            if (!$file_name) {
                //检查文件名
                $arr['message'] = '请选择要上传的图片。';
            } elseif (@is_dir($save_path) === false) {
                //检查目录
                $arr['message'] = '上传目录不存在。';
            } elseif (@is_writable($save_path) === false) {
                //检查目录写权限
                $arr['message'] = '上传目录没有写权限。';
            } elseif (@is_uploaded_file($tmp_name) === false) {
                //检查是否已上传
                $arr['message'] = '上传失败。';
            } elseif ($file_size > $max_size * 1048576) {
                //检查文件大小
                $arr['message'] = '上传文件大小超过(' . $max_size . 'M)限制。';
            } else {
                //获得文件扩展名
                $temp_arr = explode('.', $file_name);
                $file_ext = array_pop($temp_arr);
                $file_ext = trim($file_ext);
                $file_ext = strtolower($file_ext);
                if (@in_array($file_ext, $ext_arr) === false) {
                    //检查扩展名
                    $arr['message'] = "上传文件扩展名是不允许的扩展名。\n只允许" . implode(',', $ext_arr) . '格式。';
                } else {
                    //新文件名
                    $new_file_name = mt_rand(10000, 9999999) . time() . '.' . $file_ext;
                    //移动文件
                    $file_path = $save_path . $new_file_name;
                    if (@move_uploaded_file($tmp_name, $file_path) === false) {
                        $arr['message'] = '上传文件失败。';
                    } else {
                        $arr['error'] = 0;
                        $arr['url'] = $save_url . $new_file_name;
                    }
                }
            }
        }
        header('Content-type: text/html; charset=UTF-8');
        exit(json_encode($arr));
    }
    
    function check(){        
        if(strpos($_POST['subs_user'], 'user')){
            $db = Sys::getdb();
            $a['lab_name']=isset($_POST['lab_name'])?trim($_POST['lab_name']):'';
            $a['name']=isset($_POST['name'])?trim($_POST['name']):'';
            $a['email']=isset($_POST['email'])?trim($_POST['email']):'';  
            $a['tel']=isset($_POST['tel'])?trim($_POST['tel']):''; 
            $a['qq']=isset($_POST['qq'])?trim($_POST['qq']):''; 
            $a['des']=isset($_POST['des'])?trim($_POST['des']):''; 
            $a['time']=time();
            if(empty($a['lab_name'])){ showMsg('请填实验名称');}
            if(empty($a['name'])){ showMsg('请填写姓名');}
            if(empty($a['name'])){ showMsg('请填写电子邮件');}
            if(empty($a['tel'])){ showMsg('请填写联系电话');} 
            print_r($a);die;
                if($db->insert('line_price',$a) && empty($n)){
                    showMsg('恭喜，已收录信息','',1);
                }else{
                    showMsg('信息没有收录成功，请重试');
                }
        }else{
           showMsg('请用正确方式提交数据');
        }
        
    }
    public function add() {
        $db = Sys::getdb();
        $this->table = 'question';
        $param['question'] = strip_tags($_POST['txt_doubt']);
        if(empty($param['question'])){ showMsg('请填写你的疑问');}
        $param['time'] = time(); 
        $param['type_id'] = 0; 
        $param['status'] = 0;    
        if(strpos($_POST['question'], 'question')){           
            if($db->insert($this->table,$param)){;
               showMsg('工作人员最短时间会为你解答！','', 1);
           }else{
               showMsg('问题提交失败！请重试');
           }
        }
    }
   
}
//end class