<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Survey Group admin grid block
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Taskgroup_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('taskgroupGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Taskgroup_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_misc/taskgroup')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Taskgroup_Grid
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
            'group_name',
            array(
                'header'    => Mage::helper('bs_misc')->__('Group Name'),
                'align'     => 'left',
                'index'     => 'group_name',
            )
        );
        

        $this->addColumn(
            'group_code',
            array(
                'header' => Mage::helper('bs_misc')->__('Group Code'),
                'index'  => 'group_code',
                'type'=> 'text',

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
//        $this->addExportType('*/*/exportCsv', Mage::helper('bs_misc')->__('CSV'));
//        $this->addExportType('*/*/exportExcel', Mage::helper('bs_misc')->__('Excel'));
//        $this->addExportType('*/*/exportXml', Mage::helper('bs_misc')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Taskgroup_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
//        $this->setMassactionIdField('entity_id');
//        $this->getMassactionBlock()->setFormFieldName('taskgroup');
//
//        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_misc/taskgroup/edit");
//        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_misc/taskgroup/delete");
//
//        if($isAllowedDelete){
//            $this->getMassactionBlock()->addItem(
//                'delete',
//                array(
//                    'label'=> Mage::helper('bs_misc')->__('Delete'),
//                    'url'  => $this->getUrl('*/*/massDelete'),
//                    'confirm'  => Mage::helper('bs_misc')->__('Are you sure?')
//                )
//            );
//        }

        
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Misc_Model_Taskgroup
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
     * @return BS_Misc_Block_Adminhtml_Taskgroup_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
