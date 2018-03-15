<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger resource model
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
class BS_Logger_Model_Resource_Logger extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_logger/logger', 'entity_id');
    }
}
