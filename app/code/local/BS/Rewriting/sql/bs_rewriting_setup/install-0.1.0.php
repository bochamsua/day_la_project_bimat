<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('admin/user'), 'vaeco_id', [
	'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
	'length' => 16,
	'nullable' => true,
	'default' => null,
	'comment' => 'Vaeco Id'
]);

$installer->getConnection()->addColumn($installer->getTable('admin/user'), 'crs_no', [
	'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
	'length' => 39,
	'nullable' => true,
	'default' => null,
	'comment' => 'crs_no'
]);

$installer->endSetup();