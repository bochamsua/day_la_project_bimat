<?php
/**
 * BS_CmrReport extension
 * 
 * @category       BS
 * @package        BS_CmrReport
 * @copyright      Copyright (c) 2017
 */
/**
 * CmrReport default helper
 *
 * @category    BS
 * @package     BS_CmrReport
 * @author Bui Phong
 */
class BS_CmrReport_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author Bui Phong
     */
    public function convertOptions($options)
    {
        $converted = [];
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }

    public function getCmrData($month, $year, $type = null){
        if(!$month){
            $month = Mage::getModel('core/date')->date('m', now());
        }
        if(!$year){
            $year = Mage::getModel('core/date')->date('Y', now());
        }

        //cmr data is for previous month, so we get previous month data instead
        /*if($month == 1){
            $month = 12;
            $year -= 1;
        }else {
            $month -= 1;
        }*/

        $cmr = Mage::getModel('bs_cmr/cmr')->getCollection();
        $fromTo = Mage::helper('bs_report')->getFromTo($month, $year);
        $cmr->addFieldToFilter('report_date', ['from' => $fromTo[0]]);
        $cmr->addFieldToFilter('report_date', ['to' => $fromTo[1]]);

        if($type){
            $cmr->addFieldToFilter('cmr_type', $type);
        }

        if($cmr->count()){
            return $cmr;
        }

        return false;
    }



    public function getGroupData($month, $year, $type, $total){
        $group = $this->getCmrData($month, $year, $type);
        if($group){
            $count = $group->count();
            $percent = round($count * 100/$total);
        }else {
            $group = [''];
            $count = 0;
            $percent = 0;
        }

        return [$group, $count, $percent];
    }

    public function getPreviousCmrData($month, $year, $p,  $type = 1){

        $periods = Mage::helper('bs_report')->getPreviousMonthYear($month, $year, $p);
        if(!count($periods)){
            return false;
        }

        $result = [];
        foreach ($periods as $period) {
            $cmr = Mage::getModel('bs_cmr/cmr')->getCollection();
            $fromTo = Mage::helper('bs_report')->getFromTo($period[0], $period[1]);
            $cmr->addFieldToFilter('report_date', ['from' => $fromTo[0]]);
            $cmr->addFieldToFilter('report_date', ['to' => $fromTo[1]]);
            $cmr->addFieldToFilter('cmr_type', $type);

            $result['T'.$period[0].'/'.$period[1]] = ($cmr->count())?$cmr->count():0;

        }

        return $result;

    }

    public function getChartData($month, $year, $p,  $type){
        $result = [];
        $cmr = $this->getPreviousCmrData($month, $year, $p, $type);
        if(count($cmr)){
            $i=0;
            $first = '';
            $second = '';
            foreach ($cmr as $key => $value) {
                if($i==0){
                    $first = $key;
                }
                if($i == count($cmr) - 1){
                    $second = $key;
                }
                $result[] = [
                    'label' =>   $key,
                    'value' => $value
                ];



                $i++;
            }

            $value = array_values($cmr);
            sort($value);

            $chartData = [
                "chart" => [
                    "caption" => "Xu huớng các khuyến cáo Nhóm {$type}",
                    "subCaption" => $first .'-'.$second,
                    "yAxisName" => "",
                    "paletteColors" => "#0075c2",
                    "bgColor" => "#ffffff",
                    "borderAlpha" => "20",
                    "canvasBorderAlpha" => "0",
                    "usePlotGradientColor" => "0",
                    "plotBorderAlpha" => "10",
                    "placevaluesInside" => "1",
                    "rotatevalues" => "0",
                    "valueFontColor" => "#0075c2",
                    "showXAxisLine" => "1",
                    "xAxisLineColor" => "#999999",
                    "divlineColor" => "#999999",
                    "divLineIsDashed" => "1",
                    "showAlternateHGridColor" => "0",
                    "subcaptionFontBold" => "0",
                    "subcaptionFontSize" => "14",
                    "exportEnabled" => 0,
                    "exportAtClientSide" => 1,
                    "exportFileName" => ""
                ]
            ];

            /*$chartData["trendlines"] = array(
                array(
                    'line' => array(
                        array(
                            "startvalue" => $value[0],
                            "endValue" => $value[count($value)-1],
                            "color" => "#1aaf5d",
                            "valueOnRight" => "1",
                            "displayvalue" => ""
                        ),

                    ))
            );*/


            $chartData["data"] = $result;


            return $chartData;

        }
        return false;
    }

    public function getChart($month, $year, $p,  $type, $renderAt){
        $chartData = $this->getChartData($month, $year, $p,  $type);
        if($chartData){
            $chart = Mage::helper('bs_chart')->buildChart("line", "100%", 400, $chartData, $renderAt );
            return $chart;
        }

        return false;

    }

    public function exportChart($month, $year, $p,  $type){
        $chartData = $this->getChartData($month, $year, $p,  $type);
        if($chartData){
            $chartData['chart']['exportEnabled'] = 0;

            $file = Mage::helper('bs_chart')->exportChartToServer('cmr-'.$type.'-'.$month .'-'.$year, 'line', $chartData, 568, 368);

            return $file;
        }

        return false;

    }
}
