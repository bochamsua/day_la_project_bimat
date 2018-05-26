<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Imex module install script
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_imex/im'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Import ID'
    )
    ->addColumn(
        'ref_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Ref No'
    )
    ->addColumn(
        'im_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Type'
    )
    ->addColumn(
        'im_source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Source'
    )
    ->addColumn(
        'im_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Import Date'
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
        'Import Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Import Creation Time'
    ) 
    ->setComment('Import Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('bs_imex/ex'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Export ID'
    )
    ->addColumn(
        'ref_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Ref No'
    )
    ->addColumn(
        'ex_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Type'
    )
    ->addColumn(
        'ex_source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Source'
    )
    ->addColumn(
        'ex_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Export Date'
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
        'Export Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Export Creation Time'
    ) 
    ->setComment('Export Table');
$this->getConnection()->createTable($table);
$this->endSetup();
