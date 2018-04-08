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
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_rii/rii'),
        'section',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_rii/rii'),
        'ref_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        ]
    )
;


$this->getConnection()->changeColumn($this->getTable('bs_rii/rii'), 'inspection_date','report_date', [
    'type'      => Varien_Db_Ddl_Table::TYPE_DATE,
    'comment'   => 'Report Date'
]);

$this->getConnection()->changeColumn($this->getTable('bs_rii/rii'), 'investigation','ir', [
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'investigation'
]);

$this->getConnection()->changeColumn($this->getTable('bs_rii/rii'), 'qrqn','qr', [
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'qr'
]);


$this->endSetup();
