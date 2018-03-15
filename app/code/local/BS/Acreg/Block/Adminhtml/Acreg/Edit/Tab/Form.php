<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * A/C Reg edit form tab
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Block_Adminhtml_Acreg_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Acreg_Block_Adminhtml_Acreg_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('acreg_');
        $form->setFieldNameSuffix('acreg');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'acreg_form',
            array('legend' => Mage::helper('bs_acreg')->__('A/C Reg'))
        );
        $values = Mage::getResourceModel('bs_acreg/customer_collection')
            ->toOptionArray();
        //array_unshift($values, array('label' => '', 'value' => ''));

        $html = '<a href="{#url}" id="acreg_customer_id_link" target="_blank"></a>';
        $html .= '<script type="text/javascript">
            function changeCustomerIdLink() {
                if ($(\'acreg_customer_id\').value == \'\') {
                    $(\'acreg_customer_id_link\').hide();
                } else {
                    $(\'acreg_customer_id_link\').show();
                    var url = \''.$this->getUrl('adminhtml/acreg_customer/edit', array('id'=>'{#id}', 'clear'=>1)).'\';
                    var text = \''.Mage::helper('core')->escapeHtml($this->__('View {#name}')).'\';
                    var realUrl = url.replace(\'{#id}\', $(\'acreg_customer_id\').value);
                    $(\'acreg_customer_id_link\').href = realUrl;
                    $(\'acreg_customer_id_link\').innerHTML = text.replace(\'{#name}\', $(\'acreg_customer_id\').options[$(\'acreg_customer_id\').selectedIndex].innerHTML);
                }
            }
            $(\'acreg_customer_id\').observe(\'change\', changeCustomerIdLink);
            changeCustomerIdLink();
            </script>';

        $fieldset->addField(
            'customer_id',
            'select',
            array(
                'label'     => Mage::helper('bs_acreg')->__('Customer'),
                'name'      => 'customer_id',
                'required'  => false,
                'values'    => $values,
                //'after_element_html' => $html
            )
        );

	    $acTypes = Mage::getResourceModel('bs_misc/aircraft_collection')
	                 ->toOptionArray();
	    array_unshift($values, array('label' => '', 'value' => ''));

	    $fieldset->addField(
		    'ac_type',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_acreg')->__('A/C Type'),
			    'name'      => 'ac_type',
			    'required'  => false,
			    'values'    => $acTypes,
		    )
	    );

        $fieldset->addField(
            'reg',
            'text',
            array(
                'label' => Mage::helper('bs_acreg')->__('Number'),
                'name'  => 'reg',

           )
        );


	    $fieldset->addField(
		    'import',
		    'textarea',
		    array(
			    'label' => Mage::helper('bs_acreg')->__('Or import from this?'),
			    'name'  => 'import',
			    'config' => $wysiwygConfig,

		    )
	    );



        $formValues = Mage::registry('current_acreg')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getAcregData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getAcregData());
            Mage::getSingleton('adminhtml/session')->setAcregData(null);
        } elseif (Mage::registry('current_acreg')) {
            $formValues = array_merge($formValues, Mage::registry('current_acreg')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
