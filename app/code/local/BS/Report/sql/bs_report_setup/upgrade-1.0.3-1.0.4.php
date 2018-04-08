<?php
$this->startSetup();
$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_report/qchaneff'),
	     'remark',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
		     'comment'   => 'Remark'
         ]
     )
;

$this->endSetup();
