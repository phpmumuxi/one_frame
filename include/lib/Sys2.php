<?php
/**
 * 系统公用方法 函数库
 * 
 * @Author: Hardy
 */
class Sys2 {

    /**
     * 上传文件
     * $img：    上传域
     * $dir：    上传保存文件夹名称
     * $maxsize：上传最大限制(默认5M) 
     */
    public static function ko_upload($img, $dir='public', $maxsize=50) {
        $imga = array(); $err = 1;//为1表示上传成成功
        if ($img['error'] == 1) {
            $err = '文件大小超出了服务器的空间大小';
        } elseif ($img['error'] == 2) {
            $err = '文件大小超出了服务器的空间大小';
        } elseif ($img['error'] == 3) {
            $err = '文件仅部分被上传';
        } elseif ($img['error'] == 4) {
            $err = '请选择要上传的文件';
        } elseif ($img['error'] == 5) {
            $err = '服务器临时文件夹丢失';
        } elseif ($img['error'] == 6) {
            $err = '文件写入到临时文件夹出错';
        } elseif ($img['error'] == 0) {
            $postfix = '.' . $imga['suffix'] = Sys::get_postfix($img['name']); //获取文件后缀名
            if ($img['size'] > $maxsize*1048576) {
                $err = '你上传的文件超过了最大限制 '.$maxsize.'MB';
            } else {
                $path = KO_UPLOAD_PATH .'/'.$dir.Public_Img::hours_path();
                Sys::create_dir($path);
                $path .= '/'.time().mt_rand(0, 99999999).$postfix;
                if (@file_exists($path)) { @unlink($path); }
                if (@move_uploaded_file($img['tmp_name'], $path) > 0) {
                    $imga['full'] = $path; //绝对路径[带文件名]
                } else {
                    $err = '文件上传失败';
                }
            }
        }
        $imga['err'] = $err; return $imga;
    }
    
    //生成报价编号
    public static function create_number() {
        $db = Sys::getdb(); $now_rq = date('Ymd');
        $max = intval($db->fetchOne('SELECT MAX(RIGHT(number, 3)) FROM {{quote}} WHERE LEFT(number, 8)="'.$now_rq.'"')) + 1;
        return $now_rq.Str::sprintf($max, 3);
    }

    /**
     * 导入报价信息
     * @param $dao_lx 导入类型
     * @param $ddfile 文件域
     * @param $dir 保存的文件夹
     */    
    public static function ko_save_daoru($dao_lx, $ddfile, $dir='') {
        $da = Sys2::ko_upload($ddfile, $dir); if ($da['err'] != 1) { showMsg( $da['err'] ); }
        include( KO_INCLUDE_PATH.'/lib/Phpexcel/PHPExcel.php' ); $db = Sys::getdb();        
        $obj = PHPExcel_IOFactory::load( $da['full'] ); $sheet = $obj->getSheet( 0 );
        $allRow = $sheet->getHighestRow(); //取得总行数
        for ($i = 2; $i <= $allRow; $i++) {
            $a = array(); $a['type'] = $dao_lx;
            $a['name'] = trim($sheet->getCell( 'A'.$i )->getFormattedValue()); //刊物名
            $br = Dao_Base::get_base_row(0, $sheet->getCell( 'B'.$i )->getFormattedValue(), 10); $a['xingji_id'] = $br['id']; //星级
            $br = Dao_Base::get_base_row(0, $sheet->getCell( 'C'.$i )->getFormattedValue(), 7); $a['qk_level'] = $br['id']; //期刊等级
            $br = Dao_Base::get_base_row(0, $sheet->getCell( 'D'.$i )->getFormattedValue(), 6); $a['fwxk_id'] = $br['id']; //服务学科
            $br = Dao_Base::get_base_row(0, $sheet->getCell( 'E'.$i )->getFormattedValue(), 9); $a['addqk_id'] = $br['id']; //发刊周期
            $a['director'] = trim($sheet->getCell( 'F'.$i )->getFormattedValue()); //主管单位
            $a['organizer'] = trim($sheet->getCell( 'G'.$i )->getFormattedValue()); //主办单位
            $a['nei_num'] = trim($sheet->getCell( 'H'.$i )->getFormattedValue()); //国内
            $a['wai_num'] = trim($sheet->getCell( 'I'.$i )->getFormattedValue()); //国际
            $a['you_num'] = trim($sheet->getCell( 'J'.$i )->getFormattedValue()); //邮发代号
            $a['char_ban'] = trim($sheet->getCell( 'K'.$i )->getFormattedValue()); //字符/版
            $a['kefa_cycle'] = trim($sheet->getCell( 'L'.$i )->getFormattedValue()); //可发周期
            $a['price3'] = trim($sheet->getCell( 'M'.$i )->getFormattedValue()); //套餐价格
            $a['price1'] = trim($sheet->getCell( 'N'.$i )->getFormattedValue()); //发表价格
            $a['zhu_lanmu'] = trim($sheet->getCell( 'O'.$i )->getFormattedValue()); //主要栏目
            $a['price2'] = trim($sheet->getCell( 'P'.$i )->getFormattedValue()); //成本价格
            $a['cons'] = trim($sheet->getCell( 'Q'.$i )->getFormattedValue()); //联系方式
            
            $a['remark'] = trim($sheet->getCell( 'R'.$i )->getFormattedValue()); //备注
            $bz2 = trim($sheet->getCell( 'S'.$i )->getFormattedValue()); //备注
            if ($bz2!='') { if ($a['remark']!='') { $a['remark'] .= '，'; } $a['remark'] .= $bz2; }
            $bz3 = trim($sheet->getCell( 'T'.$i )->getFormattedValue()); //备注
            if ($bz3!='') { if ($a['remark']!='') { $a['remark'] .= '，'; } $a['remark'] .= $bz3; }
            $bz4 = trim($sheet->getCell( 'U'.$i )->getFormattedValue()); //备注
            if ($bz4!='') { if ($a['remark']!='') { $a['remark'] .= '，'; } $a['remark'] .= $bz4; }
            
            if ($a['name']!='') {
                $a['number'] = Sys2::create_number(); $a['add_at'] = time();
                $db->insert('quote', $a);
            }
        }
        @unlink( $da['full'] );
        showMsg('报价信息导入成功', '', 1);
    }
    
