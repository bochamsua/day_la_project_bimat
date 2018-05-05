<?php
/**
 * BS_Client extension
 * 
 * @category       BS
 * @package        BS_Client
 * @copyright      Copyright (c) 2018
 */
/**
 * Client resource model
 *
 * @category    BS
 * @package     BS_Client
 * @author Bui Phong
 */
class BS_Client_Model_Resource_Client extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_client/client', 'entity_id');
    }
}
