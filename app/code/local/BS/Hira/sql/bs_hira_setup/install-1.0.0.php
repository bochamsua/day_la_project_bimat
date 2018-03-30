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
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'HIRA ID'
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
        'generic_hazzard',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Generic Hazzard'
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
        'specify_component',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Specify component of hazzard'
    )
    ->addColumn(
        'associated_risk',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Associated risk of hazzard'
    )
    ->addColumn(
        'hira_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Type'
    )
    ->addColumn(
        'probability',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Probability of occurrent'
    )
    ->addColumn(
        'severity',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Severity of occurrent'
    )
    ->addColumn(
        'mitigation',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Mitigation'
    )
    ->addColumn(
        'hira_code',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'HIRA Code'
    )
    ->addColumn(
        'probability_after',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Probability after mitigation'
    )
    ->addColumn(
        'severity_after',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Severity after mitigation'
    )
    ->addColumn(
        'follow_up',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Follow up'
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
        'hira_status',
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
        'HIRA Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'HIRA Creation Time'
    ) 
    ->setComment('HIRA Table');
$this->getConnection()->createTable($table);
$this->endSetup();
