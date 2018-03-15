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
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($installer->getTable('admin/user'), 'region', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'nullable' => true,
    'default' => null,
    'comment' => 'region'
));

$installer->getConnection()->addColumn($installer->getTable('admin/user'), 'section', array(
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'nullable' => true,
    'default' => null,
    'comment' => 'section'
));

$this->endSetup();
