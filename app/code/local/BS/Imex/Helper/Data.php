<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Imex default helper
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
require_once(dirname(__FILE__).DS.'lib'.DS.'SpreadsheetReader.php');
class BS_Imex_Helper_Data extends Mage_Core_Helper_Abstract
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

    public function getMaxUploadSize()
    {
        return min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
    }

    public function readExcelFile($file){

        $spreadsheet = new SpreadsheetReader($file);
        //$sheets = $class->Sheets();

        $spreadsheet->ChangeSheet(0);

        $result = [];

        //we need to convert the sheet in to key => data array
        //row 0 is the header

        $i=0;
        $header = [];
        foreach ($spreadsheet as $key => $row)
        {
            if($i == 0){
                $header = $row;
            }else {
                if($row[0] != ''){//ignore empty row
                    $temp = [];
                    foreach ($header as $index => $key){
                        $temp[$key] = $row[$index];
                    }
                    $result[] = $temp;
                }
            }

            $i++;

        }


        return $result;
    }
}
