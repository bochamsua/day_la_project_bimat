<?php
$this->startSetup();
$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_report/qchaneff'),
	     'qr',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
		     'comment'   => 'qr'
         ]
     )
;

$this->endSetup();
