<?php
/**
 * BS_Setting extension
 * 
 * @category       BS
 * @package        BS_Setting
 * @copyright      Copyright (c) 2017
 */
/**
 * Setting module install script
 *
 * @category    BS
 * @package     BS_Setting
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_setting/field'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Field Dependance ID'
    )
    ->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Field Name Suffix'
    )
    ->addColumn(
        'definition',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Dependences Definition'
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
        'Field Dependance Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Field Dependance Creation Time'
    ) 
    ->setComment('Field Dependance Table');
$this->getConnection()->createTable($table);
$this->endSetup();
