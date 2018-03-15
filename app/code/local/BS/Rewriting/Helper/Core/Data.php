<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Helper_Core_Data extends Mage_Core_Helper_Data {

	protected $_moduleName = 'Mage_Core';

	/**
	 * Decodes the given $encodedValue string which is encoded in the JSON format
	 *
	 * Overridden to prevent exceptions in json_decode
	 *
	 * @param string $encodedValue
	 * @param int $objectDecodeType
	 * @return mixed
	 * @throws Zend_Json_Exception
	 */
	public function jsonDecode($encodedValue, $objectDecodeType = Zend_Json::TYPE_ARRAY) {
		switch (true) {
			case (null === $encodedValue)  : $encodedValue = 'null'; break;
			case (true === $encodedValue)  : $encodedValue = 'true'; break;
			case (false === $encodedValue) : $encodedValue = 'false'; break;
			case ('' === $encodedValue)    : $encodedValue = '""'; break;
			default    : // do nothing
		}

		return Zend_Json::decode($encodedValue, $objectDecodeType);
	}
}