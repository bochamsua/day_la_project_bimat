<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Task edit form tab
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Block_Adminhtml_Task_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Misc_Block_Adminhtml_Task_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('task_');
        $form->setFieldNameSuffix('task');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'task_form',
            ['legend' => Mage::helper('bs_misc')->__('Survey Code')]
        );
        $values = Mage::getResourceModel('bs_misc/taskgroup_collection')
            ->toOptionArray();
        array_unshift($values, ['label' => '', 'value' => '']);

        $html = '<a href="{#url}" id="task_taskgroup_id_link" target="_blank"></a>';
        $html .= '<script type="text/javascript">
            function changeTaskgroupIdLink() {
                if ($(\'task_taskgroup_id\').value == \'\') {
                    $(\'task_taskgroup_id_link\').hide();
                } else {
                    $(\'task_taskgroup_id_link\').show();
                    var url = \''.$this->getUrl('adminhtml/misc_taskgroup/edit', ['id'=>'{#id}', 'clear'=>1]).'\';
                    var text = \''.Mage::helper('core')->escapeHtml($this->__('View {#name}')).'\';
                    var realUrl = url.replace(\'{#id}\', $(\'task_taskgroup_id\').value);
                    $(\'task_taskgroup_id_link\').href = realUrl;
                    $(\'task_taskgroup_id_link\').innerHTML = text.replace(\'{#name}\', $(\'task_taskgroup_id\').options[$(\'task_taskgroup_id\').selectedIndex].innerHTML);
                }
            }
            $(\'task_taskgroup_id\').observe(\'change\', changeTaskgroupIdLink);
            changeTaskgroupIdLink();
            </script>';

        $fieldset->addField(
            'taskgroup_id',
            'select',
            [
                'label'     => Mage::helper('bs_misc')->__('Survey Group'),
                'name'      => 'taskgroup_id',
                'required'  => false,
                'values'    => $values,
                'after_element_html' => $html
            ]
        );

        $fieldset->addField(
            'task_code',
            'text',
            [
                'label' => Mage::helper('bs_misc')->__('Task Code'),
                'name'  => 'task_code',
            'required'  => true,
            'class' => 'required-entry',

            ]
        );

	    $fieldset->addField(
		    'points',
		    'text',
		    [
			    'label' => Mage::helper('bs_misc')->__('Points'),
			    'name'  => 'points',


            ]
	    );

        $fieldset->addField(
            'task_desc',
            'textarea',
            [
                'label' => Mage::helper('bs_misc')->__('Description'),
                'name'  => 'task_desc',
                'config' => $wysiwygConfig,

            ]
        );

        $fieldset->addField(
            'import',
            'textarea',
            [
                'label' => Mage::helper('bs_misc')->__('OR Import from this'),
                'name'  => 'import',

            ]
        );

        $formValues = Mage::registry('current_task')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getTaskData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getTaskData());
            Mage::getSingleton('adminhtml/session')->setTaskData(null);
        } elseif (Mage::registry('current_task')) {
            $formValues = array_merge($formValues, Mage::registry('current_task')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
