<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * A/C Reg admin grid block
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Block_Adminhtml_Acreg_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('acregGrid');
        $this->setDefaultSort('reg');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Acreg_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_acreg/acreg')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Acreg_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_acreg')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false,
            ]
        );
        $this->addColumn(
            'customer_id',
            [
                'header'    => Mage::helper('bs_acreg')->__('Customer'),
                'index'     => 'customer_id',
                'type'      => 'options',
                'options'   => Mage::getResourceModel('bs_acreg/customer_collection')
                    ->toOptionHash(),
                'renderer'  => 'bs_acreg/adminhtml_helper_column_renderer_parent',
                'params'    => [
                    'id'    => 'getCustomerId'
                ],
                'base_link' => 'adminhtml/acreg_customer/edit'
            ]
        );



	    $this->addColumn(
		    'ac_type',
		    [
			    'header'    => Mage::helper('bs_acreg')->__('A/C Type'),
			    'index'     => 'ac_type',
			    'type'      => 'options',
			    'options'   => Mage::getResourceModel('bs_misc/aircraft_collection')
			                       ->toOptionHash(),

            ]
	    );

	    $this->addColumn(
		    'reg',
		    [
			    'header'    => Mage::helper('bs_acreg')->__('Number'),
			    'align'     => 'left',
			    'index'     => 'reg',
            ]
	    );


//        $this->addColumn(
//            'action',
//            array(
//                'header'  =>  Mage::helper('bs_acreg')->__('Action'),
//                'width'   => '100',
//                'type'    => 'action',
//                'getter'  => 'getId',
//                'actions' => array(
//                    array(
//                        'caption' => Mage::helper('bs_acreg')->__('Edit'),
//                        'url'     => array('base'=> '*/*/edit'),
//                        'field'   => 'id'
//                    )
//                ),
//                'filter'    => false,
//                'is_system' => true,
//                'sortable'  => false,
//            )
//        );
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_acreg')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_acreg')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_acreg')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Acreg_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('acreg');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_misc/acreg/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_misc/acreg/delete");

        $this->getMassactionBlock()->addItem(
            'do-nothing',
            [
                'label'=> Mage::helper('adminhtml')->__('---Select--'),
                'url'  => '',

            ]
        );


        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Acreg_Model_Acreg
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
     * @return BS_Acreg_Block_Adminhtml_Acreg_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
