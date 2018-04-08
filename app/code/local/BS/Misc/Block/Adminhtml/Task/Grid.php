<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Task admin grid block
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Task_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('taskGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Task_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_misc/task')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Task_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_misc')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            ]
        );
        $this->addColumn(
            'taskgroup_id',
            [
                'header'    => Mage::helper('bs_misc')->__('Survey Group'),
                'index'     => 'taskgroup_id',
                'type'      => 'options',
                'options'   => Mage::getResourceModel('bs_misc/taskgroup_collection')
                    ->toOptionHash(),
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_parent',
                'params'    => [
                    'id'    => 'getTaskgroupId'
                ],
                'base_link' => 'adminhtml/misc_taskgroup/edit'
            ]
        );
        $this->addColumn(
            'task_code',
            [
                'header'    => Mage::helper('bs_misc')->__('Task Code'),
                'align'     => 'left',
                'index'     => 'task_code',
            ]
        );

	    $this->addColumn(
		    'points',
		    [
			    'header'    => Mage::helper('bs_misc')->__('Points'),
			    'align'     => 'left',
			    'index'     => 'points',
            ]
	    );




//        $this->addColumn(
//            'action',
//            array(
//                'header'  =>  Mage::helper('bs_misc')->__('Action'),
//                'width'   => '100',
//                'type'    => 'action',
//                'getter'  => 'getId',
//                'actions' => array(
//                    array(
//                        'caption' => Mage::helper('bs_misc')->__('Edit'),
//                        'url'     => array('base'=> '*/*/edit'),
//                        'field'   => 'id'
//                    )
//                ),
//                'filter'    => false,
//                'is_system' => true,
//                'sortable'  => false,
//            )
//        );
//        $this->addExportType('*/*/exportCsv', Mage::helper('bs_misc')->__('CSV'));
//        $this->addExportType('*/*/exportExcel', Mage::helper('bs_misc')->__('Excel'));
//        $this->addExportType('*/*/exportXml', Mage::helper('bs_misc')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Task_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('task');

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
     * @param BS_Misc_Model_Task
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
     * @return BS_Misc_Block_Adminhtml_Task_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
