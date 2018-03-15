<?php
$this->startSetup();
$this->getConnection()
    ->addColumn(
        $this->getTable('bs_misc/subtask'),
        'points',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment'   => 'Mass Points'
        )
    )
;


$this->endSetup();
