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
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Type'
	     )
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_car/car'),
	     'customer',
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Customer'
	     )
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_car/car'),
	     'ac_reg',
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Reg'
	     )
     )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'dept_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Dept'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'audit_report_ref',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'audit_report_ref'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'level',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Level'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'nc_cause_text',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'nc_cause_text'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'repetitive',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'comment'   => 'repetitive'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'error_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'error_type'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'ncausegroup_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncausegroup_id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'ncause_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncause_id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'region',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'section',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        )
    )
;
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'ref_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'source_other',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'source_other'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_car/car'),
        'self_remark',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'self_remark'
        )
    )
;


$this->endSetup();
