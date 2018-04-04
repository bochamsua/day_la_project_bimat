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
        $this->getTable('bs_sur/sur'),
        'sur_status',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'comment'   => 'status',
            'default'   => 0
        )
    )
;

$this->endSetup();