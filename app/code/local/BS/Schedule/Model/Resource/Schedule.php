<?php
/**
 * BS_Schedule extension
 * 
 * @category       BS
 * @package        BS_Schedule
 * @copyright      Copyright (c) 2017
 */
/**
 * Schedule resource model
 *
 * @category    BS
 * @package     BS_Schedule
 * @author Bui Phong
 */
class BS_Schedule_Model_Resource_Schedule extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_schedule/schedule', 'entity_id');
    }
}
