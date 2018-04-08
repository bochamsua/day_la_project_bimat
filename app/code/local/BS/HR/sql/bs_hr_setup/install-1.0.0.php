<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * HR module install script
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
$this->startSetup();
/*$table = $this->getConnection()
    ->newTable($this->getTable('bs_hr/inspector'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Inspector ID'
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
        'vaeco_id',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'VAECO ID'
    )
    ->addColumn(
        'dob',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        array(),
        'Date of Birth'
    )
    ->addColumn(
        'phone',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Phone'
    )
    ->addColumn(
        'caav_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'CAAV Number'
    )
    ->addColumn(
        'crs_no',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'CRS Number'
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
        'Inspector Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Inspector Creation Time'
    ) 
    ->setComment('Inspector Table');
$this->getConnection()->createTable($table);*/
$table = $this->getConnection()
    ->newTable($this->getTable('bs_hr/certificate'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Certificate ID'
    )
    ->addColumn(
        'cert_desc',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Description'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Inspector'
    )
    ->addColumn(
        'crs_approved',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'CRS Approved Date'
    )
    ->addColumn(
        'crs_expire',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'CRS Expire Date'
    )
    ->addColumn(
        'caav_approved',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'CAAV Approved Date'
    )
    ->addColumn(
        'caav_expire',
        Varien_Db_Ddl_Table::TYPE_DATETIME, 255,
        [],
        'CAAV Expire Date'
    )
    ->addColumn(
        'ac_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Aircraft'
    )
    ->addColumn(
        'certtype_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Cert Type'
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
        'Certificate Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Certificate Creation Time'
    ) 
    ->setComment('Certificate Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('bs_hr/training'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ],
        'Training ID'
    )
    ->addColumn(
        'training_desc',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        [
            'nullable'  => false,
        ],
        'Description'
    )
    ->addColumn(
        'ins_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        [],
        'Inspector'
    )
    ->addColumn(
        'type_training',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Completed Type training course for at least 2 months?'
    )
    ->addColumn(
        'line_six',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Line maintenance experience for at least 6 months? '
    )
    ->addColumn(
        'base_six',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Base maintenance experience for at least 6 months '
    )
    ->addColumn(
        'crs_a',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Holding CRS A certificate for at least 14 months?'
    )
    ->addColumn(
        'line_twelve',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Line maintenance experience for at least 12 months?'
    )
    ->addColumn(
        'base_twelve',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Base maintenance experience for at least 12 months?'
    )
    ->addColumn(
        'crs_b',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Hoding CRS B certificate for at least 38 months?'
    )
    ->addColumn(
        'line_twentyfour',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Line maintenance experience for at least 24 months?'
    )
    ->addColumn(
        'base_twentyfour',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        [],
        'Base maintenance experience for at least 24 months?'
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
        'Training Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [],
        'Training Creation Time'
    ) 
    ->setComment('Training Table');
$this->getConnection()->createTable($table);
$this->endSetup();
