<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr admin grid block
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Block_Adminhtml_Drr_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('drrGrid');
        $this->setDefaultSort('ref_no');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Drr_Block_Adminhtml_Drr_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_drr/drr')
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
     * @return BS_Drr_Block_Adminhtml_Drr_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_drr')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );*/
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_drr')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );

        /*$tasks = Mage::getResourceModel('bs_misc/task_collection');
        $tasks = $tasks->toOptionHash();
        $this->addColumn(
            'task_id',
            array(
                'header'    => Mage::helper('bs_misc')->__('Survey Code'),
                'index'     => 'task_id',
                'type'      => 'options',
                'options'   => $tasks,

            )
        );

        $subtasks = Mage::getResourceModel('bs_misc/subtask_collection');
        $subtasks = $subtasks->toOptionHash();
        $this->addColumn(
            'subtask_id',
            array(
                'header'    => Mage::helper('bs_misc')->__('Survey Sub Code'),
                'index'     => 'subtask_id',
                'type'      => 'options',
                'options'   => $subtasks,

            )
        );*/
	    /*$this->addColumn(
		    'task_id',
		    array(
			    'header' => Mage::helper('bs_misc')->__('Survey Code'),
			    'index'  => 'task_id',
			    'type'  => 'text',
			    'renderer' => 'bs_misc/adminhtml_helper_column_renderer_task',
			    'filter_condition_callback' => array($this, '_filterTask'),

		    )
	    );

	    $this->addColumn(
		    'subtask_id',
		    array(
			    'header' => Mage::helper('bs_misc')->__('Survey Sub Code'),
			    'index'  => 'subtask_id',
			    'type'  => 'text',
			    'renderer' => 'bs_misc/adminhtml_helper_column_renderer_subtask',
			    'filter_condition_callback' => array($this, '_filterSubtask'),

		    )
	    );*/


	    /*$causeGroups = Mage::getResourceModel('bs_ncause/ncausegroup_collection');
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
	    );*/


        $this->addColumn(
            'ins_id',
            [
                'header' => Mage::helper('bs_misc')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, true, true, true, true, false),

            ]
        );

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionHash();
	    $this->addColumn(
		    'dept_id',
		    [
			    'header'    => Mage::helper('bs_misc')->__('Maint. Center'),
			    'index'     => 'dept_id',
			    'type'      => 'options',
			    'options'   => $depts,

            ]
	    );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_drr')->__('Report Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );

        /*$this->addColumn(
            'ac',
            array(
                'header' => Mage::helper('bs_drr')->__('A/C'),
                'index'  => 'ac',
                'type'=> 'text',

            )
        );*/
	    /*$acregs = Mage::getModel('bs_acreg/acreg')->getCollection()->toOptionHash();

	    $this->addColumn(
		    'ac_reg',
		    array(
			    'header' => Mage::helper('bs_drr')->__('A/C Reg'),
			    'index'     => 'ac_reg',
			    'type'      => 'options',
			    'options'   => $acregs,

		    )
	    );*/
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
			    'header' => Mage::helper('bs_drr')->__('A/C Type'),
			    'index'     => 'ac_type',
			    'type'      => 'options',
			    'options'   => $acTypes,

            ]
	    );


	    $this->addColumn(
		    'ac_reg',
		    [
			    'header' => Mage::helper('bs_drr')->__('A/C Reg'),
			    'index'  => 'ac_reg',
			    'type'  => 'text',
			    'renderer' => 'bs_acreg/adminhtml_helper_column_renderer_acreg',
			    'filter_condition_callback' => [$this, '_filterAcReg'],

            ]
	    );

        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_drr')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            ]
        );

        $this->addColumn(
            'drr_status',
            [
                'header' => Mage::helper('bs_drr')->__('Status'),
                'index'  => 'drr_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_drr')->convertOptions(
                    Mage::getModel('bs_drr/drr_attribute_source_drrstatus')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'close_date',
            [
                'header' => Mage::helper('bs_drr')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            ]
        );


//        $this->addColumn(
//            'action',
//            array(
//                'header'  =>  Mage::helper('bs_drr')->__('Action'),
//                'width'   => '100',
//                'type'    => 'action',
//                'getter'  => 'getId',
//                'actions' => array(
//                    array(
//                        'caption' => Mage::helper('bs_drr')->__('Edit'),
//                        'url'     => array('base'=> '*/*/edit'),
//                        'field'   => 'id'
//                    )
//                ),
//                'filter'    => false,
//                'is_system' => true,
//                'sortable'  => false,
//            )
//        );
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_drr')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_drr')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_drr')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Drr_Block_Adminhtml_Drr_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('drr');

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
     * @param BS_Drr_Model_Drr
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
     * @return BS_Drr_Block_Adminhtml_Drr_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
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

    protected function _afterToHtml($html)
    {
        $id = $this->getId();

        $html .= "<script>
                   
                    Event.observe(document, \"dom:loaded\", function(e) {
                           updateSubtasks($('".$id."_filter_task_id').value);
                    });

                    function updateSubtasks(task_id){
                        new Ajax.Request('".$this->getUrl('*/misc_task/updateSubtasks')."', {
                                method : 'post',
                                parameters: {
                                    'task_id'   : task_id
                                },
                                onSuccess : function(transport){
                                    try{
                                        response = eval('(' + transport.responseText + ')');
                                    } catch (e) {
                                        response = {};
                                    }
                                    if (response.subtask) {

                                        if($('".$id."_filter_subtask_id') != undefined){
                                            $('".$id."_filter_subtask_id').innerHTML = response.subtask;
                                            //ncrGridJsObject.doFilter();
                                        }

                                    }else {
                                        alert('Something went wrong');
                                    }

                                },
                                onFailure : function(transport) {
                                    alert('Something went wrong')
                                }
                            });
                    }
                     Event.observe('".$id."_filter_task_id', 'change', function(evt){
                            updateSubtasks($('".$id."_filter_task_id').value);
                     });
                     
                     Event.observe('".$id."_filter_subtask_id', 'change', function(evt){
                            ncrGridJsObject.doFilter();
                     });


                </script>";
        return parent::_afterToHtml($html);
    }
}
