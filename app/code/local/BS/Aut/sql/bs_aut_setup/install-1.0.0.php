<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Aut module install script
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_aut/aut'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Authority ID'
    )
    ->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Authority'
    )
    ->addColumn(
        'aut_id',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'ID'
    )
    ->addColumn(
        'approved_scope',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Approved Scope'
    )
    ->addColumn(
        'station',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Station'
    )
    ->addColumn(
        'approval_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Approval Number'
    )
    ->addColumn(
        'aut_source',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Source'
    )
    ->addColumn(
        'issue_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Issue Date'
    )
    ->addColumn(
        'expire_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Expire Date'
    )
    ->addColumn(
        'remaining',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Remaining'
    )
    ->addColumn(
        'remark_text',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Remark'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Inspector'
    )
    ->addColumn(
        'aut_status',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Status'
    )
    ->addColumn(
        'section',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Section'
    )
    ->addColumn(
        'region',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(),
        'Region'
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
        [],
        'Authority Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Authority Creation Time'
    ) 
    ->setComment('Authority Table');
$this->getConnection()->createTable($table);
$this->endSetup();
