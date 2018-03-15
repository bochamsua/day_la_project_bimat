<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_Permissions_Grid_Role extends Mage_Adminhtml_Block_Permissions_Grid_Role {
	protected function _prepareCollection()
	{
		$collection =  Mage::getModel("admin/roles")->getCollection();
		$collection->addFieldToFilter('role_id', array('gt'=>1));
		$this->setCollection($collection);

		if ($this->getCollection()) {

			$this->_preparePage();

			$columnId = $this->getParam($this->getVarNameSort(), $this->_defaultSort);
			$dir      = $this->getParam($this->getVarNameDir(), $this->_defaultDir);
			$filter   = $this->getParam($this->getVarNameFilter(), null);

			if (is_null($filter)) {
				$filter = $this->_defaultFilter;
			}

			if (is_string($filter)) {
				$data = $this->helper('adminhtml')->prepareFilterString($filter);
				$this->_setFilterValues($data);
			}
			else if ($filter && is_array($filter)) {
				$this->_setFilterValues($filter);
			}
			else if(0 !== sizeof($this->_defaultFilter)) {
				$this->_setFilterValues($this->_defaultFilter);
			}

			if (isset($this->_columns[$columnId]) && $this->_columns[$columnId]->getIndex()) {
				$dir = (strtolower($dir)=='desc') ? 'desc' : 'asc';
				$this->_columns[$columnId]->setDir($dir);
				$this->_setCollectionOrder($this->_columns[$columnId]);
			}

			if (!$this->_isExport) {
				$this->getCollection()->load();
				$this->_afterLoadCollection();
			}
		}

		return $this;
	}

	protected function _prepareColumns()
	{

		$this->addColumn('role_id', array(
			'header'    =>Mage::helper('adminhtml')->__('ID'),
			'index'     =>'role_id',
			'align'     => 'right',
			'width'    => '50px'
		));

		$this->addColumn('role_name', array(
			'header'    =>Mage::helper('adminhtml')->__('Role Name'),
			'index'     =>'role_name'
		));
		$this->addColumn(
			'action',
			array(
				'header'  =>  Mage::helper('adminhtml')->__('Action'),
				'width'   => '100',
				'type'    => 'action',
				'getter'  => 'getId',
				'actions' => array(
					array(
						'caption' => Mage::helper('adminhtml')->__('Edit'),
						'url'     => array('base'=> '*/*/editrole'),
						'field'   => 'rid'
					)
				),
				'filter'    => false,
				'is_system' => true,
				'sortable'  => false,
			)
		);



		return parent::_prepareColumns();
	}

}