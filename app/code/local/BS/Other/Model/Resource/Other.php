<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other Work resource model
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
class BS_Other_Model_Resource_Other extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_other/other', 'entity_id');
    }
}
