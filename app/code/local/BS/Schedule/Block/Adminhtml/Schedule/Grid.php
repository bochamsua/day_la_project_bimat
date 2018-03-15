<?php
/**
 * BS_Schedule extension
 * 
 * @category       BS
 * @package        BS_Schedule
 * @copyright      Copyright (c) 2017
 */
/**
 * Schedule admin grid block
 *
 * @category    BS
 * @package     BS_Schedule
 * @author Bui Phong
 */
class BS_Schedule_Block_Adminhtml_Schedule_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('scheduleGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Schedule_Block_Adminhtml_Schedule_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_schedule/schedule')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Schedule_Block_Adminhtml_Schedule_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_schedule')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'name',
            array(
                'header'    => Mage::helper('bs_schedule')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
            )
        );
        

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_schedule')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_schedule')->__('Enabled'),
                    '0' => Mage::helper('bs_schedule')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_schedule')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_schedule')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_schedule')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_schedule')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_schedule')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Schedule_Block_Adminhtml_Schedule_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('schedule');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_sched/schedule/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_sched/schedule/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                array(
                    'label'=> Mage::helper('bs_schedule')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_schedule')->__('Are you sure?')
                )
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                array(
                    'label'      => Mage::helper('bs_schedule')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                    'additional' => array(
                        'status' => array(
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_schedule')->__('Status'),
                            'values' => array(
                                '1' => Mage::helper('bs_schedule')->__('Enabled'),
                                '0' => Mage::helper('bs_schedule')->__('Disabled'),
                            )
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
     * @param BS_Schedule_Model_Schedule
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
     * @return BS_Schedule_Block_Adminhtml_Schedule_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
