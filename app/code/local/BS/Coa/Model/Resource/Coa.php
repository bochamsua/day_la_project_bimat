<?php
/**
 * BS_Coa extension
 * 
 * @category       BS
 * @package        BS_Coa
 * @copyright      Copyright (c) 2018
 */
/**
 * Corrective Action resource model
 *
 * @category    BS
 * @package     BS_Coa
 * @author Bui Phong
 */
class BS_Coa_Model_Resource_Coa extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_coa/coa', 'entity_id');
    }
}
