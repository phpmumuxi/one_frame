<?php
/**
 * 微信运营绩效统计
 *
 * @Author Hardy
 */
class wxController extends KocpController {
    //初始化
    function __construct() {
        parent::__construct(); //执行父类方法
        $this->db = Sys::getdb();
        $this->id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $this->kot = isset($_REQUEST['kot']) ? intval($_REQUEST['kot']) : 0;
        $this->table = 'wx';
    }
    //微信运营考核
    function index() {
        $param['kot'] = $this->kot;
        $db_arr = array();
        if ($param['kot'] == 1) {
            $param['row'] = $this->db->fetchRow('select *,a.id as did from {{' . $this->table . '}} a left join {{wxyy}} b on a.uid = b.id where a.id=' . $this->id);
            if ($this->id > 0 && empty($param['row'])) {
                showMsg('不存在该客户');
            }
            if ($_POST) {                
                //客户基础信息
                $a['uid'] = !empty($_POST['uid']) ? $_POST['uid'] : 0;
                $a['date'] = !empty($_POST['date']) ? trim($_POST['date']) : '';
                $a['num1'] = !empty($_POST['num1']) ? $_POST['num1'] : 0;
                $a['num2'] = !empty($_POST['num2']) ? $_POST['num2'] : 0;
                $a['num3'] = !empty($_POST['num3']) ? $_POST['num3'] : 0;
                $a['num4'] = !empty($_POST['num4']) ? $_POST['num4'] : 0;
                $a['status'] = !empty($_POST['status']) ? intval($_POST['status']) : 0;
                $a['status_d'] = !empty($_POST['status_d']) ? intval($_POST['status_d']) : 0;

                if ($a['num1'] > 0) {   
                    $sums =$this->leJuan($a['uid'],$a['date']);
                    if($sums>=5){
                        //$a['score1'] = intval($a['num1']+$sums-5)*10;
                        $a['score1'] = intval($a['num1'])*10;
                    }elseif ($sums==4) {
                        if($a['num1']==1){
                            $a['score1']=0;
                        }else{
                            $a['score1']=($a['num1']-1)*10;
                        }
                    }elseif ($sums==3) {
                        if($a['num1']<=2){
                            $a['score1']=0;
                        }else{
                            $a['score1']=($a['num1']-2)*10;
                        }
                    }elseif ($sums==2) {
                        if($a['num1']<=3){
                            $a['score1']=0;
                        }else{
                            $a['score1']=($a['num1']-3)*10;
                        }
                    }elseif ($sums==1) {
                        if($a['num1']<=4){
                            $a['score1']=0;
                        }else{
                            $a['score1']=($a['num1']-4)*10;
                        }
                    }elseif ($sums==0) {
                        if($a['num1']<=5){
                            $a['score1']=0;
                        }else{
                            $a['score1']=($a['num1']-5)*10;
                        }
                    }
                }else{
                    $a['score1'] = 0;
                }
                
                if($a['num2'] == 0 ){
                    $a['score2'] = -2;
                }elseif($a['num2']>0 && $a['num2']<3){
                    $a['score2'] = $a['num2'] * 2;
                }else{
                    $a['score2'] =4;
                }
    
                if ($a['num3'] > 0){
                    $sum = $this->feedBack($a['uid'],$a['date']);
                    if($sum>=3){
                        $a['score3']=0;                        
                    }elseif ($sum == 0 ){
                        if($a['num3']<=3){
                            $a['score3']=intval($a['num3'])*5;
                        }else{
                            $a['score3']=15;
                        }
                    }elseif($sum == 1 ){
                        if($a['num3']<=2){
                            $a['score3']=intval($a['num3'])*5;
                        }else{
                            $a['score3']=10;
                        }
                    }elseif($sum == 2 ){                   
                            $a['score3']=5;
                    }
                }else{
                    $a['score3'] = 0;
                }
                
                if($a['num4']>0){
                    $_num = $this->qkWeek($a['uid'],$a['date']);
                    if($_num>=4){
                        //$a['score4'] =40 -($a['num4']+$_num)*5;
                        $a['score4'] = -($a['num4']*5);
                    }elseif($_num==3){
                        if($a['num4']==1){
                            $a['score4'] =5;
                        }else{
                            $a['score4'] = -(($a['num4']-1)*5);
                        }
                    }elseif($_num==2){
                        if($a['num4']<=2){
                            $a['score4'] =$a['num4']*5;
                        }else{
                            $a['score4'] = 20-($a['num4']*5);
                        }
                    }elseif($_num==1){
                        if($a['num4']<=3){
                            $a['score4'] =$a['num4']*5;
                        }else{
                            $a['score4'] = 30-($a['num4']*5);
                        }
                    }elseif($_num==0){
                        if($a['num4']<=4){
                            $a['score4'] =$a['num4']*5;
                        }else{
                            $a['score4'] = 40-($a['num4']*5);
                        }
                    }
                }else{
                    $a['score4'] = 0;
                }
               
                if($a['status']){
                   if($a['score2']>0) $a['score2'] = 0;
                   if($a['score3']>0) $a['score3'] = 0;
                   if($a['score4']>0) $a['score4'] = 0;
                   $a['score5'] = -10;
                }else{
                    $a['score5'] = 0;
                }
                
                if ($a['status_d']) {
                    $a['score6'] = -20;
                }else{
                    $a['score6'] = 0;
                }
                
                if (empty($a['uid'])) {
                    showMsg('用户必填一项');
                }
                if ($this->id > 0) {
                    $this->db->update($this->table, $a, array('id' => $this->id));
                } else {
                    $this->db->insert($this->table, $a);
                }
                showMsg('操作成功!', '/kocp/wx/index', 1);
            }
        } elseif ($param['kot'] == 2) {
            if ($this->id < 1) {
                showMsg('请选择要删除的选项');
            }
            $this->db->query('delete from {{' . $this->table . '}} where id = ' . $this->id);
            showMsg('删除成功！', '', 1);
        } else {
            $param['date1'] = isset($_REQUEST['date1']) ? trim($_REQUEST['date1']) : '';
            $param['date2'] = isset($_REQUEST['date2']) ? trim($_REQUEST['date2']) : '';
            $param['maker'] = isset($_REQUEST['maker']) ? trim($_REQUEST['maker']) : '';
            $s1 = ' select a.*,b.wx,b.name ';
            $s2 = ' from {{' . $this->table . '}} a left join {{wxyy}} b on a.uid=b.id  where 1=1 ';
            if ($param['maker'] != null) {
                $maker = ' and name = "' . $param['maker'] . '"';
            }
            if ($param['date1'] != null) {
                $date1 = ' and date >= "' . $param['date1'] . '"';
            }
            if ($param['date2'] != null) {
                $date2 = ' and date <= "' . $param['date2'] . '"';
            }
            @$s2.= $maker;
            @$s2.= $date1;
            @$s2.= $date2;
            $s2.= " order by date desc";
            $p = isset($_GET['p']) ? intval($_GET['p']) : 1;
            $ko = new Public_Page($s1, $s2, $p, 26, $db_arr, 1, 7);
            $ko->url_tp = 5;
            $ko->pageUrl = '/kocp/wx/index';
            $ko->param = $param;
            $param['data_arr'] = $ko->getItems();
            $param['page_arr'] = $ko->getPageArr();
        }
        $param['wxyy'] = $this->db->fetchAll('select id,name from {{wxyy}}');
        $this->render('index', $param, 'cp_main');
    }
    function user() {
        $param['kot'] = $this->kot;
        $param['data_arr'] = $this->db->fetchAll('select * from {{wxyy}} '); //4print_r($param);exit;
        if ($param['kot'] == 1) {
            $param['row'] = $this->db->fetchRow('select * from {{wxyy}} where id = ' . $this->id);
            if ($_POST) {
                $a['name'] = isset($_REQUEST['name']) ? trim($_REQUEST['name']) : '';
                $a['wx'] = isset($_REQUEST['wx']) ? trim($_REQUEST['wx']) : '';
                if ($this->id > 0) {
                    $this->db->update('wxyy', $a, array('id' => $this->id));
                } else {
                    $this->db->insert('wxyy', $a);
                }
                showMsg('操作成功', '/kocp/wx/user', 1);
            }
        } elseif ($param['kot'] == 2) {
            $this->db->query('delete from {{wxyy}} where id = ' . $this->id);
            showMsg('删除成功！', '', 1);
        }
        $this->render('user', $param, 'cp_main');
    }
    //周统计
    public function weekofstatistics() {
        $param['kot'] = $this->kot;
        $param['week'] = isset($_POST['week']) ? intval($_POST['week']) : 0;
        $param['kodate'] = isset($_POST['kodate']) ? trim($_POST['kodate']) : date('Y-m');
        $weekinfo = $this->get_weekinfo($param['kodate']);
         //print_r($weekinfo);die;
        foreach ($weekinfo as $k => $v) {
            if ($param['week'] == $k) {
                $weekDetails = array();
                $sql = ' select a.date,a.score1,a.score2,a.score3,a.score4,a.score5,a.score6,a.score7,a.wx,a.basescore,b.name,b.wx from ko_wx a left join ko_wxyy b on a.uid = b.id where date >= "' . $v[0] . '" and date <= "' . $v[4] . '" order by date asc';
                $weekDetails = $this->db->fetchAll($sql);
            }
        }
        $weekArray = array();
        foreach ($weekDetails as $vo) {
            $weekArray[$vo['name']][] = $vo;
        }
        $param['weekArray'] = $weekArray;
        $this->render('weekofstatistics', $param, 'cp_main');
    }
    //月统计
    public function monthlystatistical() {
        $param['kot'] = $this->kot;
        $param['kodate'] = isset($_POST['kodate']) ? trim($_POST['kodate']) : date('Y-m');
        $year = substr($param['kodate'], 0, -3);
        $month = substr($param['kodate'], 5, 2);
        if (!empty($_POST)) {
            $sql = ' select a.date,a.score1,a.score2,a.score3,a.score4,a.score5,a.score6,b.name from ko_wx a left join ko_wxyy b on a.uid = b.id where DATE_FORMAT(a.date,"%Y-%m")="' . $param['kodate'] . '"  order by date asc';
            $moonData = $this->db->fetchAll($sql);            
            $newArray = array();
            $param["monthDay"] = Public_Tool::getMonthDay($param['kodate']);
            foreach ($moonData as $row) {
                $newArray[$row["name"]][$row["date"]] = array("date" => $row["date"], 'lj'=>$row['score1'],"zf" => $row['score2'] + $row['score3'] + $row['score4'] + $row['score5'] + $row['score6']);
            }//print_r($newArray);die;
            $param["newArray"] = $newArray;
        }
        $this->render('monthlystatistical', $param, 'cp_main');
    }
    //计算总分
    function getScore($param = array()) {
        return rand(0, 50);
    }
    //日期计算
    public function get_weekinfo($month) {
        $weekinfo = array();
        $end_date = date('d', strtotime($month . ' +1 month -1 day'));
//        for ($i = 1;$i < $end_date;$i = $i + 7) {
//            $w = date('N', strtotime($month . '-' . $i));   
//            $weekinfo[] = array(date('Y-m-d', strtotime($month . '-' . $i . ' -' . ($w - 1) . ' days')), date('Y-m-d', strtotime($month . '-' . $i . ' -' . ($w - 2) . ' days')), date('Y-m-d', strtotime($month . '-' . $i . ' -' . ($w - 3) . ' days')), date('Y-m-d', strtotime($month . '-' . $i . ' -' . ($w - 4) . ' days')), date('Y-m-d', strtotime($month . '-' . $i . ' -' . ($w - 5) . ' days')));
//        }
         $j=0;
         $weekinfo=array();
         for ($i = 1;$i <= $end_date;$i++) {
            $w = date('N', strtotime($month . '-' . $i));
            if($w<7){
              $weekinfo[$j][]=date('Y-m-d', strtotime($month . '-' . $i));
            } else{
               $weekinfo[$j][]=date('Y-m-d', strtotime($month . '-' . $i));
               $j++; 
            }
        }
        return $weekinfo;
    }
    //提交更新文件
    function updateFile() {
        $ip = Public_Http::get_server_ip();
        if ($ip == '192.168.1.185') {
            exec('svn up --username ko_zb --password ko123456789 /data/usb1/www_data/Profollow --force --no-auth-cache 2>&1', $out);
            foreach ($out as $v) {
                $v = trim($v);
                if (strrpos($v, 'revision') || strrpos($v, 'Updated')) {
                    $v = str_replace('Updated', '', $v);
                    $v = str_replace('to', '', str_replace('At', '', $v));
                    $v = str_replace('revision', '', $v);
                    echo '版本更新至 - ' . $v;
                } else {
                    $f = substr($v, 0, 1);
                    if ($f == 'U') {
                        echo '文件更新了';
                    } elseif ($f == 'G') {
                        echo '成功的合并了文件';
                    } elseif ($f == 'A') {
                        echo '添加新文件或者目录';
                    } elseif ($f == 'R') {
                        echo '文件或者目录被替换了';
                    } elseif ($f == 'C') {
                        echo '文件改发生冲突';
                    } elseif ($f == 'D') {
                        echo '文件或者目录被删除了';
                    } else {
                        echo '未知';
                    }
                    echo ' - ' . trim(str_replace($f, '', $v));
                }
                echo '<br>';
            }
        } else {
            showMsg('请登录公司订单管理系统后执行操作');
        }
    }
    public function leJuan($uid,$date) {
         $sql = 'select SUM(num1) as num from ko_wx where uid = '.$uid.' and date like "' .date('Y-m', strtotime($date)).'%"';
         $data = $this->db->fetchRow($sql);
         return $data['num'];
    } 
    
