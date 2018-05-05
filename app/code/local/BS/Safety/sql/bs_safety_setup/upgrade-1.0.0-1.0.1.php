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

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_safety/safety'),
	     'event_type',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'event_type'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_safety/safety'),
	     'event_no',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
		     'comment'   => 'event no'
         ]
     )
;


$this->endSetup();
