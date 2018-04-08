<?php
/**
 * BS_Routine extension
 * 
 * @category       BS
 * @package        BS_Routine
 * @copyright      Copyright (c) 2017
 */
/**
 * Routine Report admin grid block
 *
 * @category    BS
 * @package     BS_Routine
 * @author Bui Phong
 */
class BS_Routine_Block_Adminhtml_Routine_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('routineGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Routine_Block_Adminhtml_Routine_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_routine/routine')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Routine_Block_Adminhtml_Routine_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_routine')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            ]
        );
        $this->addColumn(
            'name',
            [
                'header'    => Mage::helper('bs_routine')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
            ]
        );
        

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_routine')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_routine')->__('Enabled'),
                    '0' => Mage::helper('bs_routine')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_routine')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_routine')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_routine')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_routine')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_routine')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Routine_Block_Adminhtml_Routine_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('routine');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_report/routine/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_report/routine/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                [
                    'label'=> Mage::helper('bs_routine')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_routine')->__('Are you sure?')
                ]
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                [
                    'label'      => Mage::helper('bs_routine')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', ['_current'=>true]),
                    'additional' => [
                        'status' => [
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_routine')->__('Status'),
                            'values' => [
                                '1' => Mage::helper('bs_routine')->__('Enabled'),
                                '0' => Mage::helper('bs_routine')->__('Disabled'),
                            ]
                        ]
                    ]
                ]
            );




        }
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Routine_Model_Routine
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
     * @return BS_Routine_Block_Adminhtml_Routine_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
