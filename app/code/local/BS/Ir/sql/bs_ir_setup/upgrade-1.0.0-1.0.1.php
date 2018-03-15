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
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Task group Id'
        )
    )
;
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ref_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Ref Id'
        )
    )
;

$this->getConnection()->modifyColumn($table, 'ac_reg', 'int(10) NULL default NULL');

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ac_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'AC Type'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'customer',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Customer'
        )
    )
;

$this->getConnection()->changeColumn($table, 'inspection_date','report_date', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_DATE,
    'comment'   => 'Report Date'
));

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'event_date',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_DATE,
            'comment'   => 'Event Date'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'subject',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Ir Subject'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'consequence',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'consequence'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'analysis',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'analysis'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'causes',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'causes'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'corrective',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'corrective'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'remark',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'remark'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ir_status',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ir_status'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'accept',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'accept'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'reject_reason',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'reject_reason'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'remark_text',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'remark_text'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'approval_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'approval_id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ir_source',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ir_source'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'subject_other',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'subject_other'
        )
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'consequence_other',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'consequence_other'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ncausegroup_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncausegroup_id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ncause_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncause_id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'subtask_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'subtask_id'
        )
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'error_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'error_type'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'repetitive',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'repetitive'
        )
    )
;

$this->endSetup();
