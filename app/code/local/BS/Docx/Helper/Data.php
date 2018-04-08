<?php
/**
 * BS_Docx extension
 * 
 * @category       BS
 * @package        BS_Docx
 * @copyright      Copyright (c) 2016
 */
/**
 * Docx default helper
 *
 * @category    BS
 * @package     BS_Docx
 * @author Bui Phong
 */
require_once(dirname(__FILE__).DS.'phpdocx'.DS.'CreateDocx.php');

class BS_Docx_Helper_Data extends Mage_Core_Helper_Abstract
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
    public function generateDocx($filename, $template, $data, $tableData = null, $checkboxes = null, $listvars = null, $content = null, $footer = null, $html = null, $tableHtml = null, $replaceContent = null, $images = [], $charts = [], $tableComplex = [] ){
        $finalDir = $this->getFinalDir();

        $finalUrl = $this->getFinalUrl();

        $filename = $this->getFormattedText($filename);

        $docx = new CreateDocxFromTemplate($template);


        if($data){
            $docx->replaceVariableByText($data);
        }

        if($checkboxes){
            $docx->tickCheckboxes ($checkboxes);
        }

        if($listvars){
            foreach ($listvars as $key => $value) {
                $docx->replaceListVariable($key, $value);
            }

        }

        if($tableData){
            if(count($tableData)){
                foreach ($tableData as $td) {
                    $docx->replaceTableVariable($td);
                }

            }
        }
        if($replaceContent){
            $docx->replaceVariableByExternalFile(['content'=>$replaceContent], []);
        }
        if($content){
            if(count($content)){
                foreach ($content as $cot) {
                    $docx->addExternalFile($cot);
                }

            }

            //$docx->addExternalFile(array('src' => $content));
        }

        if($html){
            if(count($html)){
                foreach ($html as $ht) {
	                $content = Mage::helper('cms')->getPageTemplateProcessor()->filter($ht['content']);
	                if(!isset($ht['type'])){
	                    $ht['type'] = 'block';
                    }

                    $content = '<div style="font-family: Arial;">'.$content.'</div>';
                    $docx->replaceVariableByHTML($ht['code'], $ht['type'], $content, ['isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false, 'strictWordStyles' => false]);

                }

            }

        }

        if($tableHtml){

            if($tableHtml['type'] == 'embed'){
                $docx->embedHTML($tableHtml['content'], ['customListStyles'=>true]);
            }else {
                if(isset($tableHtml['isarray'])){
                    foreach ($tableHtml['array'] as $key=>$value ) {
                    	//make sure to escape those special characters
	                    $value = str_replace(["&"], ["&amp;"],$value);
                        $docx->replaceVariableByWordML([$key => $value]);
                    }

                }else {
	                $tableHtml['content'] = str_replace(["&"], ["&amp;"],$tableHtml['content']);

                    $docx->replaceVariableByWordML([$tableHtml['variable'] => $tableHtml['content']]);
                }

            }


        }

        if($footer){
            //$docx->replaceVariableByExternalFile(array('footer'=>$footer),array());
            $docx->addExternalFile(['src' => $footer]);
        }

        if(count($images)){
        	foreach ($images as $key => $image){
		        $img = new WordFragment($docx, 'document');
		        if(is_array($image)){
                    $img->addImage(array_merge(['src' => $image['image']], $image['options']));
                }else {
                    $img->addImage(['src' => $image , 'float' => 'right', 'textWrap' => 3, 'width' => 99, 'height' => 49, 'verticalOffset' => -360000]);
                }

		        $docx->replaceVariableByWordFragment([$key => $img], ['type' => 'inline']);
	        }



        }

        if(count($charts)){
            foreach ($charts as $key => $chart){
                $ch = new WordFragment($docx, 'document');
                $ch->addChart($chart);
                $docx->replaceVariableByWordFragment([$key => $ch], ['type' => 'inline']);
            }
        }

        if(count($tableComplex)){
            foreach ($tableComplex as $key => $table){
                $tb = new WordFragment($docx, 'footnote');
                $tb->addTable($table['data'], $table['tproperties'], $table['rproperties']);
                $docx->replaceVariableByWordFragment([$key => $tb], ['type' => 'block']);

            }
        }


        $res = $docx->createDocx($finalDir.$filename);

        if($res){

            return [
                'name'  => $filename,
                'url'   => $finalUrl.$filename.'.docx'
            ];
        }

        return false;

    }

    public function getFinalDir(){
        return Mage::getBaseDir('media').DS.'files'.DS;
    }
    public function getFinalUrl(){
        return Mage::getBaseUrl('media').'/files/';
    }
    public function zipFiles($files, $zipName='zippedfile'){
        $zip = new ZipArchive();
        $finalDir = Mage::getBaseDir('media').DS.'files'.DS;
        $finalUrl = Mage::getBaseUrl('media').'/files/';

        $filename = $finalDir.$zipName.'.zip';



        if ($zip->open($filename, ZipArchive::CREATE)) {
            foreach ($files as $file) {

                $name = str_replace($finalUrl,'',$file);

                $file = str_replace($finalUrl,$finalDir,$file);




                $zip->addFile($file, $name);
            }


            $zip->close();

            return $finalUrl.$zipName.'.zip';
        }

        return false;



    }

    public function getFormattedText($value){

        $text = $value;
        $text = preg_replace('/[^a-z0-9A-Z_\\-\\.]+/i', '_', $text);

        return $text;
    }

	public function convertToUnsign($cs, $case = null)
	{
		$vietnamese = ["à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
			"ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề",
			"ế", "ệ", "ể", "ễ",
			"ì", "í", "ị", "ỉ", "ĩ",
			"ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ",
			"ờ", "ớ", "ợ", "ở", "ỡ",
			"ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
			"ỳ", "ý", "ỵ", "ỷ", "ỹ",
			"đ",
			"À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă",
			"Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
			"È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
			"Ì", "Í", "Ị", "Ỉ", "Ĩ",
			"Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
			"Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
			"Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
			"Đ"];

		$vietnameseUnsign = ["a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
			"a", "a", "a", "a", "a", "a",
			"e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
			"i", "i", "i", "i", "i",
			"o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
			"o", "o", "o", "o", "o",
			"u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
			"y", "y", "y", "y", "y",
			"d",
			"A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
			"A", "A", "A", "A", "A",
			"E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
			"I", "I", "I", "I", "I",
			"O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
			"U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
			"Y", "Y", "Y", "Y", "Y",
			"D"];


		$trans = [
			'á' => 'a', 'à' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
			'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a', 'ă' => 'a',
			'ấ' => 'a', 'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a', 'â' => 'a',
			'Á' => 'a', 'À' => 'a', 'Ả' => 'a', 'Ã' => 'a', 'Ạ' => 'a',
			'Ắ' => 'a', 'Ằ' => 'a', 'Ẳ' => 'a', 'Ẵ' => 'a', 'Ặ' => 'a', 'Ă' => 'a',
			'Ấ' => 'a', 'Ầ' => 'a', 'Ẩ' => 'a', 'Ẫ' => 'a', 'Ậ' => 'a', 'Â' => 'a',
			'Đ' => 'd', 'đ' => 'd',
			'é' => 'e', 'è' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
			'É' => 'e', 'È' => 'e', 'Ẻ' => 'e', 'Ẽ' => 'e', 'Ẹ' => 'e',
			'ế' => 'e', 'ề' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e', 'ê' => 'e',
			'Ế' => 'e', 'Ề' => 'e', 'Ể' => 'e', 'Ễ' => 'e', 'Ệ' => 'e', 'Ê' => 'e',
			'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
			'Í' => 'i', 'Ì' => 'i', 'Ỉ' => 'i', 'Ĩ' => 'i', 'Ị' => 'i',
			'ó' => 'o', 'ò' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
			'ố' => 'o', 'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
			'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o', 'ơ' => 'o',
			'Ó' => 'o', 'Ò' => 'o', 'Ỏ' => 'o', 'Õ' => 'o', 'Ọ' => 'o',
			'Ố' => 'o', 'Ồ' => 'o', 'Ổ' => 'o', 'Ỗ' => 'o', 'Ộ' => 'o',
			'Ớ' => 'o', 'Ờ' => 'o', 'Ở' => 'o', 'Ỡ' => 'o', 'Ợ' => 'o', 'Ơ' => 'o',
			'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
			'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u', 'ư' => 'u',
			'Ú' => 'u', 'Ù' => 'u', 'Ủ' => 'u', 'Ũ' => 'u', 'Ụ' => 'u',
			'Ứ' => 'u', 'Ừ' => 'u', 'Ử' => 'u', 'Ữ' => 'u', 'Ự' => 'u', 'Ư' => 'u',
			'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
			'Ý' => 'y', 'Ỳ' => 'y', 'Ỷ' => 'y', 'Ỹ' => 'y', 'Ỵ' => 'y'
        ];

		$result = str_replace($vietnamese, $vietnameseUnsign, $cs);


		if ($case == 'lower') {
			return strtolower($result);
		}elseif($case == 'upper'){
			return strtoupper($result);
		}

		return $result;

	}

	public function toLowercase($str, $ucFirst = false) {
		$lower = 'a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|đ|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|í|ì|ỉ|ĩ|ị|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|ý|ỳ|ỷ|ỹ|ỵ';
		$upper = 'A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|Đ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|Í|Ì|Ỉ|Ĩ|Ị|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|Ý|Ỳ|Ỷ|Ỹ|Ỵ';
		$arrayUpper = explode('|',$upper);
		$arrayLower = explode('|',$lower);
		$str = str_replace($arrayUpper,$arrayLower,$str);
		if($ucFirst){
			$str = ucfirst($str);
		}
		return $str;
	}

	public function toUppercase($str) {
		$lower = 'a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|đ|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|í|ì|ỉ|ĩ|ị|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|ý|ỳ|ỷ|ỹ|ỵ';
		$upper = 'A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|Đ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|Í|Ì|Ỉ|Ĩ|Ị|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|Ý|Ỳ|Ỷ|Ỹ|Ỵ';
		$arrayUpper = explode('|',$upper);
		$arrayLower = explode('|',$lower);
		return str_replace($arrayLower,$arrayUpper,$str);

	}

	public function filterHtml($content){
		$content = Mage::helper('cms')->getPageTemplateProcessor()->filter($content);
		if(strpos($content, "/directive/")){
			$doc = new DOMDocument();
			$doc->loadHTML($content);
			$imageTags = $doc->getElementsByTagName('img');

			foreach($imageTags as $tag) {
				$currentTag = $tag->getAttribute('src');
				$directive = $this->getBetween($currentTag,"__directive/","/key/");
				$directive = base64_decode(strtr($directive, '-_,', '+/='));
				$imagePath = Mage::helper('cms')->getPageTemplateProcessor()->filter($directive);
				$url = Mage::app()->getStore()->getBaseUrl();
				$tag->setAttribute('src', $imagePath);
			}

			$content = $doc->saveHTML();

		}
		$content = str_replace("<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n", '', $content);
		return $content;
	}

	public function getBetween($content,$start,$end){
		$r = explode($start, $content);
		if (isset($r[1])){
			$r = explode($end, $r[1]);
			return $r[0];
		}
		return '';
	}
}
