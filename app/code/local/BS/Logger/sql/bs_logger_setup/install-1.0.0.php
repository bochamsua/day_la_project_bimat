<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger module install script
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_logger/logger'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Logger ID'
    )
    ->addColumn(
        'user_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'nullable'  => false,
        ],
        'User'
    )
    ->addColumn(
        'ip',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'IP Address'
    )
    ->addColumn(
        'message',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Message'
    )
    ->addColumn(
        'content',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Data'
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
        'Logger Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Logger Creation Time'
    ) 
    ->setComment('Logger Table');
$this->getConnection()->createTable($table);
$this->endSetup();
