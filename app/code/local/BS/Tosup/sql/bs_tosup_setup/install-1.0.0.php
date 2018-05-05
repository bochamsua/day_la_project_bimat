<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tosup module install script
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_tosup/tosup'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Tool Supplier ID'
    )
    ->addColumn(
        'tosup_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'No'
    )
    ->addColumn(
        'organization',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Organization'
    )
    ->addColumn(
        'address',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Address'
    )
    ->addColumn(
        'amasis_class',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Amasis Code Class'
    )
    ->addColumn(
        'tosup_source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Source'
    )
    ->addColumn(
        'issue_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Issue Date'
    )
    ->addColumn(
        'expire_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Expire Date'
    )
    ->addColumn(
        'approved_scope',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Approved Scope'
    )
    ->addColumn(
        'remaining',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Remaining'
    )
    ->addColumn(
        'remark_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Remark'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Inspector'
    )
    ->addColumn(
        'tosup_status',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Status'
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
        [],
        'Tool Supplier Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Tool Supplier Creation Time'
    ) 
    ->setComment('Tool Supplier Table');
$this->getConnection()->createTable($table);
$this->endSetup();
