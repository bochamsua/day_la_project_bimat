<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * Rii module install script
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getTable('bs_kpi/kpi');
$this->getConnection()->changeColumn($table, 'customer_complaitn','customer_complaint', array(
	'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
	'comment'   => 'Customer Complaint'
));


$this->endSetup();
