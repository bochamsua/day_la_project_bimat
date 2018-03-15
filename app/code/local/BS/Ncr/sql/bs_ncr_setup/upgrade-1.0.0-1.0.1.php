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
        $this->getTable('bs_ncr/ncr'),
        'is_submitted',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Is Submitted'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'task_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Task Id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'subtask_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Sub Task Id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'ac_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'AC Type'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'customer',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Customer'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'ac_reg',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'AC Reg'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'dept_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Dept'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'loc_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'Location'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'remark_text',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'Remark text'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'ncausegroup_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncausegroup_id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'ncause_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'ncause_id'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'repetitive',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'repetitive'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'error_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'error_type'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'short_desc',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'short desc'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_ncr/ncr'),
        'point',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'comment'   => 'point'
        )
    )
;



$this->endSetup();
