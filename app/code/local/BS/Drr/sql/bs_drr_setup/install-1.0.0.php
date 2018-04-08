<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr module install script
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_drr/drr'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Drr ID'
    )
    ->addColumn(
        'ref_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Reference No'
    )
    ->addColumn(
        'drr_source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Source'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Inspector'
    )
    ->addColumn(
        'report_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Report Date'
    )
    ->addColumn(
        'ref_doc',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Ref Doc'
    )
    ->addColumn(
        'ac',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'A/C'
    )
    ->addColumn(
        'drr_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Type'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Description'
    )
    ->addColumn(
        'due_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Due Date'
    )
    ->addColumn(
        'approval_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Approved By'
    )
    ->addColumn(
        'drr_status',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Status'
    )
    ->addColumn(
        'remark',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Remark'
    )
    ->addColumn(
        'close_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Close Date'
    )
    ->addColumn(
        'accept',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Accept/Reject'
    )
    ->addColumn(
        'reject_reason',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Reject Reason'
    )
    ->addColumn(
        'taskgroup_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Task Group'
    )
    ->addColumn(
        'task_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Task Id'
    )
    ->addColumn(
        'subtask_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'unsigned'  => true,
        ],
        'Subtask'
    )
    ->addColumn(
        'ref_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'unsigned'  => true,
        ],
        'Ref Id'
    )
    ->addColumn(
        'is_submitted',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Is Submitted?'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Enabled'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Drr Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Drr Creation Time'
    ) 
    ->setComment('Drr Table');
$this->getConnection()->createTable($table);
$this->endSetup();
