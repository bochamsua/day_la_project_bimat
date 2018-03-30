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
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'MOR ID'
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
        'mor_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'MOR No'
    )
    ->addColumn(
        'ata',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'ATA'
    )
    ->addColumn(
        'occur_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Occur Date'
    )
    ->addColumn(
        'flight_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Flight No'
    )
    ->addColumn(
        'place',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Place'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Description'
    )
    ->addColumn(
        'cause',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Cause of event'
    )
    ->addColumn(
        'action_take',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Action Take'
    )
    ->addColumn(
        'mor_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Type'
    )
    ->addColumn(
        'mor_filter',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Filter'
    )
    ->addColumn(
        'report',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Report to Manufacturer'
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
        'mor_status',
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
        'MOR Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'MOR Creation Time'
    ) 
    ->setComment('MOR Table');
$this->getConnection()->createTable($table);
$this->endSetup();