     public function feedBack($uid,$date) {
         $sql = 'select SUM(num3) as num from ko_wx where uid = '.$uid.' and date like "' .date('Y-m', strtotime($date)).'%"';
         $data = $this->db->fetchRow($sql);
         return $data['num'];
    }
    
    public function qkWeek($uid,$date) {
         $sql = 'select SUM(num4) as num from ko_wx where uid = '.$uid.' and date like "' .date('Y-m', strtotime($date)).'%"';
         $data = $this->db->fetchRow($sql);
         return $data['num'];
    } 
    
//    public function qkWeek($uid,$date) {
//         $mon=date('Y-m', strtotime($date));
//         $w = date('N', strtotime($date));
//         $end_date = date('d', strtotime($mon . ' +1 month -1 day'));
//         $min= date('Y-m-d',strtotime($date . ' -' . ($w - 1) . ' days'));
//         $max= date('Y-m-d',strtotime($date . ' -' . ($w - 7) . ' days'));
//         if($min<($mon.'-1')){
//             $min=date('Y-m-d',strtotime($mon.'-1'));
//         }
//         if($max>($mon.'-'.$end_date)){
//             $max=date('Y-m-d',strtotime($mon.'-'.$end_date));
//         }  
//         //echo $min;echo $max;
//         $sql = "select SUM(num4) as num from ko_wx where uid = ".$uid." and `date` between '".$min."' and '".$max."'";
//         $data = $this->db->fetchRow($sql);
//         return $data['num'];
//    }
      
}