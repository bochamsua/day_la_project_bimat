<?php

$this->startSetup();
$table = $this->getConnection()
              ->newTable($this->getTable('bs_hr/staff'))
              ->addColumn(
	              'entity_id',
	              Varien_Db_Ddl_Table::TYPE_INTEGER,
	              null,
	              [
		              'identity'  => true,
		              'nullable'  => false,
		              'primary'   => true,
                  ],
	              'Staff ID'
              )
              ->addColumn(
	              'user_id',
	              Varien_Db_Ddl_Table::TYPE_INTEGER, null,
	              [
		              'nullable'  => false,
                  ],
	              'Admin User'
              )
              ->addColumn(
	              'room',
	              Varien_Db_Ddl_Table::TYPE_INTEGER, null,
	              [],
	              'Room'
              )
              ->addColumn(
	              'region',
	              Varien_Db_Ddl_Table::TYPE_INTEGER, null,
	              [],
	              'Region'
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
	              'Staff Modification Time'
              )
              ->addColumn(
	              'created_at',
	              Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
	              null,
	              [],
	              'Staff Creation Time'
              )
              ->setComment('Staff Table');
$this->getConnection()->createTable($table);


$this->endSetup();
