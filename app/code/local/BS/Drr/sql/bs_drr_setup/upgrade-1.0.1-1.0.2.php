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
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'section',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'ref_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        )
    )
;



$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'source_other',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'source_other'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_drr/drr'),
        'self_remark',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'self_remark'
        )
    )
;

$this->getConnection()->changeColumn($this->getTable('bs_drr/drr'), 'car_status','drr_status', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'drr_status'
));

$this->getConnection()->changeColumn($this->getTable('bs_drr/drr'), 'car_source','drr_source', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'drr_source'
));

$this->getConnection()->changeColumn($this->getTable('bs_drr/drr'), 'car_type','drr_type', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'drr_type'
));

$this->endSetup();
