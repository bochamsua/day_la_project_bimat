<?php
/**
 * BS_Concession extension
 * 
 * @category       BS
 * @package        BS_Concession
 * @copyright      Copyright (c) 2017
 */
/**
 * Concession Data module install script
 *
 * @category    BS
 * @package     BS_Concession
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_concession/concession'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Concession Data ID'
    )
    ->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Concession Data Number'
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
        'report_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Date'
    )
    ->addColumn(
        'source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Source'
    )
    ->addColumn(
        'reason',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'nullable'  => false,
        ],
        'Reason'
    )
    ->addColumn(
        'spare_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Spare Type'
    )
    ->addColumn(
        'spare_do',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Date of order'
    )
    ->addColumn(
        'spare_requester',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Requester'
    )
    ->addColumn(
        'tb_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Troubleshooting Type'
    )
    ->addColumn(
        'dt_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Downtime Type'
    )
    ->addColumn(
        'reason_source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Source of reason'
    )
    ->addColumn(
        'cause',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Cause'
    )
    ->addColumn(
        'remark',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Remark'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'NCR'
    )
    ->addColumn(
        'ir',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'IR'
    )
    ->addColumn(
        'qrqn',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'QR'
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
        'Concession Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Concession Data Creation Time'
    ) 
    ->setComment('Concession Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
