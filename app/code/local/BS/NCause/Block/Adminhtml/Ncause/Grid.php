<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Cause admin grid block
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Block_Adminhtml_Ncause_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('ncauseGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncause_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_ncause/ncause')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncause_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_ncause')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'ncausegroup_id',
            array(
                'header'    => Mage::helper('bs_ncause')->__('Root Cause Code'),
                'index'     => 'ncausegroup_id',
                'type'      => 'options',
                'options'   => Mage::getResourceModel('bs_ncause/ncausegroup_collection')
                    ->toOptionHash(),
                'renderer'  => 'bs_ncause/adminhtml_helper_column_renderer_parent',
                'params'    => array(
                    'id'    => 'getNcausegroupId'
                ),
                'base_link' => 'adminhtml/ncause_ncausegroup/edit'
            )
        );
        $this->addColumn(
            'cause_code',
            array(
                'header'    => Mage::helper('bs_ncause')->__('Cause Code'),
                'align'     => 'left',
                'index'     => 'cause_code',
            )
        );
        

        $this->addColumn(
            'cause_name',
            array(
                'header' => Mage::helper('bs_ncause')->__('Cause Name'),
                'index'  => 'cause_name',
                'type'=> 'text',

            )
        );

        $this->addColumn(
            'points',
            array(
                'header'    => Mage::helper('bs_ncause')->__('Points'),
                'align'     => 'left',
                'index'     => 'points',
            )
        );
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_ncause')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_ncause')->__('Enabled'),
                    '0' => Mage::helper('bs_ncause')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_ncause')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_ncause')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_ncause')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_ncause')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_ncause')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncause_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('ncause');

        $this->getMassactionBlock()->addItem('separator', array(
            'label'=> '---Select---',
            'url'  => ''
        ));

        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_NCause_Model_Ncause
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
     * @return BS_NCause_Block_Adminhtml_Ncause_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
