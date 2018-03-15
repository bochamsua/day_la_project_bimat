<?php
$this->startSetup();
$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_report/qchaneff'),
	     'month',
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Month'
	     )
     )
;

$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_report/qchaneff'),
	     'year',
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		     'comment'   => 'Year'
	     )
     )
;
$this->endSetup();
