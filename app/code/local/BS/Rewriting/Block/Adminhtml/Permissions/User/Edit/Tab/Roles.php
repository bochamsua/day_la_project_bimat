<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_Permissions_User_Edit_Tab_Roles extends Mage_Adminhtml_Block_Permissions_User_Edit_Tab_Roles {
	protected function _prepareCollection()
	{

		$collection = Mage::getResourceModel('admin/role_collection');
		$collection->addFieldToFilter('role_id', array('gt'=>1));

        $misc = $this->helper('bs_misc');
		if($misc->isQAAdmin()){
            $collection->addFieldToFilter('role_id', ['in'=>[9,10,11,13,14]]);
        }

        if($misc->isQCAdmin()){
            $collection->addFieldToFilter('role_id', ['in'=>[5,6,7,12]]);
        }



		$collection->setRolesFilter();
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