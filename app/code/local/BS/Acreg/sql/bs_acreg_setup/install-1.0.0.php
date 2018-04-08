<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Acreg module install script
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_acreg/customer'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Customer ID'
    )
    ->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Name'
    )
    ->addColumn(
        'code',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Code'
    )
    ->addColumn(
        'note',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Note'
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
        'Customer Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Customer Creation Time'
    ) 
    ->setComment('Customer Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('bs_acreg/acreg'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'A/C Reg ID'
    )
    ->addColumn(
        'customer_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'unsigned'  => true,
        ],
        'Customer ID'
    )
    ->addColumn(
        'reg',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Number'
    )
    ->addColumn(
        'ac_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'A/C Type'
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
        'A/C Reg Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'A/C Reg Creation Time'
    ) 
    ->addIndex($this->getIdxName('bs_acreg/customer', ['customer_id']), ['customer_id'])
    ->setComment('A/C Reg Table');
$this->getConnection()->createTable($table);
$this->endSetup();
