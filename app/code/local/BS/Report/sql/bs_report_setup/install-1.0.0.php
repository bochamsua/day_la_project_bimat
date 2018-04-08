<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Report module install script
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_report/qchaneff'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'QC HAN Evaluation ID'
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
        'from_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'From Date'
    )
    ->addColumn(
        'to_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'To Date'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Inspector Id'
    )
    ->addColumn(
        'ir',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Ir'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'NCR'
    )
    ->addColumn(
        'drr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'DRR'
    )
    ->addColumn(
        'qcwork',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'QC Work'
    )
    ->addColumn(
        'd1',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'D1'
    )
    ->addColumn(
        'd2',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'D2'
    )
    ->addColumn(
        'd3',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'D3'
    )
    ->addColumn(
        'dall',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'D'
    )
    ->addColumn(
        'level',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Level'
    )
    ->addColumn(
        'note',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
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
        'QC HAN Evaluation Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'QC HAN Evaluation Creation Time'
    ) 
    ->setComment('QC HAN Evaluation Table');
$this->getConnection()->createTable($table);
$this->endSetup();
