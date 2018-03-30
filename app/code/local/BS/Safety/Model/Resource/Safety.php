<?php
/**
 * BS_Safety extension
 * 
 * @category       BS
 * @package        BS_Safety
 * @copyright      Copyright (c) 2018
 */
/**
 * Safety Data resource model
 *
 * @category    BS
 * @package     BS_Safety
 * @author Bui Phong
 */
class BS_Safety_Model_Resource_Safety extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_safety/safety', 'entity_id');
    }
}
