<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Task edit form tab
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Subtask_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Subtask_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('subtask_');
        $form->setFieldNameSuffix('subtask');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'subtask_form',
            array('legend' => Mage::helper('bs_misc')->__('Survey Sub Code'))
        );
        $values = Mage::getResourceModel('bs_misc/task_collection')
            ->toOptionArray();
        array_unshift($values, array('label' => '', 'value' => ''));

        $html = '<a href="{#url}" id="subtask_task_id_link" target="_blank"></a>';
        $html .= '<script type="text/javascript">
            function changeTaskIdLink() {
                if ($(\'subtask_task_id\').value == \'\') {
                    $(\'subtask_task_id_link\').hide();
                } else {
                    $(\'subtask_task_id_link\').show();
                    var url = \''.$this->getUrl('adminhtml/misc_task/edit', array('id'=>'{#id}', 'clear'=>1)).'\';
                    var text = \''.Mage::helper('core')->escapeHtml($this->__('View {#name}')).'\';
                    var realUrl = url.replace(\'{#id}\', $(\'subtask_task_id\').value);
                    $(\'subtask_task_id_link\').href = realUrl;
                    $(\'subtask_task_id_link\').innerHTML = text.replace(\'{#name}\', $(\'subtask_task_id\').options[$(\'subtask_task_id\').selectedIndex].innerHTML);
                }
            }
            $(\'subtask_task_id\').observe(\'change\', changeTaskIdLink);
            changeTaskIdLink();
            </script>';

        $fieldset->addField(
            'task_id',
            'select',
            array(
                'label'     => Mage::helper('bs_misc')->__('Survey Code'),
                'name'      => 'task_id',
                'required'  => false,
                'values'    => $values,
                'after_element_html' => $html
            )
        );

        $fieldset->addField(
            'sub_code',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Sub Task Code'),
                'name'  => 'sub_code',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'is_mandatory',
            'select',
            array(
                'label'  => Mage::helper('bs_misc')->__('Mandatory'),
                'name'   => 'is_mandatory',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_misc')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_misc')->__('No'),
                    ),
                ),
            )
        );

        $fieldset->addField(
            'points',
            'text',
            array(
                'label' => Mage::helper('bs_misc')->__('Points'),
                'name'  => 'points',

            )
        );

        $fieldset->addField(
            'sub_desc',
            'textarea',
            array(
                'label' => Mage::helper('bs_misc')->__('Description'),
                'name'  => 'sub_desc',
                'config' => $wysiwygConfig,

           )
        );

        $fieldset->addField(
            'import',
            'textarea',
            array(
                'label' => Mage::helper('bs_misc')->__('OR Import from this'),
                'name'  => 'import',
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
        $formValues = Mage::registry('current_subtask')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSubtaskData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSubtaskData());
            Mage::getSingleton('adminhtml/session')->setSubtaskData(null);
        } elseif (Mage::registry('current_subtask')) {
            $formValues = array_merge($formValues, Mage::registry('current_subtask')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
