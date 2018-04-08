<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * Rii module install script
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
$this->startSetup();

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'region',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'section',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'ref_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        ]
    )
;



$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'source_other',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'source_other'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'self_remark',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'self_remark'
        ]
    )
;

$this->getConnection()->changeColumn($this->getTable('bs_drr/drr'), 'car_status','drr_status', [
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'drr_status'
]);

$this->getConnection()->changeColumn($this->getTable('bs_drr/drr'), 'car_source','drr_source', [
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'drr_source'
]);

$this->getConnection()->changeColumn($this->getTable('bs_drr/drr'), 'car_type','drr_type', [
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'drr_type'
]);

$this->endSetup();
