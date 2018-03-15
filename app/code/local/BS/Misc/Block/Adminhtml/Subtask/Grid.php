<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Task admin grid block
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Subtask_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('subtaskGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Subtask_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_misc/subtask')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Subtask_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_misc')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );
        $this->addColumn(
            'task_id',
            array(
                'header'    => Mage::helper('bs_misc')->__('Survey Code'),
                'index'     => 'task_id',
                'type'      => 'options',
                'options'   => Mage::getResourceModel('bs_misc/task_collection')
                    ->toOptionHash(),
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_parent',
                'params'    => array(
                    'id'    => 'getTaskId'
                ),
                'base_link' => 'adminhtml/misc_task/edit'
            )
        );
        $this->addColumn(
            'sub_code',
            array(
                'header'    => Mage::helper('bs_misc')->__('Sub Task Code'),
                'align'     => 'left',
                'index'     => 'sub_code',
            )
        );

        $this->addColumn(
            'points',
            array(
                'header'    => Mage::helper('bs_misc')->__('Points'),
                'align'     => 'left',
                'index'     => 'points',
            )
        );


        $this->addColumn(
            'sub_desc',
            array(
                'header'    => Mage::helper('bs_misc')->__('Description'),
                'align'     => 'left',
                'index'     => 'sub_desc',
            )
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
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_misc')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_misc')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_misc')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Subtask_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('subtask');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_misc/subtask/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_misc/subtask/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                array(
                    'label'=> Mage::helper('bs_misc')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_misc')->__('Are you sure?')
                )
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                array(
                    'label'      => Mage::helper('bs_misc')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                    'additional' => array(
                        'status' => array(
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_misc')->__('Status'),
                            'values' => array(
                                '1' => Mage::helper('bs_misc')->__('Enabled'),
                                '0' => Mage::helper('bs_misc')->__('Disabled'),
                            )
                        )
                    )
                )
            );




        $values = Mage::getResourceModel('bs_misc/task_collection')->toOptionHash();
        $values = array_reverse($values, true);
        $values[''] = '';
        $values = array_reverse($values, true);
        $this->getMassactionBlock()->addItem(
            'task_id',
            array(
                'label'      => Mage::helper('bs_misc')->__('Change Survey Code'),
                'url'        => $this->getUrl('*/*/massTaskId', array('_current'=>true)),
                'additional' => array(
                    'flag_task_id' => array(
                        'name'   => 'flag_task_id',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_misc')->__('Survey Code'),
                        'values' => $values
                    )
                )
            )
        );
        }
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Misc_Model_Subtask
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
     * @return BS_Misc_Block_Adminhtml_Subtask_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
