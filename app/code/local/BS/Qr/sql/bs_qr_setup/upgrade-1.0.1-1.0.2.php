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
        $this->getTable('bs_qr/qr'),
        'region',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'section',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'ref_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'source_other',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'source_other'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_qr/qr'),
        'self_remark',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'self_remark'
        ]
    )
;


$this->getConnection()->changeColumn($this->getTable('bs_qr/qr'), 'qrqn_type','qr_type', [
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'qr_type'
]);

$this->getConnection()->changeColumn($this->getTable('bs_qr/qr'), 'qrqn_source','qr_source', [
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'qr_source'
]);

$this->getConnection()->changeColumn($this->getTable('bs_qr/qr'), 'qrqn_status','qr_status', [
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'qr_type'
]);

$this->endSetup();
