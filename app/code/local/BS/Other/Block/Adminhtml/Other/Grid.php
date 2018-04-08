<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other Work admin grid block
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
class BS_Other_Block_Adminhtml_Other_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('otherGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Other_Block_Adminhtml_Other_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_other/other')
            ->getCollection();


        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Other_Block_Adminhtml_Other_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_other')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            ]
        );
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_other')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );

	    $tasks = Mage::getResourceModel('bs_misc/task_collection');
	    $tasks->addFieldToFilter('taskgroup_id', [
		    'in' => [4,5,10]
        ]);

	    $tasks = $tasks->toOptionHash();


	    $this->addColumn(
		    'task_id',
		    [
			    'header' => Mage::helper('bs_other')->__('Survey Code'),
			    'index'  => 'task_id',
			    'type'  => 'options',
			    'options'   => $tasks,

            ]
	    );

	    $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1])->load();
	    $inspectors = [];
	    foreach ($ins as $in) {
		    $inspectors[$in->getUserId()] = strtoupper($in->getUsername());
	    }
	    $this->addColumn(
		    'ins_id',
		    [
			    'header'    => Mage::helper('bs_other')->__('Inspector'),
			    'index'     => 'ins_id',
			    'type'      => 'options',
			    'options'   => $inspectors,

            ]
	    );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_other')->__('Date of Repot'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
	    $this->addColumn(
		    'customer',
		    [
			    'header'    => Mage::helper('bs_acreg')->__('Customer'),
			    'index'     => 'customer',
			    'type'      => 'options',
			    'options'   => Mage::getResourceModel('bs_acreg/customer_collection')
			                       ->toOptionHash(),
			    //'renderer'  => 'bs_acreg/adminhtml_helper_column_renderer_parent',
			    'params'    => [
				    'id'    => 'getCustomerId'
                ],
			    'base_link' => 'adminhtml/acreg_customer/edit'
            ]
	    );

	    $acTypes = Mage::getModel('bs_misc/aircraft')->getCollection()->toOptionHash();
	    $this->addColumn(
		    'ac_type',
		    [
			    'header' => Mage::helper('bs_rii')->__('A/C Type'),
			    'index'     => 'ac_type',
			    'type'      => 'options',
			    'options'   => $acTypes,

            ]
	    );

	    $acregs = Mage::getModel('bs_acreg/acreg')->getCollection()->toOptionHash();
	    $this->addColumn(
		    'ac_reg',
		    [
			    'header' => Mage::helper('bs_rii')->__('A/C Reg'),
			    'index'     => 'ac_reg',
			    'type'      => 'options',
			    'options'   => $acregs,

            ]
	    );
	    $locs = Mage::getResourceModel('bs_misc/location_collection');
	    $locs = $locs->toOptionHash();
	    $this->addColumn(
		    'loc_id',
		    [
			    'header'    => Mage::helper('bs_misc')->__('Location'),
			    'index'     => 'loc_id',
			    'type'      => 'options',
			    'options'   => $locs,

            ]
	    );
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_other')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_other')->__('Enabled'),
                    '0' => Mage::helper('bs_other')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_other')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_other')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_other')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_other')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_other')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Other_Block_Adminhtml_Other_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('other');

        $this->getMassactionBlock()->addItem('separator', [
            'label'=> '---Select---',
            'url'  => ''
        ]);
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Other_Model_Other
     * @return string
     * @author Bui Phong
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/grid', ['_current'=>true]);
    }


    /**
     * after collection load
     *
     * @access protected
     * @return BS_Other_Block_Adminhtml_Other_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
