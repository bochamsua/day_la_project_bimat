<?php
$this->startSetup();
$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_misc/task'),
	     'points',
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
		     'comment'   => 'Points'
	     )
     )
;


$this->endSetup();
