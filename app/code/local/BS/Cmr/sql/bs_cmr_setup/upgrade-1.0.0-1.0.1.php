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
$this->getConnection()->changeColumn($this->getTable('bs_cmr/cmr'), 'qrqn','qr', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'qr'
));
$this->getConnection()->changeColumn($this->getTable('bs_cmr/cmr'), 'investigation','ir', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'ir'
));

$this->getConnection()->changeColumn($this->getTable('bs_cmr/cmr'), 'car','drr', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
    'comment'   => 'drr'
));
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_cmr/cmr'),
        'region',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'region'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_cmr/cmr'),
        'section',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'comment'   => 'section'
        )
    )
;

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_cmr/cmr'),
        'ref_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'ref_type'
        )
    )
;
$this->endSetup();
