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
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Surveillance ID'
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
        'role_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Role'
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
        'ac_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'AC Type'
    )
    ->addColumn(
        'ac_reg',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'A/C Reg'
    )
    ->addColumn(
        'wp',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Work Pack'
    )
    ->addColumn(
        'customer',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Customer'
    )
    ->addColumn(
        'flight_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Flight Number'
    )
    ->addColumn(
        'report_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Date of Inspection'
    )
    ->addColumn(
        'description',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Description'
    )
    ->addColumn(
        'task_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Survey Code'
    )
    ->addColumn(
        'subtask_id',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        [],
        'Subtask'
    )
    ->addColumn(
        'check_type',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Check Type'
    )
    ->addColumn(
        'region',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [
            'nullable'  => false,
        ],
        'Region'
    )
    ->addColumn(
        'section',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Section'
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
        'car',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'CAR'
    )
    ->addColumn(
        'ir',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'IR'
    )
    ->addColumn(
        'qn',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'QN'
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
        'Surveillance Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Surveillance Creation Time'
    ) 
    ->setComment('Surveillance Table');
$this->getConnection()->createTable($table);
$this->endSetup();
