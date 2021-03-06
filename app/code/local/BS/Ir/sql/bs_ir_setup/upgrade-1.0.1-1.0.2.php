<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2016
 */
/**
 * Surveillance module install script
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
$this->startSetup();
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'ref_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'region',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'section',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'source_other',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'source_other'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'self_remark',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'self_remark'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'point',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'comment'   => 'point'
        ]
    )
;


$this->getConnection()->changeColumn($this->getTable('bs_ir/ir'), 'inv_status','ir_status', [
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'ir_status'
]);

$this->getConnection()->changeColumn($this->getTable('bs_ir/ir'), 'qrqn','qr', [
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'qr'
]);

$this->getConnection()->changeColumn($this->getTable('bs_ir/ir'), 'car','drr', [
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'drr'
]);

$this->getConnection()->changeColumn($this->getTable('bs_ir/ir'), 'inv_source','ir_source', [
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'ir_source'
]);



$this->endSetup();
