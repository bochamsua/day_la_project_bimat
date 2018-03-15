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
$this->getConnection()->changeColumn($this->getTable('bs_sur/sur'), 'ac_reg','ac_reg', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'comment'   => 'ac_reg'
));

$this->getConnection()
    ->addColumn(
        $this->getTable('bs_sur/sur'),
        'mandatory_items',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'comment'   => 'mandatory_items'
        )
    )
;

$this->endSetup();
