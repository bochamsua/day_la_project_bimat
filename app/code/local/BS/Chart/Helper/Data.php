<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */
require_once(dirname(__FILE__).DS.'fcimg.php');
class BS_Chart_Helper_Data extends Mage_Core_Helper_Abstract {

	private $constructorOptions = array();

	private $constructorTemplate = '
        <script type="text/javascript">
            FusionCharts.ready(function () {
                new FusionCharts(__constructorOptions__).render();
            });
        </script>';

	private $renderTemplate = '
        <script type="text/javascript">
            FusionCharts.ready(function () {
                FusionCharts("__chartId__").render();
            });
        </script>
        ';

	// constructor
	public function renderChart($type, $width = 400, $height = 300, $renderAt, $dataFormat, $dataSource) {
		isset($type) ? $this->constructorOptions['type'] = $type : '';
		isset($id) ? $this->constructorOptions['id'] = $id : 'php-fc-'.time();
		isset($width) ? $this->constructorOptions['width'] = $width : '';
		isset($height) ? $this->constructorOptions['height'] = $height : '';
		isset($renderAt) ? $this->constructorOptions['renderAt'] = $renderAt : '';
		isset($dataFormat) ? $this->constructorOptions['dataFormat'] = $dataFormat : '';
		isset($dataSource) ? $this->constructorOptions['dataSource'] = $dataSource : '';

		$tempArray = array();
		foreach($this->constructorOptions as $key => $value) {
			if ($key === 'dataSource') {
				$tempArray['dataSource'] = '__dataSource__';
			} else {
				$tempArray[$key] = $value;
			}
		}

		$jsonEncodedOptions = json_encode($tempArray);

		if ($dataFormat === 'json') {
			$jsonEncodedOptions = preg_replace('/\"__dataSource__\"/', $this->constructorOptions['dataSource'], $jsonEncodedOptions);
		} elseif ($dataFormat === 'xml') {
			$jsonEncodedOptions = preg_replace('/\"__dataSource__\"/', '\'__dataSource__\'', $jsonEncodedOptions);
			$jsonEncodedOptions = preg_replace('/__dataSource__/', $this->constructorOptions['dataSource'], $jsonEncodedOptions);
		} elseif ($dataFormat === 'xmlurl') {
			$jsonEncodedOptions = preg_replace('/__dataSource__/', $this->constructorOptions['dataSource'], $jsonEncodedOptions);
		} elseif ($dataFormat === 'jsonurl') {
			$jsonEncodedOptions = preg_replace('/__dataSource__/', $this->constructorOptions['dataSource'], $jsonEncodedOptions);
		}
		$newChartHTML = preg_replace('/__constructorOptions__/', $jsonEncodedOptions, $this->constructorTemplate);


		//now init
		//$renderHTML = preg_replace('/__chartId__/', $this->constructorOptions['id'], $this->renderTemplate);

		return $newChartHTML;
	}

	public function buildChart($type, $width = 400, $height = 300, $dataSource,  $renderAt = 'reportChart', $dataFormat = 'json') {

	    $chartData = Mage::helper('core')->jsonEncode($dataSource);

		return $this->renderChart($type, $width, $height, $renderAt, $dataFormat, $chartData);
	}

	public function exportChartToServer($outputName, $type, $data, $width, $height, $imageType = 'jpg') {
        $chartData = Mage::helper('core')->jsonEncode($data);
		$skinDir = Mage::getBaseDir('skin').'/adminhtml/default/s2ltheme/bs_chart/js/';
		$mediaDir = Mage::getBaseDir('media').'/charts/';

		$outputFile = $mediaDir.$outputName.'.'.$imageType;
		$outputUrl = Mage::getBaseUrl('media').'charts/'.$outputName.'.'.$imageType;
		fusioncharts_to_image (
			$outputFile,           // path to image
			$type.".swf",                  // SWF Name. SWF File not required
            $chartData,                    // the input XML String
			$height, $width,                        // height and width
			array(                           // options
				'licensed_fusioncharts_js' => $skinDir."fusioncharts.js", // REQUIRED: Path to licensed fusioncharts.js
				'licensed_fusioncharts_charts_js' => $skinDir."fusioncharts.charts.js", // REQUIRED: Path to licensed fusioncharts.charts.js
				'imageType' => $imageType,        // OPTIONAL: set image type as JPG
				'quality' => 100,              // OPTIONAL: increase Quality
                'render_delay' => 2000,       // OPTIONAL: increase render delay
                //'wkhtmltoimage_path' => "D:\Program Files\wkhtmltox\bin\wkhtmltoimage.exe" // OPTIONAL: alternative wkhtmltoimage_path
            )
		);

		return ['url' => $outputUrl, 'file' => $outputFile];
	}
}