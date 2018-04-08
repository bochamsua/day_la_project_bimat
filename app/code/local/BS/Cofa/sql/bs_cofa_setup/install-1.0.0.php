<?php
/**
 * BS_Cofa extension
 * 
 * @category       BS
 * @package        BS_Cofa
 * @copyright      Copyright (c) 2017
 */
/**
 * Cofa module install script
 *
 * @category    BS
 * @package     BS_Cofa
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_cofa/cofa'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'CoA Data ID'
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
        'code_sqs',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Code SQS'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Inspector'
    )
    ->addColumn(
        'dept_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Department'
    )
    ->addColumn(
        'loc_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Location'
    )
    ->addColumn(
        'report_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Date of Inspection'
    )
    ->addColumn(
        'due_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Due Date'
    )
    ->addColumn(
        'close_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Close Date'
    )
    ->addColumn(
        'root_cause',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Root Cause'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Description'
    )
    ->addColumn(
        'corrective',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Corrective'
    )
    ->addColumn(
        'preventive',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Preventive'
    )
    ->addColumn(
        'repetitive',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Repetitive'
    )
    ->addColumn(
        'cofa_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Type'
    )
    ->addColumn(
        'cofa_status',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Status'
    )
    ->addColumn(
        'ir',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'IR'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'NCR'
    )
    ->addColumn(
        'qr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'QR'
    )
    ->addColumn(
        'drr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'DRR'
    )
    ->addColumn(
        'task_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Survey Code'
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
        'AC Type'
    )
    ->addColumn(
        'ac_reg',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'AC Reg'
    )
    ->addColumn(
        'ncausegroup_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Root Cause Code'
    )
    ->addColumn(
        'ncause_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Root Cause Sub Code'
    )
    ->addColumn(
        'remark_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Remark'
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
        'CoA Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'CoA Data Creation Time'
    ) 
    ->setComment('CoA Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
