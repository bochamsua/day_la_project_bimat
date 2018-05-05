<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Authority resource model
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
class BS_Aut_Model_Resource_Aut extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_aut/aut', 'entity_id');
    }
}
