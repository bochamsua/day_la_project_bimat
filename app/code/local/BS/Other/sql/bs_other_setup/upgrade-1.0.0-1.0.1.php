<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other module install script
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
$this->startSetup();
$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_other/other'),
	     'task_id',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Survey Code'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_other/other'),
	     'ins_id',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Inspector'
         ]
     )
;
$this->endSetup();
