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
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'KPI Report ID'
    )
    ->addColumn(
        'dept_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'nullable'  => false,
        ),
        'Department'
    )
    ->addColumn(
        'month',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Month'
    )
    ->addColumn(
        'year',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Year'
    )
    ->addColumn(
        'qsr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Quality Surveillance Rate'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Non-Comformity Rate'
    )
    ->addColumn(
        'mncr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Mass Non-Comformity Rate'
    )
    ->addColumn(
        'mer',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Maintenance Error Rate'
    )
    ->addColumn(
        'ser',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'System Error Rate'
    )
    ->addColumn(
        'rer',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Repetitive Error Rate'
    )
    ->addColumn(
        'camt',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Corrective Action Mean Time'
    )
    ->addColumn(
        'sdr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Self-Detected Rate'
    )
    ->addColumn(
        'csr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Customer Satisfaction Rate'
    )
    ->addColumn(
        'cir',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Continuous Improvement Rate'
    )
    ->addColumn(
        'mir',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Man-power Improvement Rate'
    )
    ->addColumn(
        'ppe',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Production Planning Efficiency'
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
        'KPI Report Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'KPI Report Creation Time'
    ) 
    ->setComment('KPI Report Table');
$this->getConnection()->createTable($table);
$this->endSetup();
