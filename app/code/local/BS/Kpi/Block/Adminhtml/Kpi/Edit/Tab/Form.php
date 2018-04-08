<?php
/**
 * BS_Kpi extension
 * 
 * @category       BS
 * @package        BS_Kpi
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Data edit form tab
 *
 * @category    BS
 * @package     BS_Kpi
 * @author Bui Phong
 */
class BS_Kpi_Block_Adminhtml_Kpi_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Kpi_Block_Adminhtml_Kpi_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('kpi_');
        $form->setFieldNameSuffix('kpi');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'kpi_form',
            ['legend' => Mage::helper('bs_kpi')->__('KPI Data')]
        );

	    $fieldset->addField(
		    'month',
		    'select',
		    [
			    'label'     => Mage::helper('bs_kpi')->__('Month'),
			    'name'      => 'month',
			    'required'  => false,
			    'values'    => Mage::helper('bs_report')->getMonths(true),
            ]
	    );

	    $fieldset->addField(
		    'year',
		    'select',
		    [
			    'label'     => Mage::helper('bs_kpi')->__('Year'),
			    'name'      => 'year',
			    'required'  => false,
			    'values'    => Mage::helper('bs_report')->getYears(true),
            ]
	    );

	    $depts = Mage::helper('bs_misc/dept')->getDepts(true);
	    $fieldset->addField(
		    'dept_id',
		    'select',
		    [
			    'label'     => Mage::helper('bs_kpi')->__('Maint. Center'),
			    'name'      => 'dept_id',
			    'required'  => false,
			    'values'    => $depts,
            ]
	    );

        $fieldset->addField(
            'mass_production',
            'text',
            [
                'label' => Mage::helper('bs_kpi')->__('Mass Production'),
                'name'  => 'mass_production',

            ]
        );

        $fieldset->addField(
            'self_ncr',
            'text',
            [
                'label' => Mage::helper('bs_kpi')->__('Self-decteced NCR'),
                'name'  => 'self_ncr',

            ]
        );

        $fieldset->addField(
            'man_hours',
            'text',
            [
                'label' => Mage::helper('bs_kpi')->__('Man Hours'),
                'name'  => 'man_hours',

            ]
        );

        $fieldset->addField(
            'schedule_workflow',
            'text',
            [
                'label' => Mage::helper('bs_kpi')->__('Schedule Workflow Period'),
                'name'  => 'schedule_workflow',

            ]
        );

        $fieldset->addField(
            'actual_workflow',
            'text',
            [
                'label' => Mage::helper('bs_kpi')->__('Actual Workflow Period'),
                'name'  => 'actual_workflow',

            ]
        );

        $fieldset->addField(
            'interrelationship_complaint',
            'text',
            [
                'label' => Mage::helper('bs_kpi')->__('Interrelationship Complaint'),
                'name'  => 'interrelationship_complaint',

            ]
        );

        $fieldset->addField(
            'customer_complaint',
            'text',
            [
                'label' => Mage::helper('bs_kpi')->__('Customer Complaint'),
                'name'  => 'customer_complaint',

            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_kpi')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_kpi')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_kpi')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_kpi')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getKpiData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getKpiData());
            Mage::getSingleton('adminhtml/session')->setKpiData(null);
        } elseif (Mage::registry('current_kpi')) {
            $formValues = array_merge($formValues, Mage::registry('current_kpi')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
