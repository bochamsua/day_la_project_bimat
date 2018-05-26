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
	     $this->getTable('bs_mor/mor'),
	     'ref_type',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
		     'after'    => 'ref_id',
             'length'   => 50,
		     'comment'   => 'ref_type'
         ]
     )
;


$this->endSetup();
