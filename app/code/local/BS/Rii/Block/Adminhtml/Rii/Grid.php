<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * RII Sign-off admin grid block
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
class BS_Rii_Block_Adminhtml_Rii_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('riiGrid');
        $this->setDefaultSort('ref_no');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Rii_Block_Adminhtml_Rii_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_rii/rii')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Rii_Block_Adminhtml_Rii_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_rii')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false,
	            'filter'    => false
            )
        );*/
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_rii')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );

        $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1])->load();
        $inspectors = [];
        foreach ($ins as $in) {
	        $inspectors[$in->getUserId()] = strtoupper($in->getUsername());
        }
        $this->addColumn(
            'ins_id',
            [
                'header'    => Mage::helper('bs_misc')->__('Inspector'),
                'index'     => 'ins_id',
                'type'      => 'options',
                'options'   => $inspectors,

            ]
        );

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionHash();
	    $this->addColumn(
		    'dept_id',
		    [
			    'header'    => Mage::helper('bs_misc')->__('Maint. Center'),
			    'index'     => 'dept_id',
			    'type'      => 'options',
			    'options'   => $depts,

            ]
	    );
        $this->addColumn(
            'loc_id',
            [
                'header' => Mage::helper('bs_rii')->__('Location'),
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
            'customer',
            [
                'header' => Mage::helper('bs_rii')->__('Customer'),
                'index'  => 'customer',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_rii')->__('Date of Inspection'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'wp',
            [
                'header' => Mage::helper('bs_rii')->__('Workpack'),
                'index'  => 'wp',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'ir',
            [
                'header' => Mage::helper('bs_rii')->__('Ir'),
                'index'  => 'ir',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_rii')->__('Yes'),
                    '0' => Mage::helper('bs_rii')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'ncr',
            [
                'header' => Mage::helper('bs_rii')->__('NCR'),
                'index'  => 'ncr',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_rii')->__('Yes'),
                    '0' => Mage::helper('bs_rii')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'qr',
            [
                'header' => Mage::helper('bs_rii')->__('QR'),
                'index'  => 'qr',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_rii')->__('Yes'),
                    '0' => Mage::helper('bs_rii')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'task_id',
            [
                'header' => Mage::helper('bs_rii')->__('Task ID'),
                'index'  => 'task_id',
                'type'=> 'number',

            ]
        );



        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_rii')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_rii')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_rii')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Rii_Block_Adminhtml_Rii_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('rii');

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
     * @param BS_Rii_Model_Rii
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
     * @return BS_Rii_Block_Adminhtml_Rii_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
