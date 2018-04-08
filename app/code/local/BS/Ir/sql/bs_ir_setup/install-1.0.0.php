<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir module install script
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_ir/ir'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Ir ID'
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
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Inspector'
    )
    ->addColumn(
        'dept_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Maint. Center'
    )
    ->addColumn(
        'loc_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Location'
    )
    ->addColumn(
        'ac_reg',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'A/C Reg'
    )
    ->addColumn(
        'inspection_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Date of Inspection'
    )
    ->addColumn(
        'wp',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Workpack'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Description'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'NCR'
    )
    ->addColumn(
        'qr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'QR'
    )
    ->addColumn(
        'drr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'DRR'
    )
    ->addColumn(
        'task_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Task ID'
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
        'Ir Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Ir Creation Time'
    ) 
    ->setComment('Ir Table');
$this->getConnection()->createTable($table);
$this->endSetup();
