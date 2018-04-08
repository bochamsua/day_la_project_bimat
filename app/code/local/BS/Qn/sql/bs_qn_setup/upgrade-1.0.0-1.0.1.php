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
	     $this->getTable('bs_qn/qn'),
	     'ac_type',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Type'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_qn/qn'),
	     'customer',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Customer'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_qn/qn'),
	     'ac_reg',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Reg'
         ]
     )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'dept_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Sent to Dept'
        ]
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'dept_id_cc',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'CC to Dept'
        ]
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'subject',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'subject'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'content',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'content'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'remark_text',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'remark_text'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'region',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'section',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'ref_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'source_other',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'source_other'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qn/qn'),
        'self_remark',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'self_remark'
        ]
    )
;

$this->endSetup();
