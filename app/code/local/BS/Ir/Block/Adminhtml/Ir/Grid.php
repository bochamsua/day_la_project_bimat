<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir admin grid block
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Block_Adminhtml_Ir_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('irGrid');
        $this->setDefaultSort('ref_no');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Ir_Block_Adminhtml_Ir_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_ir/ir')
            ->getCollection();

        $collection->getSelect()->joinLeft(array('r'=>'bs_acreg_acreg'),'ac_reg = r.entity_id','reg');
        $collection->getSelect()->joinLeft(array('t'=>'bs_misc_task'),'task_id = t.entity_id','task_code');
        $collection->getSelect()->joinLeft(array('s'=>'bs_misc_subtask'),'subtask_id = s.entity_id','sub_code');
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Ir_Block_Adminhtml_Ir_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_ir')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );*/
        $this->addColumn(
            'ref_no',
            array(
                'header'    => Mage::helper('bs_ir')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            )
        );

	    $causeGroups = Mage::getResourceModel('bs_ncause/ncausegroup_collection');
	    $causeGroups = $causeGroups->toOptionHash();

	    $this->addColumn(
		    'ncausegroup_id',
		    array(
			    'header'    => Mage::helper('bs_misc')->__('Cause Group'),
			    'index'     => 'ncausegroup_id',
			    'type'      => 'options',
			    'options'   => $causeGroups,

		    )
	    );

	    $causes = Mage::getResourceModel('bs_ncause/ncause_collection');
	    $causes = $causes->toOptionHash();
	    $this->addColumn(
		    'ncause_id',
		    array(
			    'header'    => Mage::helper('bs_misc')->__('Cause'),
			    'index'     => 'ncause_id',
			    'type'      => 'options',
			    'options'   => $causes,

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
		    'dept_id',
		    array(
			    'header'    => Mage::helper('bs_ir')->__('Maint. Center'),
			    'index'     => 'dept_id',
			    'type'      => 'options',
			    'options'   => $depts,

		    )
	    );

	    $locs = Mage::getResourceModel('bs_misc/location_collection');
	    $locs = $locs->toOptionHash();
	    $this->addColumn(
		    'loc_id',
		    array(
			    'header'    => Mage::helper('bs_ir')->__('Location'),
			    'index'     => 'loc_id',
			    'type'      => 'options',
			    'options'   => $locs,

		    )
	    );


	    $this->addColumn(
		    'task_id',
		    array(
			    'header' => Mage::helper('bs_ir')->__('Survey Code'),
			    'index'  => 'task_id',
			    'type'  => 'text',
			    'renderer' => 'bs_misc/adminhtml_helper_column_renderer_task',
			    'filter_condition_callback' => array($this, '_filterTask'),

		    )
	    );


	    $this->addColumn(
		    'subtask_id',
		    array(
			    'header' => Mage::helper('bs_ir')->__('Survey Sub Code'),
			    'index'  => 'subtask_id',
			    'type'  => 'text',
			    'renderer' => 'bs_misc/adminhtml_helper_column_renderer_subtask',
			    'filter_condition_callback' => array($this, '_filterSubtask'),

		    )
	    );

	    $this->addColumn(
		    'report_date',
		    array(
			    'header' => Mage::helper('bs_ir')->__('Report Date'),
			    'index'  => 'report_date',
			    'type'=> 'date',

		    )
	    );

	    $this->addColumn(
		    'event_date',
		    array(
			    'header' => Mage::helper('bs_ir')->__('Date of Event'),
			    'index'  => 'event_date',
			    'type'=> 'date',

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
			    'header' => Mage::helper('bs_ir')->__('A/C Type'),
			    'index'     => 'ac_type',
			    'type'      => 'options',
			    'options'   => $acTypes,

		    )
	    );


	    $this->addColumn(
		    'ac_reg',
		    array(
			    'header' => Mage::helper('bs_ir')->__('A/C Reg'),
			    'index'  => 'ac_reg',
			    'type'  => 'text',
			    'renderer' => 'bs_acreg/adminhtml_helper_column_renderer_acreg',
			    'filter_condition_callback' => array($this, '_filterAcReg'),

		    )
	    );

        $this->addColumn(
            'error_type',
            array(
                'header' => Mage::helper('bs_ir')->__('Error Type'),
                'index'  => 'error_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_ir')->convertOptions(
                    Mage::getModel('bs_ncr/ncr_attribute_source_errortype')->getAllOptions(false)
                )

            )
        );
	    $this->addColumn(
		    'ir_status',
		    array(
			    'header' => Mage::helper('bs_ir')->__('Status'),
			    'index'  => 'ir_status',
			    'type'  => 'options',
			    'options' => Mage::helper('bs_ir')->convertOptions(
				    Mage::getModel('bs_ir/ir_attribute_source_irstatus')->getAllOptions(false)
			    )

		    )
	    );


        /*$this->addColumn(
            'ncr',
            array(
                'header' => Mage::helper('bs_ir')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_ir')->__('Yes'),
                    '0' => Mage::helper('bs_ir')->__('No'),
                )

            )
        );
        $this->addColumn(
            'qr',
            array(
                'header' => Mage::helper('bs_ir')->__('QR'),
                'index'  => 'qr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_ir')->__('Yes'),
                    '0' => Mage::helper('bs_ir')->__('No'),
                )

            )
        );
        $this->addColumn(
            'drr',
            array(
                'header' => Mage::helper('bs_ir')->__('DRR'),
                'index'  => 'drr',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_ir')->__('Yes'),
                    '0' => Mage::helper('bs_ir')->__('No'),
                )

            )
        );*/



//        $this->addColumn(
//            'action',
//            array(
//                'header'  =>  Mage::helper('bs_ir')->__('Action'),
//                'width'   => '100',
//                'type'    => 'action',
//                'getter'  => 'getId',
//                'actions' => array(
//                    array(
//                        'caption' => Mage::helper('bs_ir')->__('Edit'),
//                        'url'     => array('base'=> '*/*/edit'),
//                        'field'   => 'id'
//                    )
//                ),
//                'filter'    => false,
//                'is_system' => true,
//                'sortable'  => false,
//            )
//        );
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_ir')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_ir')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_ir')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Ir_Block_Adminhtml_Ir_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('ir');

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
     * get the row url
     *
     * @access public
     * @param BS_Ir_Model_Ir
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
     * @return BS_Ir_Block_Adminhtml_Ir_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
