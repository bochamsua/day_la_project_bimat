<?php
$this->startSetup();
$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_misc/subtask'),
	     'is_mandatory',
	     array(
		     'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
		     'comment'   => 'Mandatory'
	     )
     )
;


$this->endSetup();
