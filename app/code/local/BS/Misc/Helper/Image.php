<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Misc default helper
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Helper_Image extends BS_Misc_Helper_Data
{
    protected $_maxHeight = 1368;
    protected $_maxWidth = 868;

    public function resizeImage($imageFile, $maxWidth = null, $maxHeight = null){//result is an info array of uploaded file, we will resize if file is image
        if(!isset($maxWidth) || $maxWidth <= 0){
            $maxWidth = $this->_maxWidth;
        }

        if(!isset($maxHeight) || $maxHeight <= 0){
            $maxHeight = $this->_maxHeight;
        }
        $width = null;
        $height = null;
        $imageInfo = getimagesize($imageFile);
        list ($type, $subtype) = explode('/', $imageInfo['mime']);
        if ($type == 'image'){
            $needResize = false;

            if ($imageInfo['0']/$imageInfo['1'] < $maxWidth/$maxHeight && $imageInfo['1'] > $maxHeight){
                $needResize = true;
                $height = $maxHeight;
            }elseif($imageInfo['0'] > $maxWidth){
                $needResize = true;
                $width = $maxWidth;
            }
            if($needResize){
                $image = new Varien_Image($imageFile);
                $image->constrainOnly(false);
                $image->keepFrame(false);
                $image->keepAspectRatio(true);
                $image->keepTransparency(true);
                $image->resize($width, $height);
                $image->save($imageFile);
                return true;
            }

        }


        return false;

    }

}
