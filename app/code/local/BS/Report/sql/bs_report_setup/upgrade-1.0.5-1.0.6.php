<?php
$this->startSetup();

$this->getConnection()->changeColumn($this->getTable('bs_report/qchaneff'), 'inv','ir', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'comment'   => 'IR'
));

$this->endSetup();
