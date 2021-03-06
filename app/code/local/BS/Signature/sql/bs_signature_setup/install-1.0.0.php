<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature module install script
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_signature/signature'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Signature ID'
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
        'signature',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Signature'
    )
    ->addColumn(
        'update_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Date'
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
        'Signature Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Signature Creation Time'
    ) 
    ->setComment('Signature Table');
$this->getConnection()->createTable($table);
$this->endSetup();
