<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Sup module install script
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
$this->startSetup();

$table = $this->getTable('bs_sup/sup');

$this->getConnection()
    ->addColumn(
        $table,
        'sup_address',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,

            'comment'   => 'address'
        ]
    )
;


$this->endSetup();
