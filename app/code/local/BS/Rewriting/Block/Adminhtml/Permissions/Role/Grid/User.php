<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_Permissions_Role_Grid_User extends Mage_Adminhtml_Block_Permissions_Role_Grid_User {
	protected function _prepareCollection()
	{
		$roleId = $this->getRequest()->getParam('rid');
		Mage::register('RID', $roleId);
		$collection = Mage::getModel('admin/roles')->getUsersCollection()->addFieldToFilter('user_id', array('gt'=>1));
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
}