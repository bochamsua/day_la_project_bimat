<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger admin grid block
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
class BS_Logger_Block_Adminhtml_Logger_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('loggerGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Logger_Block_Adminhtml_Logger_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_logger/logger')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Logger_Block_Adminhtml_Logger_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_logger')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number',
                'filter'    => false
            )
        );
        $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', array('gt' => 1))->load();
        $inspectors = array();
        foreach ($ins as $in) {
            $inspectors[$in->getUserId()] = strtoupper($in->getUsername());
        }
        $this->addColumn(
            'user_id',
            array(
                'header'    => Mage::helper('bs_logger')->__('User'),
                'index'     => 'user_id',
                'type'      => 'options',
                'options'   => $inspectors,

            )
        );
        

        $this->addColumn(
            'ip',
            array(
                'header' => Mage::helper('bs_logger')->__('IP Address'),
                'index'  => 'ip',
                'type'=> 'text',

            )
        );

        $this->addColumn(
            'created_at', array(
                'header' => Mage::helper('bs_logger')->__('Date'),
                'align' => 'left',
                'width' => '150px',
                'index' => 'created_at',
                'type'=> 'text',
            )
        );

        $this->addColumn(
            'message',
            array(
                'header' => Mage::helper('bs_logger')->__('Message'),
                'index'  => 'message',
                'type'=> 'text',

            )
        );
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_logger')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_logger')->__('Enabled'),
                    '0' => Mage::helper('bs_logger')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_logger')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_logger')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_logger')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_logger')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_logger')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Logger_Block_Adminhtml_Logger_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('logger');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("system/logger/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("system/logger/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                array(
                    'label'=> Mage::helper('bs_logger')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_logger')->__('Are you sure?')
                )
            );
        }


        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Logger_Model_Logger
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
     * @return BS_Logger_Block_Adminhtml_Logger_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
