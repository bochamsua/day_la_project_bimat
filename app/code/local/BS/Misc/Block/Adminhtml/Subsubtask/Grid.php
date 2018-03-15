<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Sub Task admin grid block
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Subsubtask_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('subsubtaskGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Subsubtask_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_misc/subsubtask')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Subsubtask_Grid
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
            'subtask_id',
            array(
                'header'    => Mage::helper('bs_misc')->__('Survey Sub Code'),
                'index'     => 'subtask_id',
                'type'      => 'options',
                'options'   => Mage::getResourceModel('bs_misc/subtask_collection')
                    ->toOptionHash(),
                'renderer'  => 'bs_misc/adminhtml_helper_column_renderer_parent',
                'params'    => array(
                    'id'    => 'getSubtaskId'
                ),
                'base_link' => 'adminhtml/misc_subtask/edit'
            )
        );
        $this->addColumn(
            'subsub_code',
            array(
                'header'    => Mage::helper('bs_misc')->__('Sub sub code'),
                'align'     => 'left',
                'index'     => 'subsub_code',
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
     * @return BS_Misc_Block_Adminhtml_Subsubtask_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('subsubtask');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_misc/subsubtask/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_misc/subsubtask/delete");

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




        $values = Mage::getResourceModel('bs_misc/subtask_collection')->toOptionHash();
        $values = array_reverse($values, true);
        $values[''] = '';
        $values = array_reverse($values, true);
        $this->getMassactionBlock()->addItem(
            'subtask_id',
            array(
                'label'      => Mage::helper('bs_misc')->__('Change Survey Sub Codes'),
                'url'        => $this->getUrl('*/*/massSubtaskId', array('_current'=>true)),
                'additional' => array(
                    'flag_subtask_id' => array(
                        'name'   => 'flag_subtask_id',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_misc')->__('Survey Sub Code'),
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
     * @param BS_Misc_Model_Subsubtask
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
     * @return BS_Misc_Block_Adminhtml_Subsubtask_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
