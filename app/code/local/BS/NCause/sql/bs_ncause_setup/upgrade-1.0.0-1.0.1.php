<?php
$this->startSetup();
$this->getConnection()
     ->addColumn(
	     $this->getTable('bs_ncause/ncause'),
         'points',
         [
             'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
             'comment'   => 'Mass Points'
         ]
     )
;


$this->endSetup();
