<?php
/**
 * BS_Coa extension
 * 
 * @category       BS
 * @package        BS_Coa
 * @copyright      Copyright (c) 2018
 */
/**
 * Coa default helper
 *
 * @category    BS
 * @package     BS_Coa
 * @author Bui Phong
 */
class BS_Coa_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $_map = [
      '0' => [//responded
          'car' => 5,
          'drr' => 5,
          'ir' => 7,
          'ncr' => 9,
          'qr' => 6,

      ],
        '1' => [//closed
            'car' => 2,
            'drr' => 2,
            'ir' => 3,
            'ncr' => 3,
            'qr' => 3,

        ],
        '2' => [//overdue
            'car' => 4,
            'drr' => 4,
            'ir' => 4,
            'ncr' => 8,
            'qr' => 4,

        ],
        '3' => [//late closed
            'car' => 3,
            'drr' => 3,
            'ir' => 6,
            'ncr' => 6,
            'qr' => 9,

        ],

    ];
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
    /*
     * @var $childStatus Status of COA object
     *
     */
    public function updateStatus($refId, $refType){

        if($refId){
            $messages = [];

            $ongoing = [
                'ncr' => 9,
                'drr'   => 5,
                'car'   => 5,
                'qr'    => 6
            ];

            if(isset($ongoing[$refType])){
                $obj = Mage::getModel("bs_{$refType}/{$refType}");
                $obj->load($refId);

                $refNo = $obj->getRefNo();

                $currentStatus = $obj->getData("{$refType}_status");
                $text1 = Mage::getModel("bs_{$refType}/{$refType}_attribute_source_{$refType}status")->getOptionText($currentStatus);



                //$newStatus = $this->getFinalStatus($refId, $refType);

                //update parent status
                //$obj->setData("{$refType}_status", $newStatus);
                //$obj->save();

                $resource = Mage::getSingleton('core/resource');
                $writeConnection = $resource->getConnection('core_write');
                $readConnection = $resource->getConnection('core_read');

                $writeConnection->update($resource->getTableName("bs_{$refType}/{$refType}"), ["{$refType}_status" => $ongoing[$refType]], "entity_id = {$refId}");

                $url = Mage::helper('adminhtml')->getUrl("*/{$refType}_{$refType}/edit", ['id' => $refId]);
                $text2 = Mage::getModel("bs_{$refType}/{$refType}_attribute_source_{$refType}status")->getOptionText($ongoing[$refType]);

                $messages[] = sprintf("Status of %s: <a href='%s' target='_blank'> <strong>%s</strong></a> has been changed from <strong>%s</strong> to <strong>%s</strong>",  strtoupper($refType), $url, $refNo, $text1, $text2);

                return $messages;
            }






        }

        return true;

    }

    public function getFinalStatus($refId, $refType){

        $coa = Mage::getModel('bs_coa/coa')->getCollection();
        $coa->addFieldToFilter('ref_id', ['eq' => $refId]);
        $coa->addFieldToFilter('ref_type', ['eq' => $refType]);

        $status = null;
        $statuses = [];
        if($coa->count()){
            foreach ($coa as $item) {
                $statuses[] = $item->getCoaStatus();
            }
        }

        if(count($statuses)){
            if(in_array('3', $statuses)){//check late closed first
                $status = 3;
            }elseif (in_array('2', $statuses)){
                $status = 2;
            }elseif (in_array('0', $statuses)){
                $status = 0;
            }else {
                $status = 1;
            }

            $finalStatus = $this->getParentStatusFromChildStatus($refType, $status);

            return $finalStatus;
        }


        return null;


    }

    public function getParentStatusFromChildStatus($refType, $childStatus){

        $map = $this->_map;

        foreach ($map as $status => $relations) {

            if($childStatus == $status){
                return $relations[$refType];
            }
        }

        return null;

    }
}
