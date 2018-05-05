<?php
/**
 * BS_Meda extension
 * 
 * @category       BS
 * @package        BS_Meda
 * @copyright      Copyright (c) 2018
 */
/**
 * MEDA admin grid block
 *
 * @category    BS
 * @package     BS_Meda
 * @author Bui Phong
 */
class BS_Meda_Block_Adminhtml_Meda_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('medaGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Meda_Block_Adminhtml_Meda_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_meda/meda')
            ->getCollection();

        $collection->getSelect()->joinLeft(['r'=>'bs_acreg_acreg'],'ac_reg = r.entity_id','reg');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Meda_Block_Adminhtml_Meda_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_meda')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
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
                'header' => Mage::helper('bs_ncr')->__('A/C Type'),
                'index'     => 'ac_type',
                'type'      => 'options',
                'options'   => $acTypes,

            ]
        );


        $this->addColumn(
            'ac_reg',
            [
                'header' => Mage::helper('bs_ncr')->__('A/C Reg'),
                'index'  => 'ac_reg',
                'type'  => 'text',
                'renderer' => 'bs_acreg/adminhtml_helper_column_renderer_acreg',
                'filter_condition_callback' => [$this, '_filterAcReg'],

            ]
        );


        $this->addColumn(
            'ins_id',
            [
                'header' => Mage::helper('bs_misc')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, true, true, true, true, false),

            ]
        );

        $this->addColumn(
            'event_date',
            [
                'header' => Mage::helper('bs_meda')->__('Event date'),
                'index'  => 'event_date',
                'type'=> 'date',

            ]
        );

        $this->addColumn(
            'meda_status',
            [
                'header' => Mage::helper('bs_meda')->__('Status'),
                'index'  => 'meda_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_meda')->convertOptions(
                    Mage::getModel('bs_meda/meda_attribute_source_medastatus')->getAllOptions(false)
                )

            ]
        );

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_meda')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_meda')->__('Enabled'),
                    '0' => Mage::helper('bs_meda')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_meda')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_meda')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_meda')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_meda')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_meda')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Meda_Block_Adminhtml_Meda_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('meda');

        $this->getMassactionBlock()->addItem('separator', [
            'label'=> '---Select---',
            'url'  => ''
        ]);
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
     * @param BS_Meda_Model_Meda
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
     * @return BS_Meda_Block_Adminhtml_Meda_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
