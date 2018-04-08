<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Evaluation admin block
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Qchaneff extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function __construct()
    {
        $this->_controller         = 'adminhtml_qchaneff';
        $this->_blockGroup         = 'bs_report';
        parent::__construct();
        $this->_headerText         = Mage::helper('bs_report')->__('QC HAN Evaluation');
        $this->_updateButton('add', 'label', Mage::helper('bs_report')->__('Add QC HAN Evaluation'));


	    $this->_removeButton('add');

	    if($this->getRequest()->getParam('chart')){





		    $month = Mage::getModel('core/date')->date('m', now());
		    $year = Mage::getModel('core/date')->date('Y', now());

		    $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));

		    if(count($requestData)){
			    $month = $requestData['month'];
			    $year = $requestData['year'];
		    }


		    $chartData = [
			    "chart" => [
				    "caption" => "QC HAN Evaluation Report",
                    "subCaption" => $month .'-'.$year,
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
                ]
            ];


		    $collection = Mage::getModel('bs_report/qchaneff')
		                      ->getCollection();

		    $collection->addFieldToFilter('month', $month);
		    $collection->addFieldToFilter('year', $year);

		    $result = [];
		    foreach ( $collection as $item ) {
			    $user = Mage::getModel('admin/user')->load($item->getInsId());
			    $result[] = [
				    'label' => Mage::helper('bs_misc')->getShortName($user->getFirstname().' '.$user->getLastname()),
				    'value' => $item->getLevel()
                ];
		    }


		    $chartData["data"] = $result;
		    $chartData["trendlines"] = [
		    	[
		    		'line' => [
				        [
					        "startvalue" => "7",
					        "color" => "#1aaf5d",
					        "valueOnRight" => "1",
					        "displayvalue" => "Level - 7"
                        ],
					   /* array(
						    "startvalue" => "2",
						    "color" => "#1aaf5d",
						    "valueOnRight" => "1",
						    "displayvalue" => "Level - 7"
					    )*/
                    ]]
            ];


		    //now export chart
		    //we need to disable export option in chart settings, this removes the export menu in the output image, so looks better
		    /*$chartDataExport = $chartData;
		    $chartDataExport['chart']['exportEnabled'] = 0;

		    $file = Mage::helper('bs_chart')->exportChartToServer($month .'-'.$year, 'column2d', $chartDataExport, 1000, 468);*/

		    //print_r($file);

		    $chart = Mage::helper('bs_chart')->buildChart("column2d", "100%", 400, $chartData, "qchaneffGrid" );

		    $this->setChart($chart);//$file['url'].
	    }


    }


}
