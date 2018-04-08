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
$table = $this->getTable('bs_rii/rii');
$this->getConnection()->modifyColumn($table, 'ac_reg', 'int(10) NULL default NULL');
$this->getConnection()->modifyColumn($table, 'customer', 'int(10) NULL default NULL');


$this->getConnection()
    ->addColumn(
        $this->getTable('bs_rii/rii'),
        'ac_type',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'AC Type'
        ]
    )
;


$this->endSetup();
