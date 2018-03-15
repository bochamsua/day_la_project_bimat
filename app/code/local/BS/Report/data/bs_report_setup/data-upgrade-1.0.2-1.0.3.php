<?php
$settings = array(
	array(
		'code' => 'd2',
		'value' => '3.5',
	),
	array(
		'code' => 'd3',
		'value' => '3.5',
	),
	array(
		'code' => 'ir',
		'value' => '3',
	),
	array(
		'code' => 'ncr',
		'value' => '1',
	),
	array(
		'code' => 'drr',
		'value' => '1',
	),
	array(
		'code' => 'qr',
		'value' => '1',
	),
);

/*
 * (1,'d2','3.5',NULL,NULL,'2017-02-21 06:56:15','2017-02-21 06:56:15'),
	(2,'d3','3.5',NULL,NULL,'2017-02-21 06:56:24','2017-02-21 06:56:24'),
	(3,'ir','3',NULL,NULL,'2017-02-21 06:57:06','2017-02-21 06:57:06'),
	(4,'ncr','1',NULL,NULL,'2017-02-21 06:57:20','2017-02-21 06:57:20'),
	(5,'drr','1',NULL,NULL,'2017-02-21 06:57:28','2017-02-21 06:57:28'),
	(6,'qr','1',NULL,NULL,'2017-02-21 06:57:40','2017-02-21 06:57:40');

 */

foreach ($settings as $s) {
	Mage::getModel('bs_report/setting')
	    ->setData($s)
	    ->save();
}
