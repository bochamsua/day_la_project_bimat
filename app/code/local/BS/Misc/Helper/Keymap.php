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
class BS_Misc_Helper_Keymap extends BS_Misc_Helper_Data
{
    public function getExportHeader($type, $key){
        switch ($key){
            case 'entity_id':
                return 'ID';
                break;
            case 'ref_no':
                return 'Ref No';
                break;
            case 'ins_id':
                return 'Ins/Aud';
                break;
            case 'dept_id':
                return 'Department';
                break;
            case $type.'_status':
                return 'Status';
                break;
            case $type.'_type':
                return 'Type';
                break;
            case $type.'_source':
                return 'Source';
                break;
            case 'report_date':
                return 'Report Date';
                break;
            case 'ref_doc':
                return 'Ref Doc';
                break;
            case 'description':
                return 'Description';
                break;
            case 'due_date':
                return 'Due Date';
                break;
            case 'approval_id':
                return 'Approval';
                break;
            case 'remark':
                return 'Proof of Close';
                break;
            case 'close_date':
                return 'Close Date';
                break;
            case 'reject_reason':
                return 'Reject Reason';
                break;
            /*case 'ref_id':
                return 'Ref Id';
                break;*/
            case 'task_id':
                return 'Survey Code';
                break;
            case 'subtask_id':
                return 'Survey Sub Code';
                break;
            case 'ac_type':
                return 'AC Type';
                break;
            case 'customer':
                return 'Customer';
                break;
            case 'ac_reg':
                return 'AC Reg';
                break;
            case 'loc_id':
                return 'Location';
                break;
            case 'remark_text':
                return 'Remark';
                break;
            case 'ncausegroup_id':
                return 'Cause Group';
                break;
            case 'ncause_id':
                return 'Cause';
                break;
            case 'repetitive':
                return 'Repetitive';
                break;
            case 'error_type':
                return 'Error Type';
                break;
            case 'short_desc':
                return 'Short Description';
                break;
            case 'point':
                return 'Point';
                break;
            case 'ref_type':
                return 'Ref';
                break;
            case 'region':
                return 'Region';
                break;
            case 'section':
                return 'Section';
                break;
            case 'self_remark':
                return 'Self Remark';
                break;

            default:
                $newKey = uc_words($key, ' ');
                return $newKey;

        }
    }

    public function getExportValue($item, $type, $key){
        $currentValue = $item->getData($key);
        if($currentValue){
            switch ($key){
                case 'ins_id':
                case 'approval_id':
                    $ins = Mage::getModel('admin/user')->load($currentValue);
                    $name = $ins->getName();
                    return $name;
                    break;
                case 'dept_id':
                    $dept = Mage::getModel('bs_misc/department')->load($currentValue);
                    $deptName = $dept->getDeptCode();
                    return $deptName;
                    break;
                case $type.'_status':
                    $model = Mage::getModel("bs_{$type}/{$type}_attribute_source_{$type}status");
                    if($model){
                        $status = $model->getOptionText($currentValue);
                        return $status;
                    }
                    break;
                case $type.'_type':
                    $model = Mage::getModel("bs_{$type}/{$type}_attribute_source_{$type}type");
                    if($model){
                        $type = $model->getOptionText($currentValue);
                        return $type;
                    }


                    break;
                case $type.'_source':
                case 'remark':
                    $url = Mage::helper("bs_{$type}/{$type}")->getFileBaseUrl().$currentValue;
                    return $url;
                    break;
                case 'report_date':
                case 'due_date':
                case 'close_date':
                    return $this->_filterDates($currentValue);
                    break;
                case 'description':
                case 'subject':
                case 'reject_reason':
                case 'remark_text':
                case 'short_desc':
                case 'self_remark':
                    $value = html_entity_decode(strip_tags($currentValue, ""),
                        ENT_NOQUOTES, "UTF-8");
                    $value = $this->stripTags($value);
                    return $value;
                    break;
                case 'task_id':
                    $task = Mage::getModel('bs_misc/task')->load($currentValue)->getTaskCode();
                    return $task;
                    break;
                case 'subtask_id':
                    $sub = Mage::getModel('bs_misc/subtask')->load($currentValue)->getSubCode();
                    return $sub;
                    break;
                case 'ac_type':
                    $acType = Mage::getModel('bs_misc/aircraft')->load($currentValue)->getAcCode();
                    return $acType;
                    break;
                case 'customer':
                    $customer = Mage::getModel('bs_acreg/customer')->load($currentValue)->getName();
                    return $customer;
                    break;
                case 'ac_reg':
                    $acReg = Mage::getModel('bs_acreg/acreg')->load($currentValue)->getReg();
                    return $acReg;
                    break;
                case 'loc_id':
                    $loc = Mage::getModel('bs_misc/location')->load($currentValue)->getLocName();
                    return $loc;
                    break;
                case 'ncausegroup_id':
                    $causeGroup = Mage::getModel('bs_ncause/ncausegroup')->load($currentValue)->getGroupCode();
                    return $causeGroup;
                    break;
                case 'ncause_id':
                    $cause = Mage::getModel('bs_ncause/ncause')->load($currentValue)->getCauseCode();
                    return $cause;
                    break;
                case 'repetitive':
                    if($currentValue == 1){
                        return 'Yes';
                    }else {
                        return 'No';
                    }

                    break;
                case 'error_type':
                    $model = Mage::getModel("bs_{$type}/{$type}_attribute_source_errortype");
                    if($model){
                        $errorType = $model->getOptionText($currentValue);
                        return $errorType;
                    }
                    break;
                /*case 'ref_type':
                    return 'Ref Type';
                    break;*/
                case 'region':
                    $region = Mage::getModel('bs_sur/sur_attribute_source_region')->getOptionText($currentValue);
                    return $region;
                    break;
                case 'section':
                    $section = Mage::getModel('bs_sur/sur_attribute_source_section')->getOptionText($currentValue);
                    return $section;
                    break;

                case 'ref_type':
                    $ref = Mage::getModel("bs_{$currentValue}/{$currentValue}")->load($item->getData('ref_id'))->getRefNo();
                    return $ref;
                    break;

                default:
                    return $currentValue;

            }
        }

        return '';

    }

    protected function _filterDates($date)
    {

        $format =  Mage::app()->getLocale()->getDateFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM
        );
        $date = Mage::getSingleton('core/locale')
            ->date($date, Zend_Date::ISO_8601, null, false)->toString($format);


        return $date;
    }
}
