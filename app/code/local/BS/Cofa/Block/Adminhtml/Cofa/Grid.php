<?php
/**
 * BS_Cofa extension
 * 
 * @category       BS
 * @package        BS_Cofa
 * @copyright      Copyright (c) 2017
 */
/**
 * CoA Data admin grid block
 *
 * @category    BS
 * @package     BS_Cofa
 * @author Bui Phong
 */
class BS_Cofa_Block_Adminhtml_Cofa_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('cofaGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Cofa_Block_Adminhtml_Cofa_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_cofa/cofa')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Cofa_Block_Adminhtml_Cofa_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {


        $this->addColumn(
            'code_sqs',
            [
                'header'    => Mage::helper('bs_cofa')->__('Code SQS'),
                'align'     => 'left',
                'index'     => 'code_sqs',
            ]
        );


        $this->addColumn(
            'cofa_type',
            [
                'header' => Mage::helper('bs_ncr')->__('Type'),
                'index'     => 'cofa_type',
                'type'      => 'options',
                'options'   => [
                    '1' => Mage::helper('bs_cofa')->__('1'),
                    '2' => Mage::helper('bs_cofa')->__('2'),
                    '3' => Mage::helper('bs_cofa')->__('3'),
                    '4' => Mage::helper('bs_cofa')->__('4'),

                ],

            ]
        );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_cofa')->__('Date of Inspection'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );

        $this->addColumn(
            'description',
            [
                'header'    => Mage::helper('bs_cofa')->__('Description'),
                'align'     => 'left',
                'index'     => 'description',
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_shorter',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
        );

        $this->addColumn(
            'corrective',
            [
                'header'    => Mage::helper('bs_cofa')->__('Corrective'),
                'align'     => 'left',
                'index'     => 'corrective',
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_shorter',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
        );

        $this->addColumn(
            'preventive',
            [
                'header'    => Mage::helper('bs_cofa')->__('Preventive'),
                'align'     => 'left',
                'index'     => 'preventive',
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_shorter',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
        );


        $this->addColumn(
            'root_cause',
            [
                'header'    => Mage::helper('bs_cofa')->__('Root Cause'),
                'align'     => 'left',
                'index'     => 'root_cause',
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_shorter',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
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
            'ncr',
            [
                'header' => Mage::helper('bs_cofa')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                'options'    => [
                    '1' => Mage::helper('bs_cofa')->__('Yes'),
                    '0' => Mage::helper('bs_cofa')->__('No'),
                ]

            ]
        );
        $this->addColumn(
            'drr',
            [
                'header' => Mage::helper('bs_cofa')->__('DRR'),
                'index'  => 'drr',
                'type'    => 'options',
                'options'    => [
                    '1' => Mage::helper('bs_cofa')->__('Yes'),
                    '0' => Mage::helper('bs_cofa')->__('No'),
                ]

            ]
        );

        /*$this->addColumn(
            'code_sqs',
            array(
                'header' => Mage::helper('bs_cofa')->__('Code SQS'),
                'index'  => 'code_sqs',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'ins_id',
            array(
                'header' => Mage::helper('bs_cofa')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'dept_id',
            array(
                'header' => Mage::helper('bs_cofa')->__('Department'),
                'index'  => 'dept_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'loc_id',
            array(
                'header' => Mage::helper('bs_cofa')->__('Location'),
                'index'  => 'loc_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'report_date',
            array(
                'header' => Mage::helper('bs_cofa')->__('Date of Inspection'),
                'index'  => 'report_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'due_date',
            array(
                'header' => Mage::helper('bs_cofa')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'close_date',
            array(
                'header' => Mage::helper('bs_cofa')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'repetitive',
            array(
                'header' => Mage::helper('bs_cofa')->__('Repetitive'),
                'index'  => 'repetitive',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cofa')->__('Yes'),
                    '0' => Mage::helper('bs_cofa')->__('No'),
                )

            )
        );
        $this->addColumn(
            'cofa_type',
            array(
                'header' => Mage::helper('bs_cofa')->__('Type'),
                'index'  => 'cofa_type',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'cofa_status',
            array(
                'header' => Mage::helper('bs_cofa')->__('Status'),
                'index'  => 'cofa_status',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ir',
            array(
                'header' => Mage::helper('bs_cofa')->__('IR'),
                'index'  => 'ir',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cofa')->__('Yes'),
                    '0' => Mage::helper('bs_cofa')->__('No'),
                )

            )
        );
        $this->addColumn(
            'ncr',
            array(
                'header' => Mage::helper('bs_cofa')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cofa')->__('Yes'),
                    '0' => Mage::helper('bs_cofa')->__('No'),
                )

            )
        );
        $this->addColumn(
            'qr',
            array(
                'header' => Mage::helper('bs_cofa')->__('QR'),
                'index'  => 'qr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cofa')->__('Yes'),
                    '0' => Mage::helper('bs_cofa')->__('No'),
                )

            )
        );
        $this->addColumn(
            'drr',
            array(
                'header' => Mage::helper('bs_cofa')->__('DRR'),
                'index'  => 'drr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_cofa')->__('Yes'),
                    '0' => Mage::helper('bs_cofa')->__('No'),
                )

            )
        );
        $this->addColumn(
            'task_id',
            array(
                'header' => Mage::helper('bs_cofa')->__('Survey Code'),
                'index'  => 'task_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'customer',
            array(
                'header' => Mage::helper('bs_cofa')->__('Customer'),
                'index'  => 'customer',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ac_type',
            array(
                'header' => Mage::helper('bs_cofa')->__('AC Type'),
                'index'  => 'ac_type',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ac_reg',
            array(
                'header' => Mage::helper('bs_cofa')->__('AC Reg'),
                'index'  => 'ac_reg',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ncausegroup_id',
            array(
                'header' => Mage::helper('bs_cofa')->__('Root Cause Code'),
                'index'  => 'ncausegroup_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ncause_id',
            array(
                'header' => Mage::helper('bs_cofa')->__('Root Cause Sub Code'),
                'index'  => 'ncause_id',
                'type'=> 'number',

            )
        );*/
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_cofa')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_cofa')->__('Enabled'),
                    '0' => Mage::helper('bs_cofa')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_cofa')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_cofa')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_cofa')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_cofa')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_cofa')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Cofa_Block_Adminhtml_Cofa_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('cofa');

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
     * @param BS_Cofa_Model_Cofa
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
     * @return BS_Cofa_Block_Adminhtml_Cofa_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
