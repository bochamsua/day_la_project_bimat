<?php
/**
 * BS_Nrw extension
 * 
 * @category       BS
 * @package        BS_Nrw
 * @copyright      Copyright (c) 2018
 */
/**
 * Non-routine Work edit form tab
 *
 * @category    BS
 * @package     BS_Nrw
 * @author Bui Phong
 */
class BS_Nrw_Block_Adminhtml_Nrw_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Nrw_Block_Adminhtml_Nrw_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('nrw_');
        $form->setFieldNameSuffix('nrw');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'nrw_form',
            ['legend' => Mage::helper('bs_nrw')->__('Non-routine Work')]
        );

        $currentObj = Mage::registry('current_nrw');
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_nrw/adminhtml_nrw_helper_file')
        );

        $misc = $this->helper('bs_misc');
        $currentUser = $misc->getCurrentUserInfo();


        $html = '<span id="nrw_staff_id_link"></span>';
        $html .= '<script type="text/javascript">
            function loadOngoingWork() {
                if ($(\'nrw_staff_id\').value == \'\') {
                    $(\'nrw_staff_id_link\').hide();
                } else {
                    $(\'nrw_staff_id_link\').show();
                    
                    new Ajax.Request(\''.$this->getUrl("*/nrw_nrw/loadOngoingWorks").'\', {
                        method : \'post\',
                        parameters: {
                            \'staff_id\'   : $(\'nrw_staff_id\').value,
                        },
                        onSuccess : function(transport){
                            try{
                                response = eval(\'(\' + transport.responseText + \')\');
                            } catch (e) {
                                response = {};
                            }
                            if (response.works) {
                            
                                $(\'nrw_staff_id_link\').innerHTML = response.works;
                               

                            }

                        },
                        onFailure : function(transport) {
                            alert(\'Something went wrong\')
                        }
                    });
                            
                    
                }
            }
            $(\'nrw_staff_id\').observe(\'change\', loadOngoingWork);
            loadOngoingWork();
            </script>';


        $fieldset->addField(
            'staff_id',
            'select',
            [
                'label' => Mage::helper('bs_nrw')->__('Staff'),
                'name'  => 'staff_id',
                'values'=> Mage::helper('bs_misc/user')->getUsers(false, true, false, true, true),
                'after_element_html' => $html,
            ]
        );

        $fieldset->addField(
            'report_date',
            'date',
            [
                'label' => Mage::helper('bs_nrw')->__('Issue Date'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'due_date',
            'date',
            [
                'label' => Mage::helper('bs_nrw')->__('Due Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        /*$fieldset->addField(
            'nrw_type',
            'select',
            [
                'label' => Mage::helper('bs_nrw')->__('Type'),
                'name'  => 'nrw_type',

                'values'=> Mage::getModel('bs_nrw/nrw_attribute_source_nrwtype')->getAllOptions(true),
           ]
        );*/

        $fieldset->addField(
            'description',
            'textarea',
            [
                'label' => Mage::helper('bs_nrw')->__('Description'),
                'name'  => 'description',

           ]
        );




        if($misc->canAcceptReject($currentObj, $currentUser, ['staff_id' => $currentUser[0]], true)){//manager

            if($currentObj->getNrwStatus() != 1){
                $fieldset->addField(
                    'reject_reason',
                    'text',
                    [
                        'label' => Mage::helper('bs_nrw')->__('Reject Reason'),
                        'name'  => 'reject_reason',

                    ]
                );
            }

        }


        //if Rejected, manager should be able to update status
        /*if($currentObj->getNrwStatus() == 2){//rejected
            $fieldset->addField(
                'nrw_status',
                'select',
                [
                    'label' => Mage::helper('bs_nrw')->__('Status'),
                    'name'  => 'nrw_status',
                    'values'=> Mage::getModel('bs_nrw/nrw_attribute_source_nrwstatus')->getOptionsArray(),
                ]
            );
        }*/


        if(in_array($currentObj->getNrwStatus(), [1,4]) && $misc->isOwner($currentObj, $currentUser)){//ongoing, manager can close
            $fieldset->addField(
                'close_date',
                'date',
                [
                    'label' => Mage::helper('bs_nrw')->__('Close Date'),
                    'name'  => 'close_date',

                    'image' => $this->getSkinUrl('images/grid-cal.gif'),
                    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                ]
            );

            $fieldset->addField(
                'remark_text',
                'text',
                [
                    'label' => Mage::helper('bs_ncr')->__('Remark'),
                    'name'  => 'remark_text',

                ]
            );
        }




        /*$fieldset->addField(
            'nrw_source',
            'file',
            [
                'label' => Mage::helper('bs_nrw')->__('Source'),
                'name'  => 'nrw_source',

           ]
        );*/
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_nrw')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_nrw')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_nrw')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_nrw')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getNrwData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getNrwData());
            Mage::getSingleton('adminhtml/session')->setNrwData(null);
        } elseif (Mage::registry('current_nrw')) {
            $formValues = array_merge($formValues, Mage::registry('current_nrw')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
