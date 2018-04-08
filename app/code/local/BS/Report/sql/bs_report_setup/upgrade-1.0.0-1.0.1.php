<?php
$this->startSetup();
$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_report/qchaneff'),
	     'month',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Month'
         ]
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_report/qchaneff'),
	     'year',
	     [
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Year'
         ]
     )
;
$this->endSetup();
