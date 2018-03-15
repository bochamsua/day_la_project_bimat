<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Sub Task edit form tab
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Subsubtask_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Subsubtask_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('subsubtask_');
        $form->setFieldNameSuffix('subsubtask');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'subsubtask_form',
            array('legend' => Mage::helper('bs_misc')->__('Survey Sub Sub Code'))
        );
        $values = Mage::getResourceModel('bs_misc/subtask_collection')
            ->toOptionArray();
        array_unshift($values, array('label' => '', 'value' => ''));

        $html = '<a href="{#url}" id="subsubtask_subtask_id_link" target="_blank"></a>';
        $html .= '<script type="text/javascript">
            function changeSubtaskIdLink() {
                if ($(\'subsubtask_subtask_id\').value == \'\') {
                    $(\'subsubtask_subtask_id_link\').hide();
                } else {
                    $(\'subsubtask_subtask_id_link\').show();
                    var url = \''.$this->getUrl('adminhtml/misc_subtask/edit', array('id'=>'{#id}', 'clear'=>1)).'\';
                    var text = \''.Mage::helper('core')->escapeHtml($this->__('View {#name}')).'\';
                    var realUrl = url.replace(\'{#id}\', $(\'subsubtask_subtask_id\').value);
                    $(\'subsubtask_subtask_id_link\').href = realUrl;
                    $(\'subsubtask_subtask_id_link\').innerHTML = text.replace(\'{#name}\', $(\'subsubtask_subtask_id\').options[$(\'subsubtask_subtask_id\').selectedIndex].innerHTML);
                }
            }
            $(\'subsubtask_subtask_id\').observe(\'change\', changeSubtaskIdLink);
            changeSubtaskIdLink();
            </script>';

        $fieldset->addField(
            'subtask_id',
            'select',
            array(
                'label'     => Mage::helper('bs_misc')->__('Survey Sub Code'),
                'name'      => 'subtask_id',
                'required'  => false,
                'values'    => $values,
                'after_element_html' => $html
            )
        );

        $fieldset->addField(
            'subsub_code',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Sub sub code'),
                'name'  => 'subsub_code',

           )
        );

        $fieldset->addField(
            'subsub_desc',
            'textarea',
            array(
                'label' => Mage::helper('bs_misc')->__('Description'),
                'name'  => 'subsub_desc',
                'config' => $wysiwygConfig,

           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_misc')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_misc')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_misc')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_subsubtask')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSubsubtaskData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSubsubtaskData());
            Mage::getSingleton('adminhtml/session')->setSubsubtaskData(null);
        } elseif (Mage::registry('current_subsubtask')) {
            $formValues = array_merge($formValues, Mage::registry('current_subsubtask')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
