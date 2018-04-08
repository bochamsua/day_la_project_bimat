<?php
/**
 * BS_KPIReport extension
 * 
 * @category       BS
 * @package        BS_KPIReport
 * @copyright      Copyright (c) 2017
 */
/**
 * KPIReport module install script
 *
 * @category    BS
 * @package     BS_KPIReport
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_kpireport/kpireport'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'KPI Report ID'
    )
    ->addColumn(
        'dept_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'nullable'  => false,
        ],
        'Department'
    )
    ->addColumn(
        'month',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Month'
    )
    ->addColumn(
        'year',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Year'
    )
    ->addColumn(
        'qsr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Quality Surveillance Rate'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Non-Comformity Rate'
    )
    ->addColumn(
        'mncr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Mass Non-Comformity Rate'
    )
    ->addColumn(
        'mer',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Maintenance Error Rate'
    )
    ->addColumn(
        'ser',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'System Error Rate'
    )
    ->addColumn(
        'rer',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Repetitive Error Rate'
    )
    ->addColumn(
        'camt',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Corrective Action Mean Time'
    )
    ->addColumn(
        'sdr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Self-Detected Rate'
    )
    ->addColumn(
        'csr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Customer Satisfaction Rate'
    )
    ->addColumn(
        'cir',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Continuous Improvement Rate'
    )
    ->addColumn(
        'mir',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Man-power Improvement Rate'
    )
    ->addColumn(
        'ppe',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Production Planning Efficiency'
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
        'KPI Report Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'KPI Report Creation Time'
    ) 
    ->setComment('KPI Report Table');
$this->getConnection()->createTable($table);
$this->endSetup();
