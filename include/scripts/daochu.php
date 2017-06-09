<?php // http://www.med126.com - 采集政策
$dir = dirname(__FILE__);
exit;
include($dir.'/../KO_SCRIPT.php');
$db = Sys::getdb();


include( KO_INCLUDE_PATH.'/lib/PHPExcel/PHPExcel.php' );
$xls_obj = new PHPExcel(); 

$a = $db->fetchAll('SELECT id,name,child_ids FROM ko_art_type WHERE lx_id=2 and parent_id=0');
//print_r($a);exit;
foreach ($a as $k0 => $v0) {
    if ($k0 == 0) {
        $xls_obj->setActiveSheetIndex( 0 );
        $sheet = $xls_obj->getActiveSheet();
    } else {
        $xls_obj->createSheet();
        $sheet = $xls_obj->getSheet( $k0 );
    }
    $sheet->setTitle( $v0['name'] );
    $sheet->setCellValue('A1', '级别');
    $sheet->setCellValue('B1', '标题');
    $sheet->setCellValue('C1', 'URL');
    //设置列宽
    $sheet->getColumnDimension('A')->setWidth( 30 );
    $sheet->getColumnDimension('B')->setWidth( 100 );
    $sheet->getColumnDimension('C')->setWidth( 300 );

    $b2 = $db->fetchAll('SELECT a.id,a.title FROM ko_art_con a WHERE a.cat_id in ('.$v0['child_ids'].')');
    if (!empty($b2)) {
        foreach ($b2 as $k2 =>$v2) {
            $i1 = ($k2 + 2);
            $sheet->setCellValueExplicit('A'.$i1, $v0['name'], PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B'.$i1, $v2['title'], PHPExcel_Cell_DataType::TYPE_STRING);   
            $sheet->setCellValueExplicit('C'.$i1, 'http://www.qkw360.com/detail-'.$v2['id'].'.html', PHPExcel_Cell_DataType::TYPE_STRING);
        }
    }
    
}
$objWriter = PHPExcel_IOFactory::createWriter($xls_obj, 'Excel2007'); //Excel5用于其他低版本xls,Excel2007高版本
$objWriter->save( $dir.time().'.xlsx' );



echo msg("全部完成\n");