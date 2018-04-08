<?php
/**
 * BS_Routine extension
 * 
 * @category       BS
 * @package        BS_Routine
 * @copyright      Copyright (c) 2017
 */
/**
 * Routine module install script
 *
 * @category    BS
 * @package     BS_Routine
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_routine/routine'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Routine Report ID'
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
        'Routine Report Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Routine Report Creation Time'
    ) 
    ->setComment('Routine Report Table');
$this->getConnection()->createTable($table);
$this->endSetup();
