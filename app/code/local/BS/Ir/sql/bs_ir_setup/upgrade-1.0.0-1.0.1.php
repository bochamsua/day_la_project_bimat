<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2016
 */
/**
 * Surveillance module install script
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getTable('bs_ir/ir');
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'taskgroup_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Task group Id'
        ]
    )
;
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ref_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Ref Id'
        ]
    )
;

$this->getConnection()->modifyColumn($table, 'ac_reg', 'int(10) NULL default NULL');

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ac_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'AC Type'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'customer',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Customer'
        ]
    )
;

$this->getConnection()->changeColumn($table, 'inspection_date','report_date', [
    'type'      => Varien_Db_Ddl_Table::TYPE_DATE,
    'comment'   => 'Report Date'
]);

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'event_date',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_DATE,
            'comment'   => 'Event Date'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'subject',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Ir Subject'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'consequence',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'consequence'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'analysis',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'analysis'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'causes',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'causes'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'corrective',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'corrective'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'remark',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'remark'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ir_status',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ir_status'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'accept',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'accept'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'reject_reason',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'reject_reason'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'remark_text',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'remark_text'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'approval_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'approval_id'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ir_source',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ir_source'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'subject_other',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'subject_other'
        ]
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'consequence_other',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'consequence_other'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ncausegroup_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncausegroup_id'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ncause_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncause_id'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'subtask_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'subtask_id'
        ]
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'error_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'error_type'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'repetitive',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'repetitive'
        ]
    )
;

$this->endSetup();
