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
	     $this->getTable('bs_car/car'),
	     'ac_type',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Type'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_car/car'),
	     'customer',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Customer'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_car/car'),
	     'ac_reg',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Reg'
         ]
     )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'dept_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Dept'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'audit_report_ref',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'audit_report_ref'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'level',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Level'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'nc_cause_text',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'nc_cause_text'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'repetitive',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'comment'   => 'repetitive'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'error_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'error_type'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'ncausegroup_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncausegroup_id'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'ncause_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncause_id'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'region',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'section',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        ]
    )
;
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'ref_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'source_other',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'source_other'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'self_remark',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'self_remark'
        ]
    )
;


$this->endSetup();
