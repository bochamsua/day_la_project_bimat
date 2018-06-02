<?php
/**
 * BS_Nrw extension
 * 
 * @category       BS
 * @package        BS_Nrw
 * @copyright      Copyright (c) 2018
 */
/**
 * Non-routine Work admin grid block
 *
 * @category    BS
 * @package     BS_Nrw
 * @author Bui Phong
 */
class BS_Nrw_Block_Adminhtml_Nrw_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('nrwGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Nrw_Block_Adminhtml_Nrw_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_nrw/nrw')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Nrw_Block_Adminhtml_Nrw_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_nrw')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );
        

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_nrw')->__('Issue Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_nrw')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            ]
        );
        /*$this->addColumn(
            'nrw_type',
            [
                'header' => Mage::helper('bs_nrw')->__('Type'),
                'index'  => 'nrw_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_nrw')->convertOptions(
                    Mage::getModel('bs_nrw/nrw_attribute_source_nrwtype')->getAllOptions(false)
                )

            ]
        );*/


        $this->addColumn(
            'ins_id',
            [
                'header'    => Mage::helper('bs_misc')->__('Manager'),
                'index'     => 'ins_id',
                'type'      => 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(true, true, true, true, true),

            ]
        );

        $this->addColumn(
            'staff_id',
            [
                'header' => Mage::helper('bs_nrw')->__('Inspector'),
                'index'  => 'staff_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, false, true, true, true),

            ]
        );
        $this->addColumn(
            'nrw_status',
            [
                'header' => Mage::helper('bs_nrw')->__('Status'),
                'index'  => 'nrw_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_nrw')->convertOptions(
                    Mage::getModel('bs_nrw/nrw_attribute_source_nrwstatus')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'close_date',
            [
                'header' => Mage::helper('bs_nrw')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'reject_reason',
            [
                'header' => Mage::helper('bs_nrw')->__('Reject Reason'),
                'index'  => 'reject_reason',
                'type'=> 'text',
                'filter_condition_callback' => [$this, '_searchMultipleWords'],
            ]
        );


        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_nrw')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_nrw')->__('Enabled'),
                    '0' => Mage::helper('bs_nrw')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_nrw')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_nrw')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_nrw')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_nrw')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_nrw')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Nrw_Block_Adminhtml_Nrw_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('nrw');

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
     * @param BS_Nrw_Model_Nrw
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
     * @return BS_Nrw_Block_Adminhtml_Nrw_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
