<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Supplier admin grid block
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Block_Adminhtml_Sup_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('supGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Sup_Block_Adminhtml_Sup_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_sup/sup')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Sup_Block_Adminhtml_Sup_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_sup')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            ]
        );*/
        $this->addColumn(
            'sup_code',
            [
                'header'    => Mage::helper('bs_sup')->__('ID'),
                'align'     => 'left',
                'index'     => 'sup_code',
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
            'cert_no',
            [
                'header' => Mage::helper('bs_sup')->__('Cert No'),
                'index'  => 'cert_no',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'sup_class',
            [
                'header' => Mage::helper('bs_sup')->__('Class'),
                'index'  => 'sup_class',
                'type'  => 'options',
                'options' => Mage::helper('bs_sup')->convertOptions(
                    Mage::getModel('bs_sup/sup_attribute_source_supclass')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'rating',
            [
                'header' => Mage::helper('bs_sup')->__('Rating'),
                'index'  => 'rating',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'issue_date',
            [
                'header' => Mage::helper('bs_sup')->__('Issue Date'),
                'index'  => 'issue_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'expire_date',
            [
                'header' => Mage::helper('bs_sup')->__('Expire Date'),
                'index'  => 'expire_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'remaining',
            [
                'header' => Mage::helper('bs_sup')->__('Remaining'),
                'index'  => 'remaining',
                'type'=> 'number',

            ]
        );

        /*$this->addColumn(
            'sup_status',
            [
                'header' => Mage::helper('bs_sup')->__('Status'),
                'index'  => 'sup_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_sup')->convertOptions(
                    Mage::getModel('bs_sup/sup_attribute_source_supstatus')->getAllOptions(false)
                )

            ]
        );*/

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_sup')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_sup')->__('Enabled'),
                    '0' => Mage::helper('bs_sup')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_sup')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_sup')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_sup')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_sup')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_sup')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Sup_Block_Adminhtml_Sup_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('sup');

        $this->getMassactionBlock()->addItem('separator', [
            'label'=> '---Select---',
            'url'  => ''
        ]);

        $misc = Mage::helper('bs_misc');
        if($misc->canChangeInspector()){



            $this->getMassactionBlock()->addItem('change_inspector',  [
                'label'      => Mage::helper('bs_sup')->__('Change Ins/Aud'),
                'url'        => $this->getUrl('*/misc_misc/massInspector',
                    [
                        'type' => 'sup'
                    ]
                ),
                'additional' => [
                    'inspector' => [
                        'name'   => 'inspector',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_sup')->__('Ins/Aud'),
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
     * @param BS_Sup_Model_Sup
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
     * @return BS_Sup_Block_Adminhtml_Sup_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
