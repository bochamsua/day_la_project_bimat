<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Work Day admin grid block
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Workday_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('workdayGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Workday_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_report/workday')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Workday_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_report')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number',
	            'filter'    => false
            )
        );

        

        $this->addColumn(
            'month',
            array(
                'header' => Mage::helper('bs_report')->__('Month'),
                'index'  => 'month',
                'type'  => 'options',
                'options' => Mage::helper('bs_report')->convertOptions(
                    Mage::getModel('bs_report/workday_attribute_source_month')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'year',
            array(
                'header' => Mage::helper('bs_report')->__('Year'),
                'index'  => 'year',
                'type'  => 'options',
                'options' => Mage::helper('bs_report')->convertOptions(
                    Mage::getModel('bs_report/workday_attribute_source_year')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
		    'days',
		    array(
			    'header'    => Mage::helper('bs_report')->__('Days'),
			    'align'     => 'left',
			    'index'     => 'days',
		    )
	    );
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_report')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_report')->__('Enabled'),
                    '0' => Mage::helper('bs_report')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_report')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_report')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_report')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_report')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_report')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Workday_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('workday');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_evaluation/workday/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_evaluation/workday/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                array(
                    'label'=> Mage::helper('bs_report')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_report')->__('Are you sure?')
                )
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                array(
                    'label'      => Mage::helper('bs_report')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                    'additional' => array(
                        'status' => array(
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_report')->__('Status'),
                            'values' => array(
                                '1' => Mage::helper('bs_report')->__('Enabled'),
                                '0' => Mage::helper('bs_report')->__('Disabled'),
                            )
                        )
                    )
                )
            );




        $this->getMassactionBlock()->addItem(
            'month',
            array(
                'label'      => Mage::helper('bs_report')->__('Change Month'),
                'url'        => $this->getUrl('*/*/massMonth', array('_current'=>true)),
                'additional' => array(
                    'flag_month' => array(
                        'name'   => 'flag_month',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_report')->__('Month'),
                        'values' => Mage::getModel('bs_report/workday_attribute_source_month')
                            ->getAllOptions(true),

                    )
                )
            )
        );
        $this->getMassactionBlock()->addItem(
            'year',
            array(
                'label'      => Mage::helper('bs_report')->__('Change Year'),
                'url'        => $this->getUrl('*/*/massYear', array('_current'=>true)),
                'additional' => array(
                    'flag_year' => array(
                        'name'   => 'flag_year',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_report')->__('Year'),
                        'values' => Mage::getModel('bs_report/workday_attribute_source_year')
                            ->getAllOptions(true),

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
     * @param BS_Report_Model_Workday
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
     * @return BS_Report_Block_Adminhtml_Workday_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
