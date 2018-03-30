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
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'MEDA ID'
    )
    ->addColumn(
        'ref_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Reference No'
    )
    ->addColumn(
        'customer',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Customer'
    )
    ->addColumn(
        'ac_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'A/C Type'
    )
    ->addColumn(
        'ac_reg',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'A/C Reg'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Inspector'
    )
    ->addColumn(
        'report_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Date of Report'
    )
    ->addColumn(
        'meda_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Report No'
    )
    ->addColumn(
        'event_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Event Date'
    )
    ->addColumn(
        'consequence',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Consequence'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Error Description'
    )
    ->addColumn(
        'place',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Place'
    )
    ->addColumn(
        'root_cause',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Root Cause'
    )
    ->addColumn(
        'corrective',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Corrective/Preventive action'
    )
    ->addColumn(
        'remark_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Remark Text'
    )
    ->addColumn(
        'revoke',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Revoke/ Suspence Office letter'
    )
    ->addColumn(
        'feedback',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Feedback to reporter'
    )
    ->addColumn(
        'due_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Due Date'
    )
    ->addColumn(
        'approval_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Approved By'
    )
    ->addColumn(
        'meda_status',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Status'
    )
    ->addColumn(
        'close_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Close Date'
    )
    ->addColumn(
        'reject_reason',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Reject Reason'
    )
    ->addColumn(
        'taskgroup_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Task Group'
    )
    ->addColumn(
        'task_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Task Id'
    )
    ->addColumn(
        'subtask_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned'  => true,
        ),
        'Subtask'
    )
    ->addColumn(
        'ref_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned'  => true,
        ),
        'Ref Id'
    )
    ->addColumn(
        'dept_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Dept'
    )
    ->addColumn(
        'loc_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Location'
    )
    ->addColumn(
        'section',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Section'
    )
    ->addColumn(
        'region',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Region'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Enabled'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'MEDA Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'MEDA Creation Time'
    ) 
    ->setComment('MEDA Table');
$this->getConnection()->createTable($table);
$this->endSetup();
