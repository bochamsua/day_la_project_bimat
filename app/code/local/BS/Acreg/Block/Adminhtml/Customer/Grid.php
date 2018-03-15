<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Customer admin grid block
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('customerGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Customer_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_acreg/customer')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Customer_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_acreg')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );
        $this->addColumn(
            'name',
            array(
                'header'    => Mage::helper('bs_acreg')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
            )
        );
        

        $this->addColumn(
            'code',
            array(
                'header' => Mage::helper('bs_acreg')->__('Code'),
                'index'  => 'code',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'note',
            array(
                'header' => Mage::helper('bs_acreg')->__('Note'),
                'index'  => 'note',
                'type'=> 'text',

            )
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
     * @return BS_Acreg_Block_Adminhtml_Customer_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {


        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('customer');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_misc/customer/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_misc/customer/delete");

        $this->getMassactionBlock()->addItem('separator', array(
            'label'=> '---Select---',
            'url'  => ''
        ));

        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Acreg_Model_Customer
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
     * @return BS_Acreg_Block_Adminhtml_Customer_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
