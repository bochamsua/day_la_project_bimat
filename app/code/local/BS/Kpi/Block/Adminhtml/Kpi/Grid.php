<?php
/**
 * BS_Kpi extension
 * 
 * @category       BS
 * @package        BS_Kpi
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Data admin grid block
 *
 * @category    BS
 * @package     BS_Kpi
 * @author Bui Phong
 */
class BS_Kpi_Block_Adminhtml_Kpi_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('kpiGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Kpi_Block_Adminhtml_Kpi_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_kpi/kpi')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Kpi_Block_Adminhtml_Kpi_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_kpi')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number',
	            'filter'    => false
            ]
        );


	    $this->addColumn(
		    'month',
		    [
			    'header'    => Mage::helper('bs_misc')->__('Month'),
			    'index'     => 'month',
			    'type'      => 'options',
			    'options'   => Mage::helper('bs_report')->getMonths(),

            ]
	    );

	    $this->addColumn(
		    'year',
		    [
			    'header'    => Mage::helper('bs_misc')->__('Year'),
			    'index'     => 'year',
			    'type'      => 'options',
			    'options'   => Mage::helper('bs_report')->getYears(),

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
            'mass_production',
            [
                'header' => Mage::helper('bs_kpi')->__('Mass Prod.'),
                'index'  => 'mass_production',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'self_ncr',
            [
                'header' => Mage::helper('bs_kpi')->__('Self NCR'),
                'index'  => 'self_ncr',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'man_hours',
            [
                'header' => Mage::helper('bs_kpi')->__('Man Hours'),
                'index'  => 'man_hours',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'schedule_workflow',
            [
                'header' => Mage::helper('bs_kpi')->__('S.W.Period'),
                'index'  => 'schedule_workflow',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'actual_workflow',
            [
                'header' => Mage::helper('bs_kpi')->__('A.W.Period'),
                'index'  => 'actual_workflow',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'interrelationship_complaint',
            [
                'header' => Mage::helper('bs_kpi')->__('I.Complaint'),
                'index'  => 'interrelationship_complaint',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'customer_complaint',
            [
                'header' => Mage::helper('bs_kpi')->__('C.Complaint'),
                'index'  => 'customer_complaint',
                'type'=> 'text',

            ]
        );
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_kpi')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_kpi')->__('Enabled'),
                    '0' => Mage::helper('bs_kpi')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_kpi')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_kpi')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_kpi')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_kpi')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_kpi')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Kpi_Block_Adminhtml_Kpi_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('kpi');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_data/kpi/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_data/kpi/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                [
                    'label'=> Mage::helper('bs_kpi')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_kpi')->__('Are you sure?')
                ]
            );
        }

        return $this;

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                [
                    'label'      => Mage::helper('bs_kpi')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', ['_current'=>true]),
                    'additional' => [
                        'status' => [
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_kpi')->__('Status'),
                            'values' => [
                                '1' => Mage::helper('bs_kpi')->__('Enabled'),
                                '0' => Mage::helper('bs_kpi')->__('Disabled'),
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
     * @param BS_Kpi_Model_Kpi
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
     * @return BS_Kpi_Block_Adminhtml_Kpi_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
