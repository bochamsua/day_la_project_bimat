<?php
/**
 * BS_Surveillance extension
 * 
 * @category       BS
 * @package        BS_Surveillance
 * @copyright      Copyright (c) 2016
 */
/**
 * Surveillance module install script
 *
 * @category    BS
 * @package     BS_Surveillance
 * @author Bui Phong
 */
$this->startSetup();

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_rii/rii'),
        'region',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_rii/rii'),
        'section',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_rii/rii'),
        'ref_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        )
    )
;


$this->getConnection()->changeColumn($this->getTable('bs_rii/rii'), 'inspection_date','report_date', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_DATE,
    'comment'   => 'Report Date'
));

$this->getConnection()->changeColumn($this->getTable('bs_rii/rii'), 'investigation','ir', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'investigation'
));

$this->getConnection()->changeColumn($this->getTable('bs_rii/rii'), 'qrqn','qr', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'qr'
));


$this->endSetup();
