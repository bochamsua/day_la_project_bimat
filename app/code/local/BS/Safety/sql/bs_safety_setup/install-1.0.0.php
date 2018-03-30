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
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Safety Data ID'
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
        'safety_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Type'
    )
    ->addColumn(
        'occur_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Occurrent Date'
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
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Description'
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
        'remark_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Remark'
    )
    ->addColumn(
        'from_dept',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'From Dept'
    )
    ->addColumn(
        'to_dept',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'To Dept'
    )
    ->addColumn(
        'from_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'From'
    )
    ->addColumn(
        'related_personel',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Related Personel'
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
        'safety_status',
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
        'Safety Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Safety Data Creation Time'
    ) 
    ->setComment('Safety Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
