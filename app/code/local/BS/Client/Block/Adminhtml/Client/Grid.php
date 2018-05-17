<?php
/**
 * BS_Client extension
 * 
 * @category       BS
 * @package        BS_Client
 * @copyright      Copyright (c) 2018
 */
/**
 * Client admin grid block
 *
 * @category    BS
 * @package     BS_Client
 * @author Bui Phong
 */
class BS_Client_Block_Adminhtml_Client_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('clientGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Client_Block_Adminhtml_Client_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_client/client')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Client_Block_Adminhtml_Client_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'customer',
            [
                'header' => Mage::helper('bs_client')->__('Customer'),
                'index'  => 'customer',
                'type'=> 'number',

            ]
        );

        $this->addColumn(
            'client_id',
            [
                'header'    => Mage::helper('bs_client')->__('ID'),
                'align'     => 'left',
                'index'     => 'client_id',
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
            'approved_scope',
            [
                'header' => Mage::helper('bs_client')->__('Approved Scope'),
                'index'  => 'approved_scope',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'station',
            [
                'header' => Mage::helper('bs_client')->__('Station'),
                'index'  => 'station',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'authority',
            [
                'header' => Mage::helper('bs_client')->__('Authority'),
                'index'  => 'authority',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'approval_no',
            [
                'header' => Mage::helper('bs_client')->__('Approval Number'),
                'index'  => 'approval_no',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'issue_date',
            [
                'header' => Mage::helper('bs_client')->__('Issue Date'),
                'index'  => 'issue_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'expire_date',
            [
                'header' => Mage::helper('bs_client')->__('Expire Date'),
                'index'  => 'expire_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'remaining',
            [
                'header' => Mage::helper('bs_client')->__('Remaining'),
                'index'  => 'remaining',
                'type'=> 'number',

            ]
        );

        /*$this->addColumn(
            'client_status',
            [
                'header' => Mage::helper('bs_client')->__('Status'),
                'index'  => 'client_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_client')->convertOptions(
                    Mage::getModel('bs_client/client_attribute_source_clientstatus')->getAllOptions(false)
                )

            ]
        );*/

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_client')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_client')->__('Enabled'),
                    '0' => Mage::helper('bs_client')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_client')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_client')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_client')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_client')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_client')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Client_Block_Adminhtml_Client_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('client');

        $this->getMassactionBlock()->addItem('separator', [
            'label'=> '---Select---',
            'url'  => ''
        ]);

        $misc = Mage::helper('bs_misc');
        if($misc->canChangeInspector()){



            $this->getMassactionBlock()->addItem('change_inspector',  [
                'label'      => Mage::helper('bs_client')->__('Change Ins/Aud'),
                'url'        => $this->getUrl('*/misc_misc/massInspector',
                    [
                        'type' => 'client'
                    ]
                ),
                'additional' => [
                    'inspector' => [
                        'name'   => 'inspector',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_client')->__('Ins/Aud'),
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
     * @param BS_Client_Model_Client
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
     * @return BS_Client_Block_Adminhtml_Client_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
