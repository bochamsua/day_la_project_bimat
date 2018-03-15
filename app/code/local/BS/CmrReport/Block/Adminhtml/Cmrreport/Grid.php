<?php
/**
 * BS_CmrReport extension
 * 
 * @category       BS
 * @package        BS_CmrReport
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Report admin grid block
 *
 * @category    BS
 * @package     BS_CmrReport
 * @author Bui Phong
 */
class BS_CmrReport_Block_Adminhtml_Cmrreport_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('cmrreportGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setTemplate('bs_cmrreport/report.phtml');
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_CmrReport_Block_Adminhtml_Cmrreport_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {

        $month = null;
        $year = null;

        $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));

        if(count($requestData)){
            $month = $requestData['month'];
            $year = $requestData['year'];
        }



        $helper = $this->helper('bs_cmrreport');

        $collection = $helper->getCmrData($month, $year);


        if($collection){
            $count = count($collection);

            for ($i = 1; $i <= 5; $i++){
                $this->{'setGroup'.$i}($helper->getGroupData($month, $year, $i, $count));
            }

        }

        //chart
        for($k=1; $k <= 4; $k++){
            $this->{'setChart'.$k}($helper->getChart($month, $year, 5, $k, "chart".$k));
        }


        //cmr data is for previous month, so we get previous month data instead
       /* if($month == 1){
            $month = 12;
            $year -= 1;
        }else {
            $month -= 1;
        }*/

        $this->setCurrentPeriod('T'.$month.'-'.$year);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_CmrReport_Block_Adminhtml_Cmrreport_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_cmrreport')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'name',
            array(
                'header'    => Mage::helper('bs_cmrreport')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
            )
        );
        

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_cmrreport')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_cmrreport')->__('Enabled'),
                    '0' => Mage::helper('bs_cmrreport')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_cmrreport')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_cmrreport')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_cmrreport')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_cmrreport')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_cmrreport')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_CmrReport_Block_Adminhtml_Cmrreport_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('cmrreport');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_report/cmrreport/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_report/cmrreport/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                array(
                    'label'=> Mage::helper('bs_cmrreport')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_cmrreport')->__('Are you sure?')
                )
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                array(
                    'label'      => Mage::helper('bs_cmrreport')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                    'additional' => array(
                        'status' => array(
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_cmrreport')->__('Status'),
                            'values' => array(
                                '1' => Mage::helper('bs_cmrreport')->__('Enabled'),
                                '0' => Mage::helper('bs_cmrreport')->__('Disabled'),
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
     * @param BS_CmrReport_Model_Cmrreport
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
     * @return BS_CmrReport_Block_Adminhtml_Cmrreport_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
