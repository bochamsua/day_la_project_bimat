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
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_signature/signature'),
        'user_id',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'User Id'
        ]
    )
;

$this->endSetup();
