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
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Concession Data ID'
    )
    ->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Concession Data Number'
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
        'AC Type'
    )
    ->addColumn(
        'ac_reg',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'AC Reg'
    )
    ->addColumn(
        'report_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Date'
    )
    ->addColumn(
        'source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Source'
    )
    ->addColumn(
        'reason',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'nullable'  => false,
        ),
        'Reason'
    )
    ->addColumn(
        'spare_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Spare Type'
    )
    ->addColumn(
        'spare_do',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Date of order'
    )
    ->addColumn(
        'spare_requester',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Requester'
    )
    ->addColumn(
        'tb_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Troubleshooting Type'
    )
    ->addColumn(
        'dt_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Downtime Type'
    )
    ->addColumn(
        'reason_source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Source of reason'
    )
    ->addColumn(
        'cause',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Cause'
    )
    ->addColumn(
        'remark',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Remark'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'NCR'
    )
    ->addColumn(
        'ir',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'IR'
    )
    ->addColumn(
        'qrqn',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'QR'
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
        'Concession Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Concession Data Creation Time'
    ) 
    ->setComment('Concession Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