    /**
     * 导出报价信息
     * @param $ddfile 文件域
     * @param $dir 保存的文件夹
     */    
    public static function ko_bj_putout($sql, $dao_tou_arr, $db_arr) {    
        include( KO_INCLUDE_PATH.'/lib/Phpexcel/PHPExcel.php' );
        ini_set('memory_limit', '1500M'); $db = Sys::getdb();
        $letters_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $xls_obj = new PHPExcel(); $xls_obj->setActiveSheetIndex( 0 );
        $sheet = $xls_obj->getActiveSheet(); $sheet->setTitle( '报价信息' );
        $letters = $letters_arr[count($dao_tou_arr)-1]; $ii = 0; $jj = 2;
        for ($i='A'; $i<=$letters; $i++) {
            $sheet->setCellValue($i.'1', $dao_tou_arr[$ii]['0']); $setWidth = 35;
            if ($dao_tou_arr[$ii]['1']=='zhu_lanmu' || $dao_tou_arr[$ii]['1']=='remark') {
                $setWidth = 100;
            }
            $sheet->getColumnDimension( $i )->setWidth( $setWidth );
            $ii++;
        }
        $data_arr = $db->fetchAll($sql, $db_arr);
        if (!empty($data_arr)) {
            foreach ($data_arr as $dv) {
                $ii = 0;
                for ($i='A'; $i<=$letters; $i++) {
                    $sheet->setCellValueExplicit($i.$jj, $dv[$dao_tou_arr[$ii]['1']], PHPExcel_Cell_DataType::TYPE_STRING); $ii++;
                }
                $jj++;
            }
        }
        //输出到浏览器下载
        $objWriter = PHPExcel_IOFactory::createWriter($xls_obj, 'Excel5');
        $output_name = date('Y-m-d-His').'.xls';
        @header('Pragma:public');
        @header('Content-Type:application/x-msexecl;name="'.$output_name.'"');
        @header('Content-Disposition:inline;filename="'.$output_name.'"');
        $objWriter->save('php://output'); exit;
    }
    
