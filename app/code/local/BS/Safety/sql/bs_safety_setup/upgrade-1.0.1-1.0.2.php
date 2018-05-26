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
	     $this->getTable('bs_safety/safety'),
	     'ref_type',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
		     'after'    => 'ref_id',
		     'comment'   => 'ref_type'
         ]
     )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_safety/safety'),
        'mor',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'comment'   => 'mor'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_safety/safety'),
        'abrupt',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'abrupt'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_safety/safety'),
        'evaluation',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'evaluation'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_safety/safety'),
        'place',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'place'
        ]
    )
;


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_safety/safety'),
        'final_action',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'final action'
        ]
    )
;



$this->endSetup();
