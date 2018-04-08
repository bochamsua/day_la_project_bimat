<?php
$this->startSetup();
$table = $this->getConnection()
              ->newTable($this->getTable('bs_report/setting'))
              ->addColumn(
	              'entity_id',
	              Varien_Db_Ddl_Table::TYPE_INTEGER,
	              null,
	              [
		              'identity'  => true,
		              'nullable'  => false,
		              'primary'   => true,
                  ],
	              'Setting ID'
              )
              ->addColumn(
	              'code',
	              Varien_Db_Ddl_Table::TYPE_TEXT, 255,
	              [
		              'nullable'  => false,
                  ],
	              'Code'
              )
              ->addColumn(
	              'value',
	              Varien_Db_Ddl_Table::TYPE_TEXT, 255,
	              [],
	              'Value'
              )
              ->addColumn(
	              'note',
	              Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
	              [],
	              'Note'
              )
              ->addColumn(
	              'status',
	              Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
	              [],
	              'Enabled'
              )
              ->addColumn(
	              'updated_at',
	              Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
	              null,
	              [],
	              'Setting Modification Time'
              )
              ->addColumn(
	              'created_at',
	              Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
	              null,
	              [],
	              'Setting Creation Time'
              )
              ->setComment('Setting Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
              ->newTable($this->getTable('bs_report/workday'))
              ->addColumn(
	              'entity_id',
	              Varien_Db_Ddl_Table::TYPE_INTEGER,
	              null,
	              [
		              'identity'  => true,
		              'nullable'  => false,
		              'primary'   => true,
                  ],
	              'Work Day ID'
              )
              ->addColumn(
	              'month',
	              Varien_Db_Ddl_Table::TYPE_INTEGER, null,
	              [],
	              'Month'
              )
              ->addColumn(
	              'year',
	              Varien_Db_Ddl_Table::TYPE_INTEGER, null,
	              [],
	              'Year'
              )
              ->addColumn(
	              'days',
	              Varien_Db_Ddl_Table::TYPE_TEXT, 255,
	              [
		              'nullable'  => false,
                  ],
	              'Days'
              )
              ->addColumn(
	              'status',
	              Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
	              [],
	              'Enabled'
              )
              ->addColumn(
	              'updated_at',
	              Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
	              null,
	              [],
	              'Work Day Modification Time'
              )
              ->addColumn(
	              'created_at',
	              Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
	              null,
	              [],
	              'Work Day Creation Time'
              )
              ->setComment('Work Day Table');
$this->getConnection()->createTable($table);

$this->endSetup();
