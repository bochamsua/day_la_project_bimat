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
	     $this->getTable('bs_qr/qr'),
	     'ac_type',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Type'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_qr/qr'),
	     'customer',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Customer'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_qr/qr'),
	     'ac_reg',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'AC Reg'
         ]
     )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'dept_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Sent to Dept'
        ]
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'dept_id_cc',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'CC to Dept'
        ]
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'subject',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'subject'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'content',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'content'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'remark_text',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'remark_text'
        ]
    )
;


$this->endSetup();
