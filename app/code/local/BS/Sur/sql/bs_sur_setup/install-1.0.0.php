<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Sur module install script
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_sur/sur'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Surveillance ID'
    )
    ->addColumn(
        'ref_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Reference No'
    )
    ->addColumn(
        'role_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Role'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Inspector'
    )
    ->addColumn(
        'dept_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Maint. Center'
    )
    ->addColumn(
        'loc_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Location'
    )
    ->addColumn(
        'ac_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'AC Type'
    )
    ->addColumn(
        'ac_reg',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'A/C Reg'
    )
    ->addColumn(
        'wp',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Work Pack'
    )
    ->addColumn(
        'customer',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Customer'
    )
    ->addColumn(
        'flight_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Flight Number'
    )
    ->addColumn(
        'report_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Date of Inspection'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Description'
    )
    ->addColumn(
        'task_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Survey Code'
    )
    ->addColumn(
        'subtask_id',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Subtask'
    )
    ->addColumn(
        'check_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Check Type'
    )
    ->addColumn(
        'region',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'nullable'  => false,
        ),
        'Region'
    )
    ->addColumn(
        'section',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Section'
    )
    ->addColumn(
        'ncr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'NCR'
    )
    ->addColumn(
        'qr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'QR'
    )
    ->addColumn(
        'drr',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'DRR'
    )
    ->addColumn(
        'car',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'CAR'
    )
    ->addColumn(
        'ir',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'IR'
    )
    ->addColumn(
        'qn',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'QN'
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
        'Surveillance Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Surveillance Creation Time'
    ) 
    ->setComment('Surveillance Table');
$this->getConnection()->createTable($table);
$this->endSetup();
