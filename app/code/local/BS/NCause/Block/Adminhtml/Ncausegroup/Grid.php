<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Root Cause Code admin grid block
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Block_Adminhtml_Ncausegroup_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('ncausegroupGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncausegroup_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_ncause/ncausegroup')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncausegroup_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_ncause')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            ]
        );
        $this->addColumn(
            'group_code',
            [
                'header'    => Mage::helper('bs_ncause')->__('Group Code'),
                'align'     => 'left',
                'index'     => 'group_code',
            ]
        );
        

        $this->addColumn(
            'group_name',
            [
                'header' => Mage::helper('bs_ncause')->__('Name'),
                'index'  => 'group_name',
                'type'=> 'text',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
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
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_ncause')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_ncause')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncausegroup_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('ncausegroup');

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
     * @param BS_NCause_Model_Ncausegroup
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
     * @return BS_NCause_Block_Adminhtml_Ncausegroup_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
