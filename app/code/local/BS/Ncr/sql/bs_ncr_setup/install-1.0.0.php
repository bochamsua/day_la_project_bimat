<?php
/**
 * BS_Ncr extension
 * 
 * @category       BS
 * @package        BS_Ncr
 * @copyright      Copyright (c) 2016
 */
/**
 * Ncr module install script
 *
 * @category    BS
 * @package     BS_Ncr
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_ncr/ncr'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Ncr ID'
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
        'ncr_source',
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
        'REF Doc'
    )
    ->addColumn(
        'ac',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'A/C'
    )
    ->addColumn(
        'ncr_type',
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
        'ncr_status',
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
        'ref_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'unsigned'  => true,
        ],
        'Reference Id'
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
        'Ncr Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Ncr Creation Time'
    ) 
    ->setComment('Ncr Table');
$this->getConnection()->createTable($table);
$this->endSetup();
