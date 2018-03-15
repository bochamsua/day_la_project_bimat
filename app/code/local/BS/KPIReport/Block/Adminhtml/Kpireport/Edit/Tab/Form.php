<?php
/**
 * BS_KPIReport extension
 * 
 * @category       BS
 * @package        BS_KPIReport
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Report edit form tab
 *
 * @category    BS
 * @package     BS_KPIReport
 * @author Bui Phong
 */
class BS_KPIReport_Block_Adminhtml_Kpireport_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_KPIReport_Block_Adminhtml_Kpireport_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('kpireport_');
        $form->setFieldNameSuffix('kpireport');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'kpireport_form',
            array('legend' => Mage::helper('bs_kpireport')->__('KPI Report'))
        );

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionArray();
	    $fieldset->addField(
		    'dept_id',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_kpireport')->__('Maint. Center'),
			    'name'      => 'dept_id',
			    'required'  => false,
			    'values'    => $depts,
		    )
	    );

	    $fieldset->addField(
		    'month',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_kpireport')->__('Month'),
			    'name'      => 'month',
			    'required'  => false,
			    'values'    => Mage::helper('bs_report')->getMonths(true),
		    )
	    );

	    $fieldset->addField(
		    'year',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_kpireport')->__('Year'),
			    'name'      => 'year',
			    'required'  => false,
			    'values'    => Mage::helper('bs_report')->getYears(true),
		    )
	    );



        $fieldset->addField(
            'qsr',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Quality Surveillance Rate'),
                'name'  => 'qsr',

           )
        );

        $fieldset->addField(
            'ncr',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Non-Comformity Rate'),
                'name'  => 'ncr',

           )
        );

        $fieldset->addField(
            'mncr',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Mass Non-Comformity Rate'),
                'name'  => 'mncr',

           )
        );

        $fieldset->addField(
            'mer',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Maintenance Error Rate'),
                'name'  => 'mer',

           )
        );

        $fieldset->addField(
            'ser',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('System Error Rate'),
                'name'  => 'ser',

           )
        );

        $fieldset->addField(
            'rer',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Repetitive Error Rate'),
                'name'  => 'rer',

           )
        );

        $fieldset->addField(
            'camt',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Corrective Action Mean Time'),
                'name'  => 'camt',

           )
        );

        $fieldset->addField(
            'sdr',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Self-Detected Rate'),
                'name'  => 'sdr',

           )
        );

        $fieldset->addField(
            'csr',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Customer Satisfaction Rate'),
                'name'  => 'csr',

           )
        );

        $fieldset->addField(
            'cir',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Continuous Improvement Rate'),
                'name'  => 'cir',

           )
        );

        $fieldset->addField(
            'mir',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Man-power Improvement Rate'),
                'name'  => 'mir',

           )
        );

        $fieldset->addField(
            'ppe',
            'text',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Production Planning Efficiency'),
                'name'  => 'ppe',

           )
        );

        $fieldset->addField(
            'note',
            'textarea',
            array(
                'label' => Mage::helper('bs_kpireport')->__('Note'),
                'name'  => 'note',

           )
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_kpireport')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_kpireport')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_kpireport')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_kpireport')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getKpireportData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getKpireportData());
            Mage::getSingleton('adminhtml/session')->setKpireportData(null);
        } elseif (Mage::registry('current_kpireport')) {
            $formValues = array_merge($formValues, Mage::registry('current_kpireport')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
