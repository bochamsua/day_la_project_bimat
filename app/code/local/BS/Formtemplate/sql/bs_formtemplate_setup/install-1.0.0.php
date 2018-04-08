<?php
/**
 * BS_Formtemplate extension
 * 
 * @category       BS
 * @package        BS_Formtemplate
 * @copyright      Copyright (c) 2015
 */
/**
 * Formtemplate module install script
 *
 * @category    BS
 * @package     BS_Formtemplate
 * @author Bui Phong
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('bs_formtemplate/formtemplate'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Form Template ID'
    )
    ->addColumn(
        'template_name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Name'
    )
    ->addColumn(
        'template_code',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'Code'
    )
    ->addColumn(
        'template_file',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [],
        'File'
    )
    ->addColumn(
        'template_date',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'Approved Date'
    )
    ->addColumn(
        'template_revision',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Revision'
    )
    ->addColumn(
        'template_note',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
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
        'Form Template Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Form Template Creation Time'
    ) 
    ->setComment('Form Template Table');
$this->getConnection()->createTable($table);
$this->endSetup();
