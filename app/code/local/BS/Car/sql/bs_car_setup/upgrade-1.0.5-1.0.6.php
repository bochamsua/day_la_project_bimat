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

$table = $this->getTable('bs_car/car');

$this->getConnection()
    ->addColumn(
        $table,
        'corrective_action',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,

            'comment'   => 'root_cause'
        ]
    )
;


$this->endSetup();