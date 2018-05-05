<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Sup module install script
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_sup/sup'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Supplier ID'
    )
    ->addColumn(
        'sup_code',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'ID'
    )
    ->addColumn(
        'sup_name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Supplier Name'
    )
    ->addColumn(
        'cert_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Cert No'
    )
    ->addColumn(
        'sup_class',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Class'
    )
    ->addColumn(
        'rating',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Rating'
    )
    ->addColumn(
        'sup_source',
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
        'sup_status',
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
        'Supplier Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Supplier Creation Time'
    ) 
    ->setComment('Supplier Table');
$this->getConnection()->createTable($table);
$this->endSetup();
