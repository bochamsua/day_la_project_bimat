<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Cause edit form tab
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Block_Adminhtml_Ncause_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_NCause_Block_Adminhtml_Ncause_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('ncause_');
        $form->setFieldNameSuffix('ncause');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'ncause_form',
            array('legend' => Mage::helper('bs_ncause')->__('Root Cause Sub Code'))
        );
        $values = Mage::getResourceModel('bs_ncause/ncausegroup_collection')
            ->toOptionArray();
        array_unshift($values, array('label' => '', 'value' => ''));

        $html = '<a href="{#url}" id="ncause_ncausegroup_id_link" target="_blank"></a>';
        $html .= '<script type="text/javascript">
            function changeNcausegroupIdLink() {
                if ($(\'ncause_ncausegroup_id\').value == \'\') {
                    $(\'ncause_ncausegroup_id_link\').hide();
                } else {
                    $(\'ncause_ncausegroup_id_link\').show();
                    var url = \''.$this->getUrl('adminhtml/ncause_ncausegroup/edit', array('id'=>'{#id}', 'clear'=>1)).'\';
                    var text = \''.Mage::helper('core')->escapeHtml($this->__('View {#name}')).'\';
                    var realUrl = url.replace(\'{#id}\', $(\'ncause_ncausegroup_id\').value);
                    $(\'ncause_ncausegroup_id_link\').href = realUrl;
                    $(\'ncause_ncausegroup_id_link\').innerHTML = text.replace(\'{#name}\', $(\'ncause_ncausegroup_id\').options[$(\'ncause_ncausegroup_id\').selectedIndex].innerHTML);
                }
            }
            $(\'ncause_ncausegroup_id\').observe(\'change\', changeNcausegroupIdLink);
            changeNcausegroupIdLink();
            </script>';

        $fieldset->addField(
            'ncausegroup_id',
            'select',
            array(
                'label'     => Mage::helper('bs_ncause')->__('Root Cause Code'),
                'name'      => 'ncausegroup_id',
                'required'  => false,
                'values'    => $values,
                'after_element_html' => $html
            )
        );

        $fieldset->addField(
            'cause_code',
            'text',
            array(
                'label' => Mage::helper('bs_ncause')->__('Cause Code'),
                'name'  => 'cause_code',

           )
        );

        $fieldset->addField(
            'cause_name',
            'text',
            array(
                'label' => Mage::helper('bs_ncause')->__('Cause Name'),
                'name'  => 'cause_name',

           )
        );

        $fieldset->addField(
            'points',
            'text',
            array(
                'label' => Mage::helper('bs_ncause')->__('Points'),
                'name'  => 'points',

            )
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_ncause')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_ncause')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_ncause')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_ncause')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getNcauseData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getNcauseData());
            Mage::getSingleton('adminhtml/session')->setNcauseData(null);
        } elseif (Mage::registry('current_ncause')) {
            $formValues = array_merge($formValues, Mage::registry('current_ncause')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
