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
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'region',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'section',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'source_other',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'source_other'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'self_remark',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'self_remark'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ir/ir'),
        'point',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'comment'   => 'point'
        )
    )
;


$this->getConnection()->changeColumn($this->getTable('bs_ir/ir'), 'inv_status','ir_status', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'ir_status'
));

$this->getConnection()->changeColumn($this->getTable('bs_ir/ir'), 'qrqn','qr', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'qr'
));

$this->getConnection()->changeColumn($this->getTable('bs_ir/ir'), 'car','drr', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'drr'
));

$this->getConnection()->changeColumn($this->getTable('bs_ir/ir'), 'inv_source','ir_source', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'ir_source'
));



$this->endSetup();
