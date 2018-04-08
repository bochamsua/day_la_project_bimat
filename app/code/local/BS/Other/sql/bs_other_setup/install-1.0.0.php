<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other module install script
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_other/other'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Other Work ID'
    )
    ->addColumn(
        'ref_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Reference No'
    )
    ->addColumn(
        'date_report',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Date of Repot'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Description'
    )
    ->addColumn(
        'customer',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Customer'
    )
    ->addColumn(
        'ac_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'A/C Type'
    )
    ->addColumn(
        'ac_reg',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'A/C Reg'
    )
    ->addColumn(
        'loc_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Location'
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
        'Other Work Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Other Work Creation Time'
    ) 
    ->setComment('Other Work Table');
$this->getConnection()->createTable($table);
$this->endSetup();
