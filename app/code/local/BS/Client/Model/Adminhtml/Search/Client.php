<?php
/**
 * BS_Client extension
 * 
 * @category       BS
 * @package        BS_Client
 * @copyright      Copyright (c) 2018
 */
/**
 * Admin search model
 *
 * @category    BS
 * @package     BS_Client
 * @author Bui Phong
 */
class BS_Client_Model_Adminhtml_Search_Client extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return BS_Client_Model_Adminhtml_Search_Client
     * @author Bui Phong
     */
    public function load()
    {
        $arr = [];
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('bs_client/client_collection')
            ->addFieldToFilter('client_id', ['like' => $this->getQuery().'%'])
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $client) {
            $arr[] = [
                'id'          => 'client/1/'.$client->getId(),
                'type'        => Mage::helper('bs_client')->__('Client'),
                'name'        => $client->getClientId(),
                'description' => $client->getClientId(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/client_client/edit',
                    ['id'=>$client->getId()]
                ),
            ];
        }
        $this->setResults($arr);
        return $this;
    }
}
