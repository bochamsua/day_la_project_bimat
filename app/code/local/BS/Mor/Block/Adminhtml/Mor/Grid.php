<?php
/**
 * BS_Mor extension
 * 
 * @category       BS
 * @package        BS_Mor
 * @copyright      Copyright (c) 2018
 */
/**
 * MOR admin grid block
 *
 * @category    BS
 * @package     BS_Mor
 * @author Bui Phong
 */
class BS_Mor_Block_Adminhtml_Mor_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('morGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Mor_Block_Adminhtml_Mor_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_mor/mor')
            ->getCollection();

        $collection->getSelect()->joinLeft(['r'=>'bs_acreg_acreg'],'ac_reg = r.entity_id','reg');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Mor_Block_Adminhtml_Mor_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_mor')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            ]
        );
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_mor')->__('Reference No'),
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


        $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1])->load();
        $inspectors = [];
        foreach ($ins as $in) {
            $inspectors[$in->getUserId()] = strtoupper($in->getUsername());
        }
        $this->addColumn(
            'ins_id',
            [
                'header'    => Mage::helper('bs_misc')->__('Inspector'),
                'index'     => 'ins_id',
                'type'      => 'options',
                'options'   => $inspectors,

            ]
        );

        /*$this->addColumn(
            'report_date',
            array(
                'header' => Mage::helper('bs_mor')->__('Date of Report'),
                'index'  => 'report_date',
                'type'=> 'date',

            )
        );*/
        $this->addColumn(
            'place',
            [
                'header' => Mage::helper('bs_mor')->__('Place'),
                'index'  => 'place',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'mor_type',
            [
                'header' => Mage::helper('bs_mor')->__('Type'),
                'index'  => 'mor_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_mor')->convertOptions(
                    Mage::getModel('bs_mor/mor_attribute_source_mortype')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'mor_filter',
            [
                'header' => Mage::helper('bs_mor')->__('Filter'),
                'index'  => 'mor_filter',
                'type'  => 'options',
                'options' => Mage::helper('bs_mor')->convertOptions(
                    Mage::getModel('bs_mor/mor_attribute_source_morfilter')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'report',
            [
                'header' => Mage::helper('bs_mor')->__('Report to Manufacturer'),
                'index'  => 'report',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_mor')->__('Yes'),
                    '0' => Mage::helper('bs_mor')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_mor')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            ]
        );
       /* $this->addColumn(
            'approval_id',
            array(
                'header' => Mage::helper('bs_mor')->__('Approved By'),
                'index'  => 'approval_id',
                'type'=> 'number',

            )
        );*/
        $this->addColumn(
            'mor_status',
            [
                'header' => Mage::helper('bs_mor')->__('Status'),
                'index'  => 'mor_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_mor')->convertOptions(
                    Mage::getModel('bs_mor/mor_attribute_source_morstatus')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'close_date',
            [
                'header' => Mage::helper('bs_mor')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            ]
        );
        /*$this->addColumn(
            'reject_reason',
            array(
                'header' => Mage::helper('bs_mor')->__('Reject Reason'),
                'index'  => 'reject_reason',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'taskgroup_id',
            array(
                'header' => Mage::helper('bs_mor')->__('Task Group'),
                'index'  => 'taskgroup_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'task_id',
            array(
                'header' => Mage::helper('bs_mor')->__('Task Id'),
                'index'  => 'task_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'subtask_id',
            array(
                'header' => Mage::helper('bs_mor')->__('Subtask'),
                'index'  => 'subtask_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ref_id',
            array(
                'header' => Mage::helper('bs_mor')->__('Ref Id'),
                'index'  => 'ref_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'dept_id',
            array(
                'header' => Mage::helper('bs_mor')->__('Dept'),
                'index'  => 'dept_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'loc_id',
            array(
                'header' => Mage::helper('bs_mor')->__('Location'),
                'index'  => 'loc_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'section',
            array(
                'header' => Mage::helper('bs_mor')->__('Section'),
                'index'  => 'section',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'region',
            array(
                'header' => Mage::helper('bs_mor')->__('Region'),
                'index'  => 'region',
                'type'=> 'number',

            )
        );*/
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_mor')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_mor')->__('Enabled'),
                    '0' => Mage::helper('bs_mor')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_mor')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_mor')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_mor')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_mor')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_mor')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Mor_Block_Adminhtml_Mor_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('mor');

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
     * @param BS_Mor_Model_Mor
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
     * @return BS_Mor_Block_Adminhtml_Mor_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
