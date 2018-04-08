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
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'KPI Data ID'
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
        'ac_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'A/C Type'
    )
    ->addColumn(
        'mass_production',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Mass Production'
    )
    ->addColumn(
        'self_ncr',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Self-decteced NCR'
    )
    ->addColumn(
        'man_hours',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Man Hours'
    )
    ->addColumn(
        'schedule_workflow',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Schedule Workflow Period'
    )
    ->addColumn(
        'actual_workflow',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Actual Workflow Period'
    )
    ->addColumn(
        'interrelationship_complaint',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Interrelationship Complaint'
    )
    ->addColumn(
        'customer_complaitn',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Customer Complaint'
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
        'KPI Data Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'KPI Data Creation Time'
    ) 
    ->setComment('KPI Data Table');
$this->getConnection()->createTable($table);
$this->endSetup();
