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
	     $this->getTable('bs_drr/drr'),
	     'ac_type',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Type'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_drr/drr'),
	     'customer',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Customer'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_drr/drr'),
	     'ac_reg',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Reg'
         ]
     )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'dept_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Dept'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'flight_no',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'Flight No'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'check',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'Check'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'wp',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'Work Pack'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'ncausegroup_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncausegroup_id'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'ncause_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncause_id'
        ]
    )
;

$this->endSetup();
