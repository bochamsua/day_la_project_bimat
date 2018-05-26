<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Import resource model
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
class BS_Imex_Model_Resource_Im extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_imex/im', 'entity_id');
    }
}
