<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * NCause module install script
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_ncause/ncausegroup'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Root Cause Code ID'
    )
    ->addColumn(
        'group_code',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Group Code'
    )
    ->addColumn(
        'group_name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
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
        'Root Cause Code Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Root Cause Code Creation Time'
    ) 
    ->setComment('Root Cause Code Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('bs_ncause/ncause'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Cause ID'
    )
    ->addColumn(
        'ncausegroup_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'unsigned'  => true,
        ],
        'Root Cause Code ID'
    )
    ->addColumn(
        'cause_code',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Cause Code'
    )
    ->addColumn(
        'cause_name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Cause Name'
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
        'Cause Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Cause Creation Time'
    ) 
    ->addIndex($this->getIdxName('bs_ncause/ncausegroup', ['ncausegroup_id']), ['ncausegroup_id'])
    ->setComment('Cause Table');
$this->getConnection()->createTable($table);
$this->endSetup();
