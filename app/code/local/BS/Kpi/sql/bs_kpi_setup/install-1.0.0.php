<?php
/**
 * BS_Kpi extension
 * 
 * @category       BS
 * @package        BS_Kpi
 * @copyright      Copyright (c) 2017
 */
/**
 * Kpi module install script
 *
 * @category    BS
 * @package     BS_Kpi
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_kpi/kpi'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'KPI Data ID'
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
        'ac_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'A/C Type'
    )
    ->addColumn(
        'mass_production',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Mass Production'
    )
    ->addColumn(
        'self_ncr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Self-decteced NCR'
    )
    ->addColumn(
        'man_hours',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Man Hours'
    )
    ->addColumn(
        'schedule_workflow',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Schedule Workflow Period'
    )
    ->addColumn(
        'actual_workflow',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Actual Workflow Period'
    )
    ->addColumn(
        'interrelationship_complaint',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Interrelationship Complaint'
    )
    ->addColumn(
        'customer_complaitn',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Customer Complaint'
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
        'KPI Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'KPI Data Creation Time'
    ) 
    ->setComment('KPI Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
