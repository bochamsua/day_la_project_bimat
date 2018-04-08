<?php
/**
 * BS_Safety extension
 * 
 * @category       BS
 * @package        BS_Safety
 * @copyright      Copyright (c) 2018
 */
/**
 * Safety module install script
 *
 * @category    BS
 * @package     BS_Safety
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_safety/safety'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Safety Data ID'
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
        'safety_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Type'
    )
    ->addColumn(
        'occur_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Occurrent Date'
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
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Description'
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
        'remark_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Remark'
    )
    ->addColumn(
        'from_dept',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'From Dept'
    )
    ->addColumn(
        'to_dept',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'To Dept'
    )
    ->addColumn(
        'from_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'From'
    )
    ->addColumn(
        'related_personel',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Related Personel'
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
        'safety_status',
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
        'Safety Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Safety Data Creation Time'
    ) 
    ->setComment('Safety Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
