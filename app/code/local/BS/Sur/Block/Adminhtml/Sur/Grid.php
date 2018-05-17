<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Surveillance admin grid block
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Block_Adminhtml_Sur_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('surGrid');
        $this->setDefaultSort('ref_no');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Sur_Block_Adminhtml_Sur_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_sur/sur')
            ->getCollection();

        $collection->getSelect()->joinLeft(['r'=>'bs_acreg_acreg'],'ac_reg = r.entity_id','reg');
        $collection->getSelect()->joinLeft(['t'=>'bs_misc_task'],'task_id = t.entity_id','task_code');
        $collection->getSelect()->joinLeft(['s'=>'bs_misc_subtask'],'subtask_id = s.entity_id','sub_code');
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Sur_Block_Adminhtml_Sur_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_sur')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );*/

       /* $this->addColumn(
            'region',
            array(
                'header' => Mage::helper('bs_sur')->__('Region'),
                'index'  => 'region',
                'type'  => 'options',
                'options' => Mage::helper('bs_sur')->convertOptions(
                    Mage::getModel('bs_sur/sur_attribute_source_region')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'section',
            array(
                'header' => Mage::helper('bs_sur')->__('Section'),
                'index'  => 'section',
                'type'  => 'options',
                'options' => Mage::helper('bs_sur')->convertOptions(
                    Mage::getModel('bs_sur/sur_attribute_source_section')->getAllOptions(false)
                )

            )
        );*/

        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_sur')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
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
            'dept_id',
            [
                'header'    => Mage::helper('bs_misc')->__('Maint. Center'),
                'index'     => 'dept_id',
                'type'      => 'options',
                'options'   => $this->helper('bs_misc/dept')->getDepts(false, true, false),

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
                'filter_index'     => 'main_table.ac_type',
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


        /*$this->addColumn(
            'wp',
            array(
                'header' => Mage::helper('bs_sur')->__('Work Pack'),
                'index'  => 'wp',
                'type'=> 'text',

            )
        );

        $this->addColumn(
            'flight_no',
            array(
                'header' => Mage::helper('bs_sur')->__('Flight Number'),
                'index'  => 'flight_no',
                'type'=> 'text',

            )
        );*/
        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_sur')->__('Date of Inspection'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'task_id',
            [
                'header' => Mage::helper('bs_sur')->__('Sur Code'),
                'index'  => 'task_id',
                'type'  => 'text',
                'renderer' => 'bs_misc/adminhtml_helper_column_renderer_task',
                'filter_condition_callback' => [$this, '_filterTask'],

            ]
        );
        $this->addColumn(
            'subtask_id',
            [
                'header' => Mage::helper('bs_sur')->__('Sur Sub Code'),
                'index'  => 'subtask_id',
                'type'  => 'text',
                'renderer' => 'bs_misc/adminhtml_helper_column_renderer_subtask',
                'filter_condition_callback' => [$this, '_filterSubtask'],

            ]
        );

        $this->addColumn(
            'record_status',
            [
                'header' => Mage::helper('bs_sur')->__('Record Status'),
                'index'  => 'record_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_sur')->convertOptions(
                    Mage::getModel('bs_sur/sur_attribute_source_recordstatus')->getAllOptions(false)
                )

            ]
        );

        /*$this->addColumn(
            'check_type',
            array(
                'header' => Mage::helper('bs_sur')->__('Check Type'),
                'index'  => 'check_type',
                'type'=> 'number',

            )
        );*/

        $this->addColumn(
            'ncr',
            [
                'header' => Mage::helper('bs_sur')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_sur')->__('Yes'),
                    '0' => Mage::helper('bs_sur')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'qr',
            [
                'header' => Mage::helper('bs_sur')->__('QR'),
                'index'  => 'qr',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_sur')->__('Yes'),
                    '0' => Mage::helper('bs_sur')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'drr',
            [
                'header' => Mage::helper('bs_sur')->__('DRR'),
                'index'  => 'drr',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_sur')->__('Yes'),
                    '0' => Mage::helper('bs_sur')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'car',
            [
                'header' => Mage::helper('bs_sur')->__('CAR'),
                'index'  => 'car',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_sur')->__('Yes'),
                    '0' => Mage::helper('bs_sur')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'ir',
            [
                'header' => Mage::helper('bs_sur')->__('IR'),
                'index'  => 'ir',
                'type'    => 'options',
                'options'    => [
                    '1' => Mage::helper('bs_sur')->__('Yes'),
                    '0' => Mage::helper('bs_sur')->__('No'),
                ]

            ]
        );

        $this->addColumn(
            'qn',
            [
                'header' => Mage::helper('bs_sur')->__('QN'),
                'index'  => 'qn',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_sur')->__('Yes'),
                    '0' => Mage::helper('bs_sur')->__('No'),
                    ]

            ]
        );

        $this->addColumn(
            'remark_text',
            [
                'header' => Mage::helper('bs_ncr')->__('Remark (Outstanding Note)'),
                'index'  => 'remark_text',
                'type'  => 'text',

            ]
        );

        $this->addColumn(
            'remind_text',
            [
                'header' => Mage::helper('bs_ncr')->__('Remind (Fault not record into report)'),
                'index'  => 'remind_text',
                'type'  => 'text',

            ]
        );

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_sur')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_sur')->__('Enabled'),
                    '0' => Mage::helper('bs_sur')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_sur')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_sur')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_sur')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_sur')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_sur')->__('XML'));
        return parent::_prepareColumns();
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

    protected function _filterTask($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $this->getCollection()->getSelect()->where(
            "task_code LIKE ?"
            , "%$value%");


        return $this;
    }

    protected function _filterSubtask($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $this->getCollection()->getSelect()->where(
            "sub_code LIKE ?"
            , "%$value%");


        return $this;
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Sur_Block_Adminhtml_Sur_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('sur');

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
     * @param BS_Sur_Model_Sur
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
     * @return BS_Sur_Block_Adminhtml_Sur_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
