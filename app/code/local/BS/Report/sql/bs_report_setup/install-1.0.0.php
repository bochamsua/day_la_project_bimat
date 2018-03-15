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
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'QC HAN Evaluation ID'
    )
    ->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Name'
    )
    ->addColumn(
        'from_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'From Date'
    )
    ->addColumn(
        'to_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'To Date'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Inspector Id'
    )
    ->addColumn(
        'ir',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Ir'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'NCR'
    )
    ->addColumn(
        'drr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'DRR'
    )
    ->addColumn(
        'qcwork',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'QC Work'
    )
    ->addColumn(
        'd1',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'D1'
    )
    ->addColumn(
        'd2',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'D2'
    )
    ->addColumn(
        'd3',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'D3'
    )
    ->addColumn(
        'dall',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'D'
    )
    ->addColumn(
        'level',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Level'
    )
    ->addColumn(
        'note',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Note'
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
        array(),
        'QC HAN Evaluation Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'QC HAN Evaluation Creation Time'
    ) 
    ->setComment('QC HAN Evaluation Table');
$this->getConnection()->createTable($table);
$this->endSetup();
