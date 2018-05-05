<?php
/**
 * BS_Client extension
 * 
 * @category       BS
 * @package        BS_Client
 * @copyright      Copyright (c) 2018
 */
/**
 * Client edit form tab
 *
 * @category    BS
 * @package     BS_Client
 * @author Bui Phong
 */
class BS_Client_Block_Adminhtml_Client_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Client_Block_Adminhtml_Client_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('client_');
        $form->setFieldNameSuffix('client');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'client_form',
            ['legend' => Mage::helper('bs_client')->__('Client')]
        );

        $currentObj = Mage::registry('current_client');
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_client/adminhtml_client_helper_file')
        );


        $misc = $this->helper('bs_misc');
        $currentUser = $misc->getCurrentUserInfo();

        $html = '<script type="text/javascript">
            function getCustomerCode() {
                if ($(\'client_customer\').value != \'\') {
                    
                    new Ajax.Request(\''.$this->getUrl("*/client_client/getCustomerCode").'\', {
                        method : \'post\',
                        parameters: {
                            \'customer\'   : $(\'client_customer\').value,
                        },
                        onSuccess : function(transport){
                            try{
                                response = eval(\'(\' + transport.responseText + \')\');
                            } catch (e) {
                                response = {};
                            }
                            if (response.code) {
                            
                                $(\'client_client_id\').value = response.code;
                               

                            }

                        },
                        onFailure : function(transport) {
                            alert(\'Something went wrong\')
                        }
                    });
                            
                    
                }
            }
            $(\'client_customer\').observe(\'change\', getCustomerCode);
            getCustomerCode();
            </script>';



        $customers = Mage::getResourceModel('bs_acreg/customer_collection');
        $customers = $customers->toOptionArray();
        array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
        $fieldset->addField(
            'customer',
            'select',
            [
                'label'     => Mage::helper('bs_client')->__('Customer'),
                'name'      => 'customer',
                'required'  => false,
                'values'    => $customers,
                'after_element_html' => $html,
            ]
        );

        $fieldset->addField(
            'client_id',
            'text',
            [
                'label' => Mage::helper('bs_client')->__('ID'),
                'name'  => 'client_id',
                'readonly' => true

           ]
        );

        $fieldset->addField(
            'approved_scope',
            'text',
            [
                'label' => Mage::helper('bs_client')->__('Approved Scope'),
                'name'  => 'approved_scope',

           ]
        );

        $fieldset->addField(
            'station',
            'text',
            [
                'label' => Mage::helper('bs_client')->__('Station'),
                'name'  => 'station',

           ]
        );

        $fieldset->addField(
            'authority',
            'text',
            [
                'label' => Mage::helper('bs_client')->__('Authority'),
                'name'  => 'authority',

           ]
        );

        $fieldset->addField(
            'approval_no',
            'text',
            [
                'label' => Mage::helper('bs_client')->__('Approval Number'),
                'name'  => 'approval_no',

           ]
        );

        $fieldset->addField(
            'client_source',
            'file',
            [
                'label' => Mage::helper('bs_client')->__('Source'),
                'name'  => 'client_source',

           ]
        );

        $fieldset->addField(
            'issue_date',
            'date',
            [
                'label' => Mage::helper('bs_client')->__('Issue Date'),
                'name'  => 'issue_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'expire_date',
            'date',
            [
                'label' => Mage::helper('bs_client')->__('Expire Date'),
                'name'  => 'expire_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           ]
        );

        $fieldset->addField(
            'remaining',
            'text',
            [
                'label' => Mage::helper('bs_client')->__('Remaining'),
                'name'  => 'remaining',

           ]
        );

        $fieldset->addField(
            'remark_text',
            'textarea',
            [
                'label' => Mage::helper('bs_client')->__('Remark'),
                'name'  => 'remark_text',

           ]
        );



        /*$fieldset->addField(
            'client_status',
            'select',
            [
                'label' => Mage::helper('bs_client')->__('Status'),
                'name'  => 'client_status',

            'values'=> Mage::getModel('bs_client/client_attribute_source_clientstatus')->getAllOptions(true),
           ]
        );*/


        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_client')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_client')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_client')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_client')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getClientData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getClientData());
            Mage::getSingleton('adminhtml/session')->setClientData(null);
        } elseif (Mage::registry('current_client')) {
            $formValues = array_merge($formValues, Mage::registry('current_client')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
