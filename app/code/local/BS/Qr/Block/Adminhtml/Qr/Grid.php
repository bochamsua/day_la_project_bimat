<?php
/**
 * BS_Qr extension
 * 
 * @category       BS
 * @package        BS_Qr
 * @copyright      Copyright (c) 2016
 */
/**
 * QR admin grid block
 *
 * @category    BS
 * @package     BS_Qr
 * @author Bui Phong
 */
class BS_Qr_Block_Adminhtml_Qr_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('qrGrid');
        $this->setDefaultSort('ref_no');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Qr_Block_Adminhtml_Qr_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_qr/qr')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Qr_Block_Adminhtml_Qr_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_qr')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );*/
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_qr')->__('Reference No'),
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

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionHash();
	    $this->addColumn(
		    'dept_id',
		    [
			    'header'    => Mage::helper('bs_misc')->__('Sent To'),
			    'index'     => 'dept_id',
			    'type'      => 'options',
			    'options'   => $depts,

            ]
	    );

	    $this->addColumn(
		    'dept_id_cc',
		    [
			    'header'    => Mage::helper('bs_misc')->__('CC'),
			    'index'     => 'dept_id_cc',
			    'type'      => 'options',
			    'options'   => $depts,

            ]
	    );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_qr')->__('Report Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
        /*$this->addColumn(
            'ref_doc',
            array(
                'header' => Mage::helper('bs_qr')->__('Ref Doc'),
                'index'  => 'ref_doc',
                'type'=> 'text',

            )
        );
	    $acregs = Mage::getModel('bs_acreg/acreg')->getCollection()->toOptionHash();

	    $this->addColumn(
		    'ac_reg',
		    array(
			    'header' => Mage::helper('bs_rii')->__('A/C Reg'),
			    'index'     => 'ac_reg',
			    'type'      => 'options',
			    'options'   => $acregs,

		    )
	    );
        $this->addColumn(
            'qr_type',
            array(
                'header' => Mage::helper('bs_qr')->__('Type'),
                'index'  => 'qr_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_qr')->convertOptions(
                    Mage::getModel('bs_qr/qr_attribute_source_qrtype')->getAllOptions(false)
                )

            )
        );*/
        /*$this->addColumn(
            'due_date',
            array(
                'header' => Mage::helper('bs_qr')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            )
        );*/


        $this->addColumn(
            'approval_id',
            [
                'header' => Mage::helper('bs_qr')->__('Approved By'),
                'index'  => 'approval_id',
                'type'=> 'number',
                'type'      => 'options',
                'options'   => $inspectors,

            ]
        );
        $this->addColumn(
            'qr_status',
            [
                'header' => Mage::helper('bs_qr')->__('Status'),
                'index'  => 'qr_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_qr')->convertOptions(
                    Mage::getModel('bs_qr/qr_attribute_source_qrstatus')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'close_date',
            [
                'header' => Mage::helper('bs_qr')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            ]
        );

        $this->addColumn(
            'reject_reason',
            [
                'header' => Mage::helper('bs_qr')->__('Reject Reason'),
                'index'  => 'reject_reason',
                'type'=> 'text',

            ]
        );
        /*$this->addColumn(
            'taskgroup_id',
            array(
                'header' => Mage::helper('bs_qr')->__('Task Group'),
                'index'  => 'taskgroup_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'task_id',
            array(
                'header' => Mage::helper('bs_qr')->__('Task Id'),
                'index'  => 'task_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'subtask_id',
            array(
                'header' => Mage::helper('bs_qr')->__('Subtask'),
                'index'  => 'subtask_id',
                'type'=> 'number',

            )
        );*/
        /*$this->addColumn(
            'ref_id',
            array(
                'header' => Mage::helper('bs_qr')->__('Ref Id'),
                'index'  => 'ref_id',
                'type'=> 'number',

            )
        );*/
        /*$this->addColumn(
            'is_submitted',
            array(
                'header' => Mage::helper('bs_qr')->__('Is Submitted?'),
                'index'  => 'is_submitted',
                'type'    => 'options',
                    'options'    => array(
                    '1' => Mage::helper('bs_qr')->__('Yes'),
                    '0' => Mage::helper('bs_qr')->__('No'),
                )

            )
        );*/
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_qr')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_qr')->__('Enabled'),
                    '0' => Mage::helper('bs_qr')->__('Disabled'),
                )
            )
        );*/

//        $this->addColumn(
//            'action',
//            array(
//                'header'  =>  Mage::helper('bs_qr')->__('Action'),
//                'width'   => '100',
//                'type'    => 'action',
//                'getter'  => 'getId',
//                'actions' => array(
//                    array(
//                        'caption' => Mage::helper('bs_qr')->__('Edit'),
//                        'url'     => array('base'=> '*/*/edit'),
//                        'field'   => 'id'
//                    )
//                ),
//                'filter'    => false,
//                'is_system' => true,
//                'sortable'  => false,
//            )
//        );
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_qr')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('adminhtml')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_qr')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Qr_Block_Adminhtml_Qr_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('qr');

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
     * @param BS_Qr_Model_Qr
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
     * @return BS_Qr_Block_Adminhtml_Qr_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
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
