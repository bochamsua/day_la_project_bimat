<?php
/**
 * BS_Mor extension
 * 
 * @category       BS
 * @package        BS_Mor
 * @copyright      Copyright (c) 2018
 */
/**
 * Mor module install script
 *
 * @category    BS
 * @package     BS_Mor
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_mor/mor'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'MOR ID'
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
        'mor_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'MOR No'
    )
    ->addColumn(
        'ata',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'ATA'
    )
    ->addColumn(
        'occur_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Occur Date'
    )
    ->addColumn(
        'flight_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Flight No'
    )
    ->addColumn(
        'place',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Place'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Description'
    )
    ->addColumn(
        'cause',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Cause of event'
    )
    ->addColumn(
        'action_take',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Action Take'
    )
    ->addColumn(
        'mor_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Type'
    )
    ->addColumn(
        'mor_filter',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Filter'
    )
    ->addColumn(
        'report',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Report to Manufacturer'
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
        'mor_status',
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
        'MOR Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'MOR Creation Time'
    ) 
    ->setComment('MOR Table');
$this->getConnection()->createTable($table);
$this->endSetup();
