<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Supplier resource model
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Model_Resource_Sup extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_sup/sup', 'entity_id');
    }
}
