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
        $this->getTable('bs_hira/hira'),
        'hira_source',
        [
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'Source'
        ]
    )
;
$this->endSetup();
