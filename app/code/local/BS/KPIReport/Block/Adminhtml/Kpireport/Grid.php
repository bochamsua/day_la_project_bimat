<?php
/**
 * BS_KPIReport extension
 * 
 * @category       BS
 * @package        BS_KPIReport
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Report admin grid block
 *
 * @category    BS
 * @package     BS_KPIReport
 * @author Bui Phong
 */
class BS_KPIReport_Block_Adminhtml_Kpireport_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('kpireportGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);
        //$this->setTemplate('bs_report/empty.phtml');


    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_KPIReport_Block_Adminhtml_Kpireport_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $fromMonth = $toMonth = Mage::getModel('core/date')->date('m', now());
        $fromYear = $toYear = Mage::getModel('core/date')->date('Y', now());

        $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));

        if(count($requestData)){
            $type = $requestData['report_type'];

            if($type == 1){
                $fromMonth = $requestData['month'];
                $fromYear = $requestData['year'];
                $toMonth = $requestData['month'];
                $toYear = $requestData['year'];
            }else {
                $fromMonth = $requestData['from_month'];
                $fromYear = $requestData['from_year'];
                $toMonth = $requestData['to_month'];
                $toYear = $requestData['to_year'];
            }

        }




        $between = $this->helper('bs_report')->buildMonthYearQuery($fromMonth, $fromYear, $toMonth, $toYear);

        $depts = Mage::helper('bs_misc/dept')->getMaintenanceCenters();

        $collection = Mage::getModel('bs_kpireport/kpireport')
            ->getCollection();

        if(count($depts)){
            $collection->addFieldToFilter('dept_id', ['in' => $depts]);
        }


        if($between){
            $collection->getSelect()->where($between);
        }

        //$this->setChart($this->getChart());
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_KPIReport_Block_Adminhtml_Kpireport_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_kpireport')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number',
	            'filter'    => false
            )
        );*/

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionHash();
	    $this->addColumn(
		    'dept_id',
		    array(
			    'header'    => Mage::helper('bs_kpireport')->__('Maint. Center'),
			    'index'     => 'dept_id',
			    'type'      => 'options',
			    'options'   => $depts,

		    )
	    );
	    $this->addColumn(
		    'month',
		    array(
			    'header'    => Mage::helper('bs_kpireport')->__('Month'),
			    'index'     => 'month',
			    'type'      => 'options',
			    'options'   => Mage::helper('bs_report')->getMonths(),

		    )
	    );

	    $this->addColumn(
		    'year',
		    array(
			    'header'    => Mage::helper('bs_kpireport')->__('Year'),
			    'index'     => 'year',
			    'type'      => 'options',
			    'options'   => Mage::helper('bs_report')->getYears(),

		    )
	    );



        $this->addColumn(
            'qsr',
            array(
                'header' => Mage::helper('bs_kpireport')->__('QSR'),
                'index'  => 'qsr',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'ncr',
            array(
                'header' => Mage::helper('bs_kpireport')->__('NCR'),
                'index'  => 'ncr',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'mncr',
            array(
                'header' => Mage::helper('bs_kpireport')->__('MNCR'),
                'index'  => 'mncr',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'mer',
            array(
                'header' => Mage::helper('bs_kpireport')->__('MER'),
                'index'  => 'mer',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'ser',
            array(
                'header' => Mage::helper('bs_kpireport')->__('SER'),
                'index'  => 'ser',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'rer',
            array(
                'header' => Mage::helper('bs_kpireport')->__('RER'),
                'index'  => 'rer',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'camt',
            array(
                'header' => Mage::helper('bs_kpireport')->__('CAMT'),
                'index'  => 'camt',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'sdr',
            array(
                'header' => Mage::helper('bs_kpireport')->__('SDR'),
                'index'  => 'sdr',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'csr',
            array(
                'header' => Mage::helper('bs_kpireport')->__('CSR'),
                'index'  => 'csr',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'cir',
            array(
                'header' => Mage::helper('bs_kpireport')->__('CIR'),
                'index'  => 'cir',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'mir',
            array(
                'header' => Mage::helper('bs_kpireport')->__('MIR'),
                'index'  => 'mir',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'ppe',
            array(
                'header' => Mage::helper('bs_kpireport')->__('PPE'),
                'index'  => 'ppe',
                'type'=> 'text',

            )
        );
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_kpireport')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_kpireport')->__('Enabled'),
                    '0' => Mage::helper('bs_kpireport')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_kpireport')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_kpireport')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_kpireport')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_kpireport')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_kpireport')->__('XML'));
        return parent::_prepareColumns();
    }

    public function getChart()
    {
        if($this->getRequest()->getParam('chart')){

            $fromMonth = $toMonth = Mage::getModel('core/date')->date('m', now());
            $fromYear = $toYear = Mage::getModel('core/date')->date('Y', now());

            $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));

            if(count($requestData)){
                $fromMonth = $requestData['from_month'];
                $fromYear = $requestData['from_year'];
                $toMonth = $requestData['to_month'];
                $toYear = $requestData['to_year'];
            }

            $type = $requestData['report_type'];
            if($type == 1){
                $depts = [$requestData['dept_single']];
                $indexes = explode(",", $requestData['index_multiple'][0]);
            }else {
                if($requestData['dept_multiple'][0] != ''){
                    $depts = explode(",", $requestData['dept_multiple'][0]);
                    $indexes = [$requestData['index_single']];
                }else {
                    $depts = [];
                }
            }

            $between = $this->helper('bs_report')->buildMonthYearQuery($fromMonth, $fromYear, $toMonth, $toYear);

            $collection = Mage::getModel('bs_kpireport/kpireport')
                ->getCollection();

            if(count($depts)){
                $collection->addFieldToFilter('dept_id', ['in' => $depts]);
            }


            if($between){
                $collection->getSelect()->where($between);
            }


            if(count($requestData)){


                $chartData = array(
                    "chart" => array(
                        "caption" => "KPI Report",
                        //"subCaption" => $month .'-'.$year,
                        "yAxisName" => "Level",
                        "paletteColors" => "#0075c2",
                        "bgColor" => "#ffffff",
                        "borderAlpha" => "20",
                        "canvasBorderAlpha" => "0",
                        "usePlotGradientColor" => "0",
                        "plotBorderAlpha" => "10",
                        "placevaluesInside" => "1",
                        "rotatevalues" => "0",
                        "valueFontColor" => "#ffffff",
                        "showXAxisLine" => "1",
                        "xAxisLineColor" => "#999999",
                        "divlineColor" => "#999999",
                        "divLineIsDashed" => "1",
                        "showAlternateHGridColor" => "0",
                        "subcaptionFontBold" => "0",
                        "subcaptionFontSize" => "14",
                        "exportEnabled" => 1,
                        "exportAtClientSide" => 1,
                        "exportFileName" => "QC HAN Efficieny Report"
                    )
                );


                /*$collection = Mage::getModel('bs_report/qchaneff')
                    ->getCollection();

                $collection->addFieldToFilter('month', $month);
                $collection->addFieldToFilter('year', $year);

                $result = [];
                foreach ( $collection as $item ) {
                    $user = Mage::getModel('admin/user')->load($item->getInsId());
                    $result[] = array(
                        'label' => Mage::helper('bs_misc')->getShortName($user->getFirstname().' '.$user->getLastname()),
                        'value' => $item->getLevel()
                    );
                }*/


                //$chartData["data"] = $result;
                $chartData["trendlines"] = [
                    [
                        'line' => [
                            [
                                "startvalue" => "7",
                                "color" => "#1aaf5d",
                                "valueOnRight" => "1",
                                "displayvalue" => "Level - 7"
                            ],
                            [
                                "startvalue" => "2",
                                "color" => "#1aaf5d",
                                "valueOnRight" => "1",
                                "displayvalue" => "Level - 7"
                            ]
                        ]
                    ]
                ];

                $jsonData = Mage::helper('core')->jsonEncode($chartData);


                $chart = Mage::helper('bs_chart')->buildChart("msline", "100%", 400, $jsonData);

                $this->setChart($chart);

            }






        }
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_KPIReport_Block_Adminhtml_Kpireport_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        return $this;
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('kpireport');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_report/kpireport/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_report/kpireport/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                array(
                    'label'=> Mage::helper('bs_kpireport')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_kpireport')->__('Are you sure?')
                )
            );
        }

        return $this;

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                array(
                    'label'      => Mage::helper('bs_kpireport')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                    'additional' => array(
                        'status' => array(
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_kpireport')->__('Status'),
                            'values' => array(
                                '1' => Mage::helper('bs_kpireport')->__('Enabled'),
                                '0' => Mage::helper('bs_kpireport')->__('Disabled'),
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
     * @param BS_KPIReport_Model_Kpireport
     * @return string
     * @author Bui Phong
     */
    public function getRowUrl($row)
    {
        return $this;//->getUrl('*/*/edit', array('id' => $row->getId()));
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
     * @return BS_KPIReport_Block_Adminhtml_Kpireport_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
