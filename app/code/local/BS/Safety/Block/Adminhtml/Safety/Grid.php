<?php
/**
 * BS_Safety extension
 * 
 * @category       BS
 * @package        BS_Safety
 * @copyright      Copyright (c) 2018
 */
/**
 * Safety Data admin grid block
 *
 * @category    BS
 * @package     BS_Safety
 * @author Bui Phong
 */
class BS_Safety_Block_Adminhtml_Safety_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('safetyGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Safety_Block_Adminhtml_Safety_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_safety/safety')
            ->getCollection();

        $collection->getSelect()->joinLeft(array('r'=>'bs_acreg_acreg'),'ac_reg = r.entity_id','reg');
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Safety_Block_Adminhtml_Safety_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'ref_no',
            array(
                'header'    => Mage::helper('bs_safety')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            )
        );

        $this->addColumn(
            'safety_type',
            array(
                'header' => Mage::helper('bs_safety')->__('Type'),
                'index'  => 'safety_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_safety')->convertOptions(
                    Mage::getModel('bs_safety/safety_attribute_source_safetytype')->getAllOptions(false)
                )

            )
        );



        $this->addColumn(
            'customer',
            array(
                'header'    => Mage::helper('bs_acreg')->__('Customer'),
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
                'header' => Mage::helper('bs_ncr')->__('A/C Type'),
                'index'     => 'ac_type',
                'type'      => 'options',
                'options'   => $acTypes,

            )
        );


        $this->addColumn(
            'ac_reg',
            array(
                'header' => Mage::helper('bs_ncr')->__('A/C Reg'),
                'index'  => 'ac_reg',
                'type'  => 'text',
                'renderer' => 'bs_acreg/adminhtml_helper_column_renderer_acreg',
                'filter_condition_callback' => array($this, '_filterAcReg'),

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
                'header'    => Mage::helper('bs_misc')->__('Inspector'),
                'index'     => 'ins_id',
                'type'      => 'options',
                'options'   => $inspectors,

            )
        );

        $depts = Mage::getResourceModel('bs_misc/department_collection');
        $depts = $depts->toOptionHash();
        $this->addColumn(
            'from_dept',
            array(
                'header'    => Mage::helper('bs_misc')->__('From Maint. Center'),
                'index'     => 'from_dept',
                'type'      => 'options',
                'options'   => $depts,

            )
        );

        $this->addColumn(
            'to_dept',
            array(
                'header'    => Mage::helper('bs_misc')->__('To Maint. Center'),
                'index'     => 'to_dept',
                'type'      => 'options',
                'options'   => $depts,

            )
        );


        $this->addColumn(
            'related_personel',
            array(
                'header'    => Mage::helper('bs_safety')->__('Related Personel'),
                'align'     => 'left',
                'index'     => 'related_personel',
            )
        );


        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_safety')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_safety')->__('Enabled'),
                    '0' => Mage::helper('bs_safety')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_safety')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_safety')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_safety')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_safety')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_safety')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Safety_Block_Adminhtml_Safety_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('safety');

        $this->getMassactionBlock()->addItem('separator', array(
            'label'=> '---Select---',
            'url'  => ''
        ));

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
     * @param BS_Safety_Model_Safety
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
     * @return BS_Safety_Block_Adminhtml_Safety_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
