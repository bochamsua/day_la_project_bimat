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
$table = $this->getTable('bs_signoff/signoff');
$this->getConnection()->modifyColumn($table, 'ac_reg', 'int(10) NULL default NULL');

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_signoff/signoff'),
	     'ac_type',
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Type'
	     )
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_signoff/signoff'),
	     'customer',
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Customer'
	     )
     )
;


$this->endSetup();
