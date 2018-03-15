<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Surveillance resource model
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Model_Resource_Sur extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function _construct()
    {
        $this->_init('bs_sur/sur', 'entity_id');
    }

    /**
     * process multiple select fields
     *
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return BS_Sur_Model_Resource_Sur
     * @author Bui Phong
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $subtaskid = $object->getSubtaskId();
        if (is_array($subtaskid)) {
            $object->setSubtaskId(implode(',', $subtaskid));
        }
        return parent::_beforeSave($object);
    }

}
