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

$this->getConnection()->changeColumn($table, 'close_date','res_date', [
    'type'      => Varien_Db_Ddl_Table::TYPE_DATE,
    'comment'   => 'Res Date'
]);

$this->getConnection()
    ->addColumn(
        $table,
        'close_date',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_DATE,
            'after' => 'res_date',
            'comment'   => 'Close Date'
        ]
    )
;

$this->getConnection()
    ->addColumn(
        $table,
        'res_status',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'after' => 'car_status',
            'comment'   => 'Res Status'
        ]
    )
;


$this->endSetup();