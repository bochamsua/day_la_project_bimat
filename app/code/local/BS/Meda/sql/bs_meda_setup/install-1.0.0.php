<?php
/**
 * BS_Meda extension
 * 
 * @category       BS
 * @package        BS_Meda
 * @copyright      Copyright (c) 2018
 */
/**
 * Meda module install script
 *
 * @category    BS
 * @package     BS_Meda
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_meda/meda'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'MEDA ID'
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
        'customer',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Customer'
    )
    ->addColumn(
        'ac_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'A/C Type'
    )
    ->addColumn(
        'ac_reg',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'A/C Reg'
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
        'Date of Report'
    )
    ->addColumn(
        'meda_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Report No'
    )
    ->addColumn(
        'event_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Event Date'
    )
    ->addColumn(
        'consequence',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Consequence'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Error Description'
    )
    ->addColumn(
        'place',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Place'
    )
    ->addColumn(
        'root_cause',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Root Cause'
    )
    ->addColumn(
        'corrective',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Corrective/Preventive action'
    )
    ->addColumn(
        'remark_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Remark Text'
    )
    ->addColumn(
        'revoke',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Revoke/ Suspence Office letter'
    )
    ->addColumn(
        'feedback',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Feedback to reporter'
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
        'meda_status',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Status'
    )
    ->addColumn(
        'close_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Close Date'
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
        'dept_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Dept'
    )
    ->addColumn(
        'loc_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Location'
    )
    ->addColumn(
        'section',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Section'
    )
    ->addColumn(
        'region',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Region'
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
        'MEDA Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'MEDA Creation Time'
    ) 
    ->setComment('MEDA Table');
$this->getConnection()->createTable($table);
$this->endSetup();
