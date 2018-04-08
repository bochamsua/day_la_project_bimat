<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * Hira module install script
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_hira/hira'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'HIRA ID'
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
        'generic_hazzard',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Generic Hazzard'
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
        'specify_component',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Specify component of hazzard'
    )
    ->addColumn(
        'associated_risk',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Associated risk of hazzard'
    )
    ->addColumn(
        'hira_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Type'
    )
    ->addColumn(
        'probability',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Probability of occurrent'
    )
    ->addColumn(
        'severity',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Severity of occurrent'
    )
    ->addColumn(
        'mitigation',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Mitigation'
    )
    ->addColumn(
        'hira_code',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'HIRA Code'
    )
    ->addColumn(
        'probability_after',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Probability after mitigation'
    )
    ->addColumn(
        'severity_after',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Severity after mitigation'
    )
    ->addColumn(
        'follow_up',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Follow up'
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
        'hira_status',
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
        'HIRA Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'HIRA Creation Time'
    ) 
    ->setComment('HIRA Table');
$this->getConnection()->createTable($table);
$this->endSetup();
