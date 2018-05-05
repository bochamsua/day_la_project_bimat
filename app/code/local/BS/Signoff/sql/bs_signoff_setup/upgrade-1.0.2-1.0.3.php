<?php
/**
 * BS_Surveillance extension
 * 
 * @category       BS
 * @package        BS_Surveillance
 * @copyright      Copyright (c) 2016
 */
/**
 * Surveillance module install script
 *
 * @category    BS
 * @package     BS_Surveillance
 * @author Bui Phong
 */
$this->startSetup();

$this->getConnection()->changeColumn($this->getTable('bs_signoff/signoff'), 'report_date','close_date', [
    'type'      => Varien_Db_Ddl_Table::TYPE_DATE,
    'comment'   => 'Close Date'
]);

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_signoff/signoff'),
        'report_date',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_DATE,
            'after' => 'close_date',
            'comment'   => 'Start Date'
        ]
    )
;


$this->endSetup();
