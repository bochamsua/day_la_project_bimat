<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other Work edit form tab
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
class BS_Other_Block_Adminhtml_Other_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Other_Block_Adminhtml_Other_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('other_');
        $form->setFieldNameSuffix('other');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'other_form',
            array('legend' => Mage::helper('bs_other')->__('Other Work'))
        );

        /*$fieldset->addField(
            'ref_no',
            'text',
            array(
                'label' => Mage::helper('bs_other')->__('Reference No'),
                'name'  => 'ref_no',

           )
        );*/

	    $tasks = Mage::getResourceModel('bs_misc/task_collection');
	    $tasks->addFieldToFilter('taskgroup_id', array(
		    'in' => array(4,5,10)
	    ));
	    $tasks = $tasks->toOptionArray();


	    $fieldset->addField(
		    'task_id',
		    'select',
		    array(
			    'label' => Mage::helper('bs_other')->__('Survey Code'),
			    'name'  => 'task_id',
			    'values'=> $tasks,
		    )
	    );

        $fieldset->addField(
            'report_date',
            'date',
            array(
                'label' => Mage::helper('bs_other')->__('Date of Repot'),
                'name'  => 'report_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
           )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_other')->__('Description'),
                'name'  => 'description',
                'config' => $wysiwygConfig,

           )
        );

	    $customers = Mage::getResourceModel('bs_acreg/customer_collection');
	    $customers = $customers->toOptionArray();
		array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
	    array_unshift($customers, array('value' => 0, 'label' => 'N/A'));
	    $fieldset->addField(
		    'customer',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_ncr')->__('Customer'),
			    'name'      => 'customer',
			    'required'  => false,
			    'values'    => $customers,
		    )
	    );

	    $acTypes = Mage::getResourceModel('bs_misc/aircraft_collection');
	    $acTypes = $acTypes->toOptionArray();
	    array_unshift($acTypes, array('value' => 0, 'label' => 'N/A'));
	    $fieldset->addField(
		    'ac_type',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_ncr')->__('A/C Type'),
			    'name'      => 'ac_type',
			    'required'  => false,
			    'values'    => $acTypes,
		    )
	    );

	    $acRegs = Mage::getResourceModel('bs_acreg/acreg_collection');
        $acRegs->setOrder('reg', 'ASC');
	    $acRegs = $acRegs->toOptionArray();
	    array_unshift($acRegs, array('value' => 0, 'label' => 'N/A'));
	    $fieldset->addField(
		    'ac_reg',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_ncr')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
		    )
	    );

	    $locs = Mage::getResourceModel('bs_misc/location_collection');
	    $locs = $locs->toOptionArray();
		array_unshift($locs, ['value' => 0, 'label' => 'N/A']);
	    array_unshift($locs, array('value' => 0, 'label' => 'N/A'));
	    $fieldset->addField(
		    'loc_id',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_misc')->__('Location'),
			    'name'      => 'loc_id',
			    'required'  => false,
			    'values'    => $locs,
		    )
	    );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_other')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_other')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_other')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_other')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getOtherData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getOtherData());
            Mage::getSingleton('adminhtml/session')->setOtherData(null);
        } elseif (Mage::registry('current_other')) {
            $formValues = array_merge($formValues, Mage::registry('current_other')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
