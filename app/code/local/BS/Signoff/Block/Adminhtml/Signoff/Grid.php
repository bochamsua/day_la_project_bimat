<?php
/**
 * BS_Signoff extension
 * 
 * @category       BS
 * @package        BS_Signoff
 * @copyright      Copyright (c) 2016
 */
/**
 * AC Sign-off admin grid block
 *
 * @category    BS
 * @package     BS_Signoff
 * @author Bui Phong
 */
class BS_Signoff_Block_Adminhtml_Signoff_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('signoffGrid');
        $this->setDefaultSort('ref_no');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Signoff_Block_Adminhtml_Signoff_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_signoff/signoff')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Signoff_Block_Adminhtml_Signoff_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_signoff')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );*/
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_signoff')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );

        $this->addColumn(
            'ins_id',
            [
                'header' => Mage::helper('bs_misc')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, true, true, true, true, false,false, false),
            ]
        );
        

        $this->addColumn(
            'dept_id',
            [
                'header' => Mage::helper('bs_signoff')->__('Maint. Center'),
                'index'  => 'dept_id',
                'type'=> 'number',

            ]
        );
        $this->addColumn(
            'loc_id',
            [
                'header' => Mage::helper('bs_signoff')->__('Location'),
                'index'  => 'loc_id',
                'type'=> 'number',

            ]
        );
	    $acregs = Mage::getModel('bs_acreg/acreg')->getCollection()->toOptionHash();

	    $this->addColumn(
		    'ac_reg',
		    [
			    'header' => Mage::helper('bs_rii')->__('A/C Reg'),
			    'index'     => 'ac_reg',
			    'type'      => 'options',
			    'options'   => $acregs,

            ]
	    );
	    $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_signoff')->__('Start Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'wp',
            [
                'header' => Mage::helper('bs_signoff')->__('Workpack'),
                'index'  => 'wp',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'ir',
            [
                'header' => Mage::helper('bs_signoff')->__('Ir'),
                'index'  => 'ir',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_signoff')->__('Yes'),
                    '0' => Mage::helper('bs_signoff')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'ncr',
            [
                'header' => Mage::helper('bs_signoff')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_signoff')->__('Yes'),
                    '0' => Mage::helper('bs_signoff')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'qr',
            [
                'header' => Mage::helper('bs_signoff')->__('QR'),
                'index'  => 'qr',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_signoff')->__('Yes'),
                    '0' => Mage::helper('bs_signoff')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'task_id',
            [
                'header' => Mage::helper('bs_signoff')->__('Task ID'),
                'index'  => 'task_id',
                'type'=> 'number',

            ]
        );


//        $this->addColumn(
//            'action',
//            array(
//                'header'  =>  Mage::helper('bs_signoff')->__('Action'),
//                'width'   => '100',
//                'type'    => 'action',
//                'getter'  => 'getId',
//                'actions' => array(
//                    array(
//                        'caption' => Mage::helper('bs_signoff')->__('Edit'),
//                        'url'     => array('base'=> '*/*/edit'),
//                        'field'   => 'id'
//                    )
//                ),
//                'filter'    => false,
//                'is_system' => true,
//                'sortable'  => false,
//            )
//        );
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_signoff')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_signoff')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_signoff')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Signoff_Block_Adminhtml_Signoff_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('signoff');

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
     * @param BS_Signoff_Model_Signoff
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
     * @return BS_Signoff_Block_Adminhtml_Signoff_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
