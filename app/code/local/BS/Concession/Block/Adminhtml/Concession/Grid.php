<?php
/**
 * BS_Concession extension
 * 
 * @category       BS
 * @package        BS_Concession
 * @copyright      Copyright (c) 2017
 */
/**
 * Concession Data admin grid block
 *
 * @category    BS
 * @package     BS_Concession
 * @author Bui Phong
 */
class BS_Concession_Block_Adminhtml_Concession_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('concessionGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Concession_Block_Adminhtml_Concession_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_concession/concession')
            ->getCollection();

	    $collection->getSelect()->joinLeft(array('r'=>'bs_acreg_acreg'),'ac_reg = r.entity_id','reg');
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Concession_Block_Adminhtml_Concession_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_concession')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );*/
        $this->addColumn(
            'name',
            array(
                'header'    => Mage::helper('bs_concession')->__('Conc Numb'),
                'align'     => 'left',
                'index'     => 'name',
            )
        );


	    $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', array('gt' => 1))->load();
	    $inspectors = array();
	    foreach ($ins as $in) {
		    $inspectors[$in->getUserId()] = strtoupper($in->getUsername());
	    }
	    $this->addColumn(
		    'ins_id',
		    array(
			    'header'    => Mage::helper('bs_concession')->__('Inspector'),
			    'index'     => 'ins_id',
			    'type'      => 'options',
			    'options'   => $inspectors,

		    )
	    );


	    $this->addColumn(
		    'customer',
		    array(
			    'header'    => Mage::helper('bs_concession')->__('Customer'),
			    'index'     => 'customer',
			    'type'      => 'options',
			    'options'   => Mage::getResourceModel('bs_acreg/customer_collection')
			                       ->toOptionHash(),
			    //'renderer'  => 'bs_acreg/adminhtml_helper_column_renderer_parent',
			    'params'    => array(
				    'id'    => 'getCustomerId'
			    ),
			    'base_link' => 'adminhtml/acreg_customer/edit'
		    )
	    );

	    $acTypes = Mage::getModel('bs_misc/aircraft')->getCollection()->toOptionHash();
	    $this->addColumn(
		    'ac_type',
		    array(
			    'header' => Mage::helper('bs_concession')->__('A/C Type'),
			    'index'     => 'ac_type',
			    'type'      => 'options',
			    'options'   => $acTypes,

		    )
	    );


	    $this->addColumn(
		    'ac_reg',
		    array(
			    'header' => Mage::helper('bs_concession')->__('A/C Reg'),
			    'index'  => 'ac_reg',
			    'type'  => 'text',
			    'renderer' => 'bs_acreg/adminhtml_helper_column_renderer_acreg',
			    'filter_condition_callback' => array($this, '_filterAcReg'),

		    )
	    );

        $this->addColumn(
            'report_date',
            array(
                'header' => Mage::helper('bs_concession')->__('Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'reason',
            array(
                'header' => Mage::helper('bs_concession')->__('Reason'),
                'index'  => 'reason',
                'type'  => 'options',
                'options' => Mage::helper('bs_concession')->convertOptions(
                    Mage::getModel('bs_concession/concession_attribute_source_reason')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'spare_type',
            array(
                'header' => Mage::helper('bs_concession')->__('Spare Type'),
                'index'  => 'spare_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_concession')->convertOptions(
                    Mage::getModel('bs_concession/concession_attribute_source_sparetype')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'spare_do',
            array(
                'header' => Mage::helper('bs_concession')->__('Date of order'),
                'index'  => 'spare_do',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'spare_requester',
            array(
                'header' => Mage::helper('bs_concession')->__('Requester'),
                'index'  => 'spare_requester',
                'type'  => 'options',
                'options' => Mage::helper('bs_concession')->convertOptions(
                    Mage::getModel('bs_concession/concession_attribute_source_sparerequester')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'tb_type',
            array(
                'header' => Mage::helper('bs_concession')->__('TB Type'),
                'index'  => 'tb_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_concession')->convertOptions(
                    Mage::getModel('bs_concession/concession_attribute_source_tbtype')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'dt_type',
            array(
                'header' => Mage::helper('bs_concession')->__('Downtime Type'),
                'index'  => 'dt_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_concession')->convertOptions(
                    Mage::getModel('bs_concession/concession_attribute_source_dttype')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'ncr',
            array(
                'header' => Mage::helper('bs_concession')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_concession')->__('Yes'),
                    '0' => Mage::helper('bs_concession')->__('No'),
                )

            )
        );
        $this->addColumn(
            'ir',
            array(
                'header' => Mage::helper('bs_concession')->__('IR'),
                'index'  => 'ir',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_concession')->__('Yes'),
                    '0' => Mage::helper('bs_concession')->__('No'),
                )

            )
        );
        $this->addColumn(
            'qr',
            array(
                'header' => Mage::helper('bs_concession')->__('QR'),
                'index'  => 'qr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_concession')->__('Yes'),
                    '0' => Mage::helper('bs_concession')->__('No'),
                )

            )
        );
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_concession')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_concession')->__('Enabled'),
                    '0' => Mage::helper('bs_concession')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_concession')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_concession')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_concession')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_concession')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_concession')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Concession_Block_Adminhtml_Concession_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('concession');
        $this->getMassactionBlock()->addItem('separator', array(
            'label'=> '---Select---',
            'url'  => ''
        ));

//        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_data/concession/edit");
//        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_data/concession/delete");
//
//	    $user = Mage::getSingleton('admin/session')->getUser();
//	    $adminUserId = $user->getUserId();
//	    $roleId = Mage::getModel('admin/user')->load($adminUserId)->getRole()->getRoleId();
//
//	    if(in_array($roleId, array(1,16))){
//		    $this->getMassactionBlock()->addItem(
//			    'delete',
//			    array(
//				    'label'=> Mage::helper('bs_concession')->__('Delete'),
//				    'url'  => $this->getUrl('*/*/massDelete'),
//				    'confirm'  => Mage::helper('bs_concession')->__('Are you sure?')
//			    )
//		    );
//		    $this->getMassactionBlock()->addItem(
//			    'reason',
//			    array(
//				    'label'      => Mage::helper('bs_concession')->__('Change Reason'),
//				    'url'        => $this->getUrl('*/*/massReason', array('_current'=>true)),
//				    'additional' => array(
//					    'flag_reason' => array(
//						    'name'   => 'flag_reason',
//						    'type'   => 'select',
//						    'class'  => 'required-entry',
//						    'label'  => Mage::helper('bs_concession')->__('Reason'),
//						    'values' => Mage::getModel('bs_concession/concession_attribute_source_reason')
//						                    ->getAllOptions(true),
//
//					    )
//				    )
//			    )
//		    );
//		    $this->getMassactionBlock()->addItem(
//			    'spare_type',
//			    array(
//				    'label'      => Mage::helper('bs_concession')->__('Change Spare Type'),
//				    'url'        => $this->getUrl('*/*/massSpareType', array('_current'=>true)),
//				    'additional' => array(
//					    'flag_spare_type' => array(
//						    'name'   => 'flag_spare_type',
//						    'type'   => 'select',
//						    'class'  => 'required-entry',
//						    'label'  => Mage::helper('bs_concession')->__('Spare Type'),
//						    'values' => Mage::getModel('bs_concession/concession_attribute_source_sparetype')
//						                    ->getAllOptions(true),
//
//					    )
//				    )
//			    )
//		    );
//		    $this->getMassactionBlock()->addItem(
//			    'spare_requester',
//			    array(
//				    'label'      => Mage::helper('bs_concession')->__('Change Requester'),
//				    'url'        => $this->getUrl('*/*/massSpareRequester', array('_current'=>true)),
//				    'additional' => array(
//					    'flag_spare_requester' => array(
//						    'name'   => 'flag_spare_requester',
//						    'type'   => 'select',
//						    'class'  => 'required-entry',
//						    'label'  => Mage::helper('bs_concession')->__('Requester'),
//						    'values' => Mage::getModel('bs_concession/concession_attribute_source_sparerequester')
//						                    ->getAllOptions(true),
//
//					    )
//				    )
//			    )
//		    );
//		    $this->getMassactionBlock()->addItem(
//			    'tb_type',
//			    array(
//				    'label'      => Mage::helper('bs_concession')->__('Change Troubleshooting Type'),
//				    'url'        => $this->getUrl('*/*/massTbType', array('_current'=>true)),
//				    'additional' => array(
//					    'flag_tb_type' => array(
//						    'name'   => 'flag_tb_type',
//						    'type'   => 'select',
//						    'class'  => 'required-entry',
//						    'label'  => Mage::helper('bs_concession')->__('Troubleshooting Type'),
//						    'values' => Mage::getModel('bs_concession/concession_attribute_source_tbtype')
//						                    ->getAllOptions(true),
//
//					    )
//				    )
//			    )
//		    );
//		    $this->getMassactionBlock()->addItem(
//			    'dt_type',
//			    array(
//				    'label'      => Mage::helper('bs_concession')->__('Change Downtime Type'),
//				    'url'        => $this->getUrl('*/*/massDtType', array('_current'=>true)),
//				    'additional' => array(
//					    'flag_dt_type' => array(
//						    'name'   => 'flag_dt_type',
//						    'type'   => 'select',
//						    'class'  => 'required-entry',
//						    'label'  => Mage::helper('bs_concession')->__('Downtime Type'),
//						    'values' => Mage::getModel('bs_concession/concession_attribute_source_dttype')
//						                    ->getAllOptions(true),
//
//					    )
//				    )
//			    )
//		    );
//	    }

        return $this;
    }

	protected function _filterAcReg($collection, $column)
	{
		if (!$value = $column->getFilter()->getValue()) {
			return $this;
		}

		$this->getCollection()->getSelect()->where(
			"reg LIKE ?"
			, "%$value%");


		return $this;
	}

    /**
     * get the row url
     *
     * @access public
     * @param BS_Concession_Model_Concession
     * @return string
     * @author Bui Phong
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Bui Phong
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return BS_Concession_Block_Adminhtml_Concession_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
