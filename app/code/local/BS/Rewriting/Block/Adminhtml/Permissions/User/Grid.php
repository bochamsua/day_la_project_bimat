<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_Permissions_User_Grid extends Mage_Adminhtml_Block_Permissions_User_Grid {
	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('admin/user_collection');
		$collection->addFieldToFilter('user_id', ['gt'=>1]);

        $misc = $this->helper('bs_misc');
        $currentUser = $misc->getCurrentUserInfo();
        if($misc->isQAAdmin()){
            $collection->addFieldToFilter('region', $currentUser[2]);
            $collection->addFieldToFilter('section', $currentUser[3]);
            $collection->getSelect()->where("user_id IN (SELECT user_id FROM admin_role WHERE parent_id IN(9,10,11,13,14))");
        }

        if($misc->isQCAdmin()){
            $collection->addFieldToFilter('region', $currentUser[2]);
            $collection->addFieldToFilter('section', $currentUser[3]);
            $collection->getSelect()->where("user_id IN (SELECT user_id FROM admin_role WHERE parent_id IN(5,6,7,12))");
        }


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
		$this->addColumn('user_id', array(
			'header'    => Mage::helper('adminhtml')->__('ID'),
			'width'     => 5,
			'align'     => 'right',
			'sortable'  => true,
			'index'     => 'user_id'
		));

		$this->addColumn('username', array(
			'header'    => Mage::helper('adminhtml')->__('User Name'),
			'index'     => 'username'
		));

		$this->addColumn('firstname', array(
			'header'    => Mage::helper('adminhtml')->__('First Name'),
			'index'     => 'firstname'
		));

		$this->addColumn('lastname', array(
			'header'    => Mage::helper('adminhtml')->__('Last Name'),
			'index'     => 'lastname'
		));

        $this->addColumn(
            'region',
            array(
                'header' => Mage::helper('bs_sur')->__('Region'),
                'index'  => 'region',
                'type'  => 'options',
                'options' => Mage::helper('bs_sur')->convertOptions(
                    Mage::getModel('bs_sur/sur_attribute_source_region')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'section',
            array(
                'header' => Mage::helper('bs_sur')->__('Section'),
                'index'  => 'section',
                'type'  => 'options',
                'options' => Mage::helper('bs_sur')->convertOptions(
                    Mage::getModel('bs_sur/sur_attribute_source_section')->getAllOptions(false)
                )

            )
        );

		$this->addColumn('vaeco_id', array(
			'header'    => Mage::helper('adminhtml')->__('VAECO ID'),
			'index'     => 'vaeco_id'
		));

		$this->addColumn('crs_no', array(
			'header'    => Mage::helper('adminhtml')->__('CRS No'),
			'index'     => 'crs_no'
		));


		$this->addColumn('email', array(
			'header'    => Mage::helper('adminhtml')->__('Email'),
			'width'     => 40,
			'align'     => 'left',
			'index'     => 'email'
		));

		$this->addColumn('is_active', array(
			'header'    => Mage::helper('adminhtml')->__('Status'),
			'index'     => 'is_active',
			'type'      => 'options',
			'options'   => array('1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')),
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
						'url'     => array('base'=> '*/*/edit'),
						'field'   => 'user_id'
					)
				),
				'filter'    => false,
				'is_system' => true,
				'sortable'  => false,
			)
		);


		$this->sortColumnsByOrder();
		return $this;
	}
}