    /**
     * 导入订单信息
     * @param $ddfile 文件域
     * @param $dir 保存的文件夹
     */    
    public static function ko_order_save_daoru($ddfile, $dir='', $serve1_mid=0) {
        $da = Sys2::ko_upload($ddfile, $dir); if ($da['err'] != 1) { showMsg( $da['err'] ); }
        include( KO_INCLUDE_PATH.'/lib/Phpexcel/PHPExcel.php' );
        $reader = PHPExcel_IOFactory::createReader( ($da['suffix']=='xlsx') ? 'Excel2007' : 'Excel5' );
        $obj = $reader->load( $da['full'] ); $sheet = $obj->getSheet( 0 );
        
        $a['number'] = trim($sheet->getCell( 'C5' )->getFormattedValue()); //单号
        $a['keywords'] = trim($sheet->getCell( 'E5' )->getFormattedValue()); //关键词
        $a['source'] = trim($sheet->getCell( 'C9' )->getFormattedValue()); //客户来源
        $a['ht_costs'] = floatval($sheet->getCell( 'C6' )->getFormattedValue()); //总金额
        $a['ht_paybm'] = trim($sheet->getCell( 'E9' )->getFormattedValue()); //版面费[包含，不包含或自理]
        $a['ht_remark'] = trim($sheet->getCell( 'C14' )->getFormattedValue()); //备注
        if ($a['ht_paybm']=='不包含') { $a['ht_paybm'] = '自理'; }

        $b['totle'] = floatval($sheet->getCell( 'E6' )->getFormattedValue()); //定金金额
        $b['name'] = trim($sheet->getCell( 'C11' )->getFormattedValue()); //付款人姓名
        $b['bank'] = trim($sheet->getCell( 'E11' )->getFormattedValue()); //付款银行
        $b['time'] = trim($sheet->getCell( 'C12' )->getFormattedValue()); //付款时间
        $b['city'] = trim($sheet->getCell( 'E12' )->getFormattedValue()); //付款地区

        $a['con_name'] = trim($sheet->getCell( 'C16' )->getFormattedValue()); //姓名
        $a['con_mob'] = trim($sheet->getCell( 'E16' )->getFormattedValue()); //电话（手机）
        $a['con_qq'] = trim($sheet->getCell( 'C17' )->getFormattedValue()); //QQ
        $a['con_email'] = trim($sheet->getCell( 'E17' )->getFormattedValue()); //邮箱
        $a['con_company'] = trim($sheet->getCell( 'C18' )->getFormattedValue()); //公司名称
        $a['con_remark'] = trim($sheet->getCell( 'E18' )->getFormattedValue()); //备注

        $a['lw_title'] = trim($sheet->getCell( 'C19' )->getFormattedValue()); //论文方向或题目
        $a['yaoqiu'] = trim($sheet->getCell( 'C20' )->getFormattedValue()); //写作要求及资料
        $a['fb_time'] = trim($sheet->getCell( 'C21' )->getFormattedValue()); //见刊时间
        $a['lw_words'] = trim($sheet->getCell( 'E21' )->getFormattedValue()); //论文字符数
        $a['yongtu'] = trim($sheet->getCell( 'C22' )->getFormattedValue()); //发表用途
        $a['jijin_num'] = trim($sheet->getCell( 'E22' )->getFormattedValue()); //基金项目编号(没有则不填)
        $a['lw_ncjbfx'] = trim($sheet->getCell( 'C23' )->getFormattedValue()); //期刊名称、级别及方向

        $a['name'] = trim($sheet->getCell( 'C24' )->getFormattedValue()); //客户名称
        $a['birthday'] = trim($sheet->getCell( 'C25' )->getFormattedValue()); //出生年月
        if (!empty($a['birthday'])) {
            $a['birthday'] = str_replace('年','-',$a['birthday']);
            $a['birthday'] = str_replace('月','-',$a['birthday']);
            $a['birthday'] = str_replace('日','',$a['birthday']);
            $a['birthday'] = str_replace('.','-',$a['birthday']);
            $birth_arr = explode('-',$a['birthday']);
            if (!isset($birth_arr['1'])) {
                $a['birthday'] .= '-01';
             }
             if (!isset($birth_arr['2'])) {
                $a['birthday'] .= '-01';
             }
        }
        $a['sex'] = trim($sheet->getCell( 'C26' )->getFormattedValue()); //性别
        $a['jiguan'] = trim($sheet->getCell( 'C27' )->getFormattedValue()); //籍贯
        $xueli = trim($sheet->getCell( 'C28' )->getFormattedValue()); //最高学历
        if ($xueli != '') {
            $xue_a = Dao_Base::getjichuAll(0, 13);
            foreach ($xue_a as $v) {
                if ($xueli == $v['name']) {
                    $a['xueli_id'] = $v['id']; break;
                }
            }
        }
        $a['job'] = trim($sheet->getCell( 'C29' )->getFormattedValue()); //目前职称
        $a['mob'] = trim($sheet->getCell( 'C30' )->getFormattedValue()); //手机
        $a['email'] = trim($sheet->getCell( 'C31' )->getFormattedValue()); //邮箱
        $a['yanjiu'] = trim($sheet->getCell( 'C32' )->getFormattedValue()); //主要研究方向
        $a['unit_zip'] = trim($sheet->getCell( 'C33' )->getFormattedValue()); //工作单位名称及邮编
        $a['address'] = trim($sheet->getCell( 'C34' )->getFormattedValue()); //通讯地址及邮编
        $a['remark'] = trim($sheet->getCell( 'C35' )->getFormattedValue()); //备注
        
        if ($serve1_mid<1 && $a['name']=='' || $a['source']=='' || $a['ht_costs']<0 || $a['number']=='' || $a['keywords']=='' || $b['totle']<0 || $b['time']=='' || $b['bank']=='') {
            showMsg('必要的选项不能为空，具体请参考添加表单的带*项');
        }
        $db = Sys::getdb(); $a['status'] = 1; $a['serve1_mid'] = $serve1_mid;
        $a['add_at'] = time(); $db->insert('order', $a); $id = $db->getlastInsertId();
        
        //保存定金信息        
        $b['lx_id'] = Dao_Order::get_ding_ID(); $b['order_id'] = $id;
        $b['status'] = 1; $db->insert('order_sk_app', $b);
        
        @unlink( $da['full'] );
        showMsg('订单信息导入成功', '', 1);        
    }
    
} //end class