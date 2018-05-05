<?php
/**
 * BS_Cmr extension
 * 
 * @category       BS
 * @package        BS_Cmr
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Data admin grid block
 *
 * @category    BS
 * @package     BS_Cmr
 * @author Bui Phong
 */
class BS_Cmr_Block_Adminhtml_Cmr_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('cmrGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Cmr_Block_Adminhtml_Cmr_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_cmr/cmr')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Cmr_Block_Adminhtml_Cmr_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'customer',
            [
                'header'    => Mage::helper('bs_cmr')->__('Customer'),
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

        $this->addColumn(
            'code_sqs',
            [
                'header'    => Mage::helper('bs_cmr')->__('Code SQS'),
                'align'     => 'left',
                'index'     => 'code_sqs',
            ]
        );


        $this->addColumn(
            'cmr_type',
            [
                'header' => Mage::helper('bs_ncr')->__('Type'),
                'index'     => 'cmr_type',
                'type'      => 'options',
                'options'   => [
                    '1' => Mage::helper('bs_cmr')->__('1'),
                    '2' => Mage::helper('bs_cmr')->__('2'),
                    '3' => Mage::helper('bs_cmr')->__('3'),
                    '4' => Mage::helper('bs_cmr')->__('4'),

                ],

            ]
        );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_cmr')->__('Date of Inspection'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );

        $this->addColumn(
            'description',
            [
                'header'    => Mage::helper('bs_cmr')->__('Description'),
                'align'     => 'left',
                'index'     => 'description',
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_shorter',
            ]
        );

        $this->addColumn(
            'corrective',
            [
                'header'    => Mage::helper('bs_cmr')->__('Corrective'),
                'align'     => 'left',
                'index'     => 'corrective',
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_shorter',
            ]
        );

        $this->addColumn(
            'preventive',
            [
                'header'    => Mage::helper('bs_cmr')->__('Preventive'),
                'align'     => 'left',
                'index'     => 'preventive',
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_shorter',
            ]
        );


        $this->addColumn(
            'root_cause',
            [
                'header'    => Mage::helper('bs_cmr')->__('Root Cause'),
                'align'     => 'left',
                'index'     => 'root_cause',
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_shorter',
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
            'ncr',
            [
                'header' => Mage::helper('bs_cmr')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                'options'    => [
                    '1' => Mage::helper('bs_cmr')->__('Yes'),
                    '0' => Mage::helper('bs_cmr')->__('No'),
                ]

            ]
        );
        $this->addColumn(
            'drr',
            [
                'header' => Mage::helper('bs_cmr')->__('DRR'),
                'index'  => 'drr',
                'type'    => 'options',
                'options'    => [
                    '1' => Mage::helper('bs_cmr')->__('Yes'),
                    '0' => Mage::helper('bs_cmr')->__('No'),
                ]

            ]
        );

        /*$this->addColumn(
            'code_sqs',
            array(
                'header' => Mage::helper('bs_cmr')->__('Code SQS'),
                'index'  => 'code_sqs',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'ins_id',
            array(
                'header' => Mage::helper('bs_cmr')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'dept_id',
            array(
                'header' => Mage::helper('bs_cmr')->__('Department'),
                'index'  => 'dept_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'loc_id',
            array(
                'header' => Mage::helper('bs_cmr')->__('Location'),
                'index'  => 'loc_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'report_date',
            array(
                'header' => Mage::helper('bs_cmr')->__('Date of Inspection'),
                'index'  => 'report_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'due_date',
            array(
                'header' => Mage::helper('bs_cmr')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'close_date',
            array(
                'header' => Mage::helper('bs_cmr')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'repetitive',
            array(
                'header' => Mage::helper('bs_cmr')->__('Repetitive'),
                'index'  => 'repetitive',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cmr')->__('Yes'),
                    '0' => Mage::helper('bs_cmr')->__('No'),
                )

            )
        );
        $this->addColumn(
            'cmr_type',
            array(
                'header' => Mage::helper('bs_cmr')->__('Type'),
                'index'  => 'cmr_type',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'cmr_status',
            array(
                'header' => Mage::helper('bs_cmr')->__('Status'),
                'index'  => 'cmr_status',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ir',
            array(
                'header' => Mage::helper('bs_cmr')->__('IR'),
                'index'  => 'ir',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cmr')->__('Yes'),
                    '0' => Mage::helper('bs_cmr')->__('No'),
                )

            )
        );
        $this->addColumn(
            'ncr',
            array(
                'header' => Mage::helper('bs_cmr')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cmr')->__('Yes'),
                    '0' => Mage::helper('bs_cmr')->__('No'),
                )

            )
        );
        $this->addColumn(
            'qr',
            array(
                'header' => Mage::helper('bs_cmr')->__('QR'),
                'index'  => 'qr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cmr')->__('Yes'),
                    '0' => Mage::helper('bs_cmr')->__('No'),
                )

            )
        );
        $this->addColumn(
            'drr',
            array(
                'header' => Mage::helper('bs_cmr')->__('DRR'),
                'index'  => 'drr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cmr')->__('Yes'),
                    '0' => Mage::helper('bs_cmr')->__('No'),
                )

            )
        );
        $this->addColumn(
            'task_id',
            array(
                'header' => Mage::helper('bs_cmr')->__('Survey Code'),
                'index'  => 'task_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'customer',
            array(
                'header' => Mage::helper('bs_cmr')->__('Customer'),
                'index'  => 'customer',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ac_type',
            array(
                'header' => Mage::helper('bs_cmr')->__('AC Type'),
                'index'  => 'ac_type',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ac_reg',
            array(
                'header' => Mage::helper('bs_cmr')->__('AC Reg'),
                'index'  => 'ac_reg',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ncausegroup_id',
            array(
                'header' => Mage::helper('bs_cmr')->__('Root Cause Code'),
                'index'  => 'ncausegroup_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ncause_id',
            array(
                'header' => Mage::helper('bs_cmr')->__('Root Cause Sub Code'),
                'index'  => 'ncause_id',
                'type'=> 'number',

            )
        );*/
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_cmr')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_cmr')->__('Enabled'),
                    '0' => Mage::helper('bs_cmr')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_cmr')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_cmr')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_cmr')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_cmr')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_cmr')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Cmr_Block_Adminhtml_Cmr_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('cmr');

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
     * @param BS_Cmr_Model_Cmr
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
     * @return BS_Cmr_Block_Adminhtml_Cmr_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
