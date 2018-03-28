<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Misc default helper
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_relations = [
        'ncr',
        'ir',
        'qr',
        'qn',
        'car',
        'drr'
    ];

    protected $_surTypes = [
        'sur',
        'cmr',
        'cofa',
    ];

    protected $_riiTypes = [
        'rii' => 'rii',
        'signoff' => 'sign'
    ];

    protected $_otherTypes = [
        'other' => 'o',
    ];

    protected $_customTypes = [
        'concession'
    ];


    public function getRelations(){
        return $this->_relations;
    }

    public function getSurTypes(){
        return $this->_surTypes;
    }

    public function getRiiTypes(){
        return $this->_riiTypes;
    }

    public function getOtherTypes(){
        return $this->_otherTypes;
    }

    public function getAllTypes(){
        return array_merge(
            $this->_surTypes,
            $this->_relations,
            $this->_customTypes,
            array_keys($this->_riiTypes),
            array_keys($this->_otherTypes)
        );
    }

    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author Bui Phong
     */
    public function convertOptions($options)
    {
        $converted = array();
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }
    
    public function getShortName($name){
    	$arr = explode(" ", $name);
    	$result = array();
	    for ($i=0; $i < count($arr)-1; $i++) {
		    $result[] = $this->substr($arr[$i],0,1);
    	}
    	$result[] = $arr[count($arr)-1];

    	return implode(".", $result);
    }

	public function len($a){
		return mb_strlen($a,'UTF-8');
	}

	public function charAt($a,$i){
		return $this->substr($a,$i,1);
	}

	public function substr($a,$x,$y=null){
		if($y===NULL){
			$y = $this->len($a);
		}
		return mb_substr($a,$x,$y,'UTF-8');
	}

    public function shorterString($string, $len) {
        //strip html tags if any
        $string = $this->stripTags($string);
        $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
        $parts_count = count($parts);

        $length = 0;
        $last_part = 0;
        for (; $last_part < $parts_count; ++$last_part) {
            $length += strlen($parts[$last_part]);
            if ($length > $len) { break; }
        }

        $str =  implode(array_slice($parts, 0, $last_part));
        $strLen = strlen($string);
        if($strLen < $len){
            return $string;
        }else {
            return $str.'...';
        }
    }

    public function handleTextForExport($text)
    {
        $text = html_entity_decode($text);
        $text = $this->stripTags($text);

        return $text;
    }

    public function getCurrentUserInfo(){
        $user = Mage::getSingleton('admin/session')->getUser();
        if($user){
            $adminUserId = $user->getUserId();
            $modelUser = Mage::getModel('admin/user')->load($adminUserId);
            $roleId = $modelUser->getRole()->getRoleId();
            $region = $user->getRegion();
            $section = $user->getSection();

            return [$adminUserId, $roleId, $region, $section];
        }

        return false;

    }

    public function getFieldDependence($fieldNameSuffix){
        $setting = Mage::getModel('bs_setting/field')->getCollection();
        $setting->addFieldToFilter('name', $fieldNameSuffix);

        if($setting->getFirstItem()->getId()){
            $definition = $setting->getFirstItem()->getDefinition();

            if(strpos($definition, "\r\n")){
                $definition = explode("\r\n", $definition);
            }else {
                $definition = explode("<br>", $definition);
            }

            $fields = [];
            $defs = [];
            foreach ($definition as $item) {
                $item = $this->handleTextForExport($item);
                $item = str_replace(" ", "", $item);
                $item = explode(":", $item);

                $f = explode("--", $item[0]);
                $fields = array_merge($fields, $f);
                $d = explode(",", $item[1]);
                $ds = [];
                foreach ($d as $i) {
                    $ds[] = $i;
                }
                $defs[] = array_merge($f, [$ds]);

            }

            $fields = array_unique($fields);

            $id = $fieldNameSuffix.'_';

            $formDependance =  $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence');
            foreach ($fields as $field) {
                $formDependance->addFieldMap($id.$field, $field);
            }

            foreach ($defs as $def) {
                $formDependance->addFieldDependence($def[0], $def[1], $def[2]);
            }

            return $formDependance;

        }

        return '';
    }

    public function getRelatedItem($refType, $refId){
        $result = array();
        $model = 'bs_'.$refType.'/'.$refType;
        $path = $refType.'_'.$refType;

        if(isset($refType) && $refType){
            $result['name'] = Mage::getModel($model)->load($refId)->getRefNo();
            $result['link'] = Mage::helper('adminhtml')->getUrl('*/'.$path.'/edit', array('id' => $refId));

            return $result;
        }

        return false;
    }

    public function getNextRefNo($type = 'sur', $regionId = 1, $deptId, $sectionId = 1){

        $riiTypes = array_keys($this->_riiTypes);
        $otherTypes = array_keys($this->_otherTypes);
        if(in_array($type, $this->_surTypes)){
            return $this->getNextSurRefNo($type, $deptId);
        }elseif (in_array($type, $this->_relations)){
            return $this->getNextRelationRefNo($type, $regionId);
        }elseif (in_array($type, $riiTypes)){
            return $this->getNextRelationRefNo($type, $regionId, $this->_riiTypes[$type]);
        }elseif (in_array($type, $otherTypes)){
            return $this->getNextOtherRefNo($type, $regionId, $this->_otherTypes[$type]);
        }

        return '';

    }

    public function getNextSurRefNo($type, $deptId){
        $collection    = Mage::getModel("bs_{$type}/{$type}")->getCollection();

        $fromTo = Mage::helper('bs_report')->getFromTo(null, null, true);

        $formattedDate = $fromTo[2];
        $collection->addFieldToFilter('created_at', array(
            'from' => $fromTo[0],
            'to' => $fromTo[1],
            'date' => true,
        ));
        $collection->setOrder('entity_id', 'DESC');

        $dept = Mage::getModel('bs_misc/department')->load($deptId)->getDeptCode();
        $dept = str_replace(" ", "-", $dept);
        $dept = strtoupper($dept);

        $nextRefNo = null;
        if($collection->getFirstItem() && $collection->getFirstItem()->getId()){
            $lastRefNo = $collection->getFirstItem()->getRefNo();
            $lastRefNo = explode("-", $lastRefNo);
            $lastIncrement = intval(end($lastRefNo));
            $nextIncrement = $lastIncrement + 1;
            if($nextIncrement < 10){
                $nextIncrement = '0'.$nextIncrement;
            }
            $nextRefNo = sprintf("%s-%s-%s-%s", strtoupper($type), $dept, $formattedDate, $nextIncrement);

        }else {
            $nextRefNo = sprintf("%s-%s-%s-01", strtoupper($type), $dept, $formattedDate);
        }

        return $nextRefNo;
    }

    public function getNextRelationRefNo($type = 'ncr', $regionId = 1, $shorterType = null){

        if(!$shorterType){
            $shorterType = strtoupper($type);
        }else {
            $shorterType = strtoupper($shorterType);
        }

        $suffix = $this->getRegionSuffix($regionId);
        if($this->isQA()){//QA - Q is suffix
            $suffix = 'Q';
        }

        $collection    = Mage::getModel("bs_{$type}/{$type}")->getCollection();

        $now = Mage::getModel('core/date')->timestamp(time());
        $year = date('Y', $now);

        $collection->addFieldToFilter('ref_no', array('like' => '%-'.$year.'%-'.$suffix));
        $collection->setOrder('entity_id', 'DESC');

        $nextRefNo = null;
        if($collection->getFirstItem() && $collection->getFirstItem()->getId()){
            $lastRefNo = $collection->getFirstItem()->getRefNo();
            $lastRefNo = explode("-", $lastRefNo);
            $lastIncrement = intval($lastRefNo[0]);
            $nextIncrement = $lastIncrement + 1;
            if($nextIncrement < 10){
                //$nextIncrement = '0'.$nextIncrement;
            }
            $nextRefNo = sprintf("%s-%s/%s-%s", $nextIncrement, $year, $shorterType, $suffix);

        }else {
            $nextRefNo = sprintf("1-%s/%s-%s", $year, $shorterType, $suffix);
        }

        return $nextRefNo;
    }

    public function getNextOtherRefNo($type = 'other', $regionId = 1, $shorterType = null){

        if(!$shorterType){
            $shorterType = strtoupper($type);
        }else {
            $shorterType = strtoupper($shorterType);
        }
        $suffix = $this->getRegionSuffix($regionId);

        $collection    = Mage::getModel("bs_{$type}/{$type}")->getCollection();

        $now = Mage::getModel('core/date')->timestamp(time());
        $dateStart = date('Y-m-d' . ' 00:00:00', $now);
        $dateEnd = date('Y-m-d' . ' 23:59:59', $now);
        $year = date('Y', $now);
        /*$collection->addFieldToFilter('created_at', array(
            'from' => $dateStart,
            'to' => $dateEnd,
            'date' => true,
        ));*/
        $collection->addFieldToFilter('ref_no', array('like' => '%'.$shorterType.$year));
        $collection->setOrder('entity_id', 'DESC');

        $nextRefNo = null;
        if($collection->getFirstItem() && $collection->getFirstItem()->getId()){
            $lastRefNo = $collection->getFirstItem()->getRefNo();
            $lastRefNo = explode("-", $lastRefNo);
            $lastIncrement = intval(end($lastRefNo));
            $nextIncrement = $lastIncrement + 1;
            if($nextIncrement < 10){
                //$nextIncrement = '0'.$nextIncrement;
            }
            $nextRefNo = sprintf("%s%s%s", $nextIncrement, $shorterType,  $year);

        }else {
            $nextRefNo = sprintf("1%s%s", $shorterType,  $year);
        }

        return $nextRefNo;
    }

    public function getRegionSuffix($regionId, $sectionId = null, $empty = false){
        $suffix = '';
        if($sectionId){
            $suffix .= Mage::getModel('bs_sur/sur_attribute_source_section')->getOptionText($sectionId);
            $suffix .= '-';
        }
        if($regionId == 1){
            $suffix .= 'H';
        }elseif ($regionId == 2){
            $suffix .= 'S';
        }elseif(!$empty) {
            $suffix .= 'NA';

        }


        return $suffix;
    }

    public function isCorrectRegionSection($object, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        $region = $object->getRegion();
        $section = $object->getSection();

        if($region == $currentUserInfo[2] && $section == $currentUserInfo[3]){
            return true;
        }

    }

    public function isSuperAdmin($currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if(in_array($currentUserInfo[1], [1,3])){
            return true;
        }
        return false;
    }

    public function isAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        if(in_array($currentUserInfo[1], [4,8])){
            if($object){
                if($this->isCorrectRegionSection($object, $currentUserInfo)){
                    return true;
                }

            }else {
                return true;
            }

        }

        return false;
    }

    public function isManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        if(in_array($currentUserInfo[1], [5,9])){
            if($object){
                if($this->isCorrectRegionSection($object, $currentUserInfo)){
                    return true;
                }

            }else {
                return true;
            }
        }

        return false;
    }

    public function isDeputyManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        if(in_array($currentUserInfo[1], [6,10])){
            if($object){
                if($this->isCorrectRegionSection($object, $currentUserInfo)){
                    return true;
                }

            }else {
                return true;
            }
        }

        return false;
    }

    public function isTeamLeader($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        if(in_array($currentUserInfo[1], [12,13])){
            if($object){
                if($this->isCorrectRegionSection($object, $currentUserInfo)){
                    return true;
                }

            }else {
                return true;
            }
        }

        return false;
    }

    public function isOwner($object, $currentUserInfo = null){
        if(!$object){
            return true;
        }
        if($object && !$object->getId()){
            return true;
        }
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        $insId = $object->getInsId();

        if($insId == $currentUserInfo[0]){//owner
            return true;
        }

        return false;
    }

    public function isQC($currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($currentUserInfo[3] == 1){
            return true;
        }
        return false;
    }

    public function isQA($currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($currentUserInfo[3] == 2){
            return true;
        }
        return false;
    }

    public function isHAN($currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($currentUserInfo[2] == 1){
            return true;
        }
        return false;
    }

    public function isHCM($currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($currentUserInfo[2] == 2){
            return true;
        }
        return false;
    }

    public function isHANAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($this->isQCHANAdmin($object, $currentUserInfo) || $this->isQAHANAdmin($object, $currentUserInfo)){
            return true;
        }
        return false;
    }

    public function isHCMAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($this->isQCHCMAdmin($object, $currentUserInfo) || $this->isQAHCMAdmin($object, $currentUserInfo)){
            return true;
        }
        return false;
    }

    public function isQCAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQC($currentUserInfo) && $this->isAdmin($object, $currentUserInfo);
    }

    public function isQCHANAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQCAdmin($object, $currentUserInfo) && $this->isHAN($currentUserInfo);
    }

    public function isQCHCMAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQCAdmin($object, $currentUserInfo) && $this->isHCM($currentUserInfo);
    }

    public function isQAAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQA($currentUserInfo) && $this->isAdmin($object, $currentUserInfo);
    }

    public function isQAHANAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQAAdmin($object, $currentUserInfo) && $this->isHAN($currentUserInfo);
    }

    public function isQAHCMAdmin($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQAAdmin($object, $currentUserInfo) && $this->isHCM($currentUserInfo);
    }

    public function isQCManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQC($currentUserInfo) && $this->isManager($object, $currentUserInfo);
    }

    public function isQCHANManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQCManager($object, $currentUserInfo) && $this->isHAN($currentUserInfo);
    }

    public function isQCHCMManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQCManager($object, $currentUserInfo) && $this->isHCM($currentUserInfo);
    }

    public function isQAManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQA($currentUserInfo) && $this->isManager($object, $currentUserInfo);
    }

    public function isQAHANManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQAManager($object, $currentUserInfo) && $this->isHAN($currentUserInfo);
    }

    public function isQAHCMManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQAManager($object, $currentUserInfo) && $this->isHCM($currentUserInfo);
    }

    public function isQCDeputyManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQC($currentUserInfo) && $this->isDeputyManager($object, $currentUserInfo);
    }

    public function isQCHANDeputyManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQCDeputyManager($object, $currentUserInfo) && $this->isHAN($currentUserInfo);
    }

    public function isQCHCMDeputyManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQCDeputyManager($object, $currentUserInfo) && $this->isHCM($currentUserInfo);
    }

    public function isQADeputyManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQA($currentUserInfo) && $this->isDeputyManager($object, $currentUserInfo);
    }

    public function isQAHANDeputyManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQADeputyManager($object, $currentUserInfo) && $this->isHAN($currentUserInfo);
    }

    public function isQAHCMDeputyManager($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQADeputyManager($object, $currentUserInfo) && $this->isHCM($currentUserInfo);
    }

    public function isQCTeamLeader($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQC($currentUserInfo) && $this->isTeamLeader($object, $currentUserInfo);
    }

    public function isQCHANTeamLeader($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQCTeamLeader($object, $currentUserInfo) && $this->isHAN($currentUserInfo);
    }

    public function isQCHCMTeamLeader($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQCTeamLeader($object, $currentUserInfo) && $this->isHCM($currentUserInfo);
    }

    public function isQATeamLeader($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQA($currentUserInfo) && $this->isTeamLeader($object, $currentUserInfo);
    }

    public function isQAHANTeamLeader($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQATeamLeader($object, $currentUserInfo) && $this->isHAN($currentUserInfo);
    }

    public function isQAHCMTeamLeader($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        return $this->isQATeamLeader($object, $currentUserInfo) && $this->isHCM($currentUserInfo);
    }

    public function canChangeInspector($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        if($this->isSuperAdmin($currentUserInfo)){
            return true;
        }

        if($this->isAdmin($object, $currentUserInfo) || $this->isManager($object, $currentUserInfo)){
            return true;
        }

        return false;
    }

    public function canChangeApproval($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($this->isSuperAdmin($currentUserInfo)){
            return true;
        }

        if($this->isAdmin($object, $currentUserInfo)){
            return true;
        }

        return false;
    }

    public function canChangeStatus($object = null, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($this->isSuperAdmin($currentUserInfo) || $this->isAdmin($object, $currentUserInfo)){
            return true;
        }

        return false;
    }

    public function canDelete($object = null, $currentUserInfo = null, $conditions = []){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($this->isSuperAdmin($currentUserInfo)){
            return true;
        }

        if($this->isAdmin($object, $currentUserInfo)){
            return true;
        }

        //if owner, we need to check conditions
        if($object){
            if($this->isOwner($object, $currentUserInfo)){
                //conditions will be an array of key and value, we will check if one of key == value then return false, else return true
                if(count($conditions)){
                    foreach ($conditions as $key => $value) {
                        if($object->getData($key) != $value ){
                            return false;
                        }
                    }

                }
                return true;

            }
        }


        return false;
    }


    public function canEdit($object, $currentUserInfo = null, $conditions = []){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        if($this->isSuperAdmin($currentUserInfo)){
            return true;
        }

        if($this->isAdmin($object, $currentUserInfo)){
            return true;
        }

        //if owner, we need to check conditions
        if($this->isOwner($object, $currentUserInfo)){
            if(count($conditions)){
                //conditions will be an array of key and value, we will check if one of key == value then return false, else return true
                foreach ($conditions as $key => $value) {
                    if($object->getData($key) != $value ){
                        return false;
                    }
                }
                return true;


            }
            return true;
        }





        return false;

    }

    public function canAcceptReject($object, $currentUserInfo = null, $conditions = [], $bypass = false){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }
        if($bypass){
            if(count($conditions)){
                //conditions will be an array of key and value, we will check if one of key == value then return false, else return true
                foreach ($conditions as $key => $value) {
                    if($object->getData($key) != $value ){
                        return false;
                    }
                }
                return true;


            }
            return true;
        }
        if($this->isManager($object, $currentUserInfo)){
            if(count($conditions)){
                //conditions will be an array of key and value, we will check if one of key == value then return false, else return true
                foreach ($conditions as $key => $value) {
                    if($object->getData($key) != $value ){
                        return false;
                    }
                }
                return true;


            }
            return true;

        }

        return false;

    }

    public function canEditAsAdmin($object, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        if($this->isSuperAdmin($currentUserInfo)
            || $this->isAdmin($currentUserInfo, $object)


        ){
            return true;
        }
        return false;

    }

    public function canEditAsManager($object, $currentUserInfo = null){
        if(!$currentUserInfo){
            $currentUserInfo = $this->getCurrentUserInfo();
        }

        if($this->isSuperAdmin($currentUserInfo)
            || $this->isAdmin($currentUserInfo, $object)


        ){
            return true;
        }
        return false;

    }

}
