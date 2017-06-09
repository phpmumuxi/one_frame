<?php
/**
 * 数据库配置
 *
 * @Author: Hardy
 */
return array(

	//第一个数据库
	'database_1' => array(
		'dbtype'  => 'mysql',
		'dbport'  => 3306,
		'dbhost'  => 'localhost',
		'dbname'  => 'sy_dhwbio_cn',
        'dbuser'  => 'root',
		'dbpass'  => '2CD5imAd2q-CD-5UTTXimAd',
		'charset' => 'UTF8',
		'prefix'  => 'ko_',
	),
	
	//第二个数据库
	'database_2' => array(
		'dbtype'  => 'mysql',
		'dbport'  => 3306,
		'dbhost'  => 'localhost',
		'dbname'  => 'newbio',
        'dbuser'  => 'root',
		'dbpass'  => '',		
		'charset' => 'UTF8',
		'prefix'  => 'ko_',
	),

);
