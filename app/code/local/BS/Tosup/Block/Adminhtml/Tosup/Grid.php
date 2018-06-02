<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tool Supplier admin grid block
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Block_Adminhtml_Tosup_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('tosupGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Tosup_Block_Adminhtml_Tosup_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_tosup/tosup')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Tosup_Block_Adminhtml_Tosup_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'tosup_no',
            [
                'header'    => Mage::helper('bs_tosup')->__('No'),
                'align'     => 'left',
                'index'     => 'tosup_no',
            ]
        );

        $this->addColumn(
            'ins_id',
            [
                'header' => Mage::helper('bs_misc')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, true, true, true, true, false,false, false),
            ]
        );
        

        $this->addColumn(
            'organization',
            [
                'header' => Mage::helper('bs_tosup')->__('Organization'),
                'index'  => 'organization',
                'type'=> 'text',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
        );
        $this->addColumn(
            'address',
            [
                'header' => Mage::helper('bs_tosup')->__('Address'),
                'index'  => 'address',
                'type'=> 'text',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
        );
        $this->addColumn(
            'amasis_class',
            [
                'header' => Mage::helper('bs_tosup')->__('Amasis Code Class'),
                'index'  => 'amasis_class',
                'type'=> 'text',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
        );
        $this->addColumn(
            'issue_date',
            [
                'header' => Mage::helper('bs_tosup')->__('Issue Date'),
                'index'  => 'issue_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'expire_date',
            [
                'header' => Mage::helper('bs_tosup')->__('Expire Date'),
                'index'  => 'expire_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'approved_scope',
            [
                'header' => Mage::helper('bs_tosup')->__('Approved Scope'),
                'index'  => 'approved_scope',
                'type'=> 'text',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
        );
        $this->addColumn(
            'remaining',
            [
                'header' => Mage::helper('bs_tosup')->__('Remaining'),
                'index'  => 'remaining',
                'type'=> 'number',

            ]
        );


        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_tosup')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_tosup')->__('Enabled'),
                    '0' => Mage::helper('bs_tosup')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_tosup')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_tosup')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_tosup')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_tosup')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_tosup')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Tosup_Block_Adminhtml_Tosup_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('tosup');

        $this->getMassactionBlock()->addItem('separator', [
            'label'=> '---Select---',
            'url'  => ''
        ]);

        $misc = Mage::helper('bs_misc');
        if($misc->canChangeInspector()){



            $this->getMassactionBlock()->addItem('change_inspector',  [
                'label'      => Mage::helper('bs_tosup')->__('Change Ins/Aud'),
                'url'        => $this->getUrl('*/misc_misc/massInspector',
                    [
                        'type' => 'tosup'
                    ]
                ),
                'additional' => [
                    'inspector' => [
                        'name'   => 'inspector',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_tosup')->__('Ins/Aud'),
                        'values' => Mage::helper('bs_misc/user')->getUsersByManager(true, true)
                    ]
                ]
            ]);



        }
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Tosup_Model_Tosup
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
     * @return BS_Tosup_Block_Adminhtml_Tosup_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
