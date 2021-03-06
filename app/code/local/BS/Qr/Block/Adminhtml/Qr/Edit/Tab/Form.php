<?php
/**
 * BS_Qr extension
 * 
 * @category       BS
 * @package        BS_Qr
 * @copyright      Copyright (c) 2016
 */
/**
 * QR edit form tab
 *
 * @category    BS
 * @package     BS_Qr
 * @author Bui Phong
 */
class BS_Qr_Block_Adminhtml_Qr_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_Qr_Block_Adminhtml_Qr_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('qr_');
        $form->setFieldNameSuffix('qr');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'qr_form',
            ['legend' => Mage::helper('bs_qr')->__('QR')]
        );

        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('bs_qr/adminhtml_qr_helper_file')
        );

        $refId = $this->getRequest()->getParam('ref_id');
        $taskId = $this->getRequest()->getParam('task_id');
        $refType = $this->getRequest()->getParam('ref_type');

        $new = true;

        $currentObj = Mage::registry('current_qr');
        if($currentObj && $currentObj->getId()){
            $new = false;
            //$taskGroupId = $currentObj->getTaskgroupId();
            $refId = $currentObj->getRefId();
            $refType = $currentObj->getRefType();
            $taskId = $currentObj->getTaskId();
        }


        $disable = false;
        $misc = $this->helper('bs_misc');

        if($misc->isManager($currentObj) && $currentObj->getId()){
            $disable = true;
        }

        $fieldset->addField(
            'ref_id',
            'hidden',
            [
                'label' => Mage::helper('bs_qn')->__('ref_id'),
                'name'  => 'ref_id',


            ]
        );

        $fieldset->addField(
            'ref_type',
            'hidden',
            [
                'label' => Mage::helper('bs_qn')->__('ref_type'),
                'name'  => 'ref_type',


            ]
        );

        if($taskId){
            $tasks = Mage::getResourceModel('bs_misc/task_collection');
            $tasks->addFieldToFilter('entity_id', $taskId);
            $tasks = $tasks->toOptionArray();
            $fieldset->addField(
                'task_id',
                'select',
                [
                    'label' => Mage::helper('bs_qn')->__('Survey Code'),
                    'name'  => 'task_id',
                    'values'=> $tasks,
                    'disabled'  => $disable
                ]
            );

            /*$subtasks = Mage::getResourceModel('bs_misc/subtask_collection');
            $subtasks->addFieldToFilter('task_id', $taskId);
            $subtasks = $subtasks->toOptionArray();
            array_unshift($subtasks, array('value'=>'0', 'label'=>'N/A'));

            $fieldset->addField(
                'subtask_id',
                'select',
                array(
                    'label' => Mage::helper('bs_qn')->__('Source'),
                    'name'  => 'subtask_id',
                    'values'=> $subtasks,
                    'disabled'  => $disable
                )
            );*/
        }else {
            $label = 'Other';
            if($refType){
                $label = ucfirst($refType);
            }
            $fieldset->addField(
                'task_id',
                'select',
                [
                    'label' => Mage::helper('bs_qn')->__('Source'),
                    'name'  => 'task_id',
                    'values'=> [['value'=>'0', 'label'=>$label]],
                    'disabled'  => $disable
                ]
            );

            $fieldset->addField(
                'source_other',
                'text',
                [
                    'label' => Mage::helper('bs_qr')->__('Source Other'),
                    'name'  => 'source_other',
                    'disabled'  => $disable
                ]
            );
        }

        /*$subtasks = Mage::getResourceModel('bs_misc/subtask_collection');
        if($taskId){
            $subtasks->addFieldToFilter('task_id', $taskId);
        }
        $subtasks = $subtasks->toOptionArray();
        array_unshift($subtasks, array('value'=>'0', 'label'=>'N/A'));
        $fieldset->addField(
            'subtask_id',
            'select',
            array(
                'label' => Mage::helper('bs_qr')->__('Sub-Task'),
                'name'  => 'subtask_id',
                'values'=> $subtasks,
                'disabled'  => $disable
            )
        );*/

	    /*$fieldset->addField(
		    'report_date',
		    'date',
		    [
			    'label' => Mage::helper('bs_qr')->__('Report Date'),
			    'name'  => 'report_date',

			    'image' => $this->getSkinUrl('images/grid-cal.gif'),
			    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
			    'disabled'  => $disable
            ]
	    );*/

	    $fieldset->addField(
		    'due_date',
		    'date',
		    [
			    'label' => Mage::helper('bs_qr')->__('Due Date'),
			    'name'  => 'due_date',

			    'image' => $this->getSkinUrl('images/grid-cal.gif'),
			    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
			    'disabled'  => $disable
            ]
	    );

        $fieldset->addField(
            'qr_source',
            'file',
            [
                'label' => Mage::helper('bs_qr')->__('Source'),
                'name'  => 'qr_source',
                'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),
                'disabled'  => $disable

            ]
        );

	    $depts = Mage::getResourceModel('bs_misc/department_collection');
	    $depts = $depts->toOptionArray();
	    $fieldset->addField(
		    'dept_id',
		    'select',
		    [
			    'label'     => Mage::helper('bs_ncr')->__('Sent To'),
			    'name'      => 'dept_id',
			    'required'  => false,
			    'values'    => $depts,
            ]
	    );


	    $fieldset->addField(
		    'dept_id_cc',
		    'select',
		    [
			    'label'     => Mage::helper('bs_ncr')->__('CC'),
			    'name'      => 'dept_id_cc',
			    'required'  => false,
			    'values'    => $depts,
            ]
	    );

	    $fieldset->addField(
		    'subject',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_qr')->__('Subject'),
			    'name'  => 'subject',
			    'disabled'  => $disable,
			    'config' => $wysiwygConfig,
            ]
	    );

	    $fieldset->addField(
		    'content',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_qr')->__('Content'),
			    'name'  => 'content',
			    'disabled'  => $disable,
			    'config' => $wysiwygConfig,
            ]
	    );

	    $fieldset->addField(
		    'remark_text',
		    'textarea',
		    [
			    'label' => Mage::helper('bs_qr')->__('Remark'),
			    'name'  => 'remark_text',
			    'disabled'  => $disable,
			    'config' => $wysiwygConfig,
            ]
	    );


	    if($misc->isAdmin($currentObj)){
		    $fieldset->addField(
			    'qr_status',
			    'select',
			    [
				    'label' => Mage::helper('bs_qr')->__('Status'),
				    'name'  => 'qr_status',

				    'values'=> Mage::getModel('bs_qr/qr_attribute_source_qrstatus')->getAllOptions(false),
                ]
		    );

		    $fieldset->addField(
			    'close_date',
			    'date',
			    array(
				    'label' => Mage::helper('bs_qr')->__('Close Date'),
				    'name'  => 'close_date',
				    'readonly'  => true,
				    'image' => $this->getSkinUrl('images/grid-cal.gif'),
				    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),

			    )
		    );
	    }

	    if($currentObj->getQrStatus() > 1){// && $currentObj->getAccept() == 1
		    $disableProof = false;
		    if($currentObj->getQrStatus() == 3 && !$misc->isAdmin($currentObj)){//closed, disable but still allow admin edit
			    $disableProof = true;
		    }
		    $fieldset->addField(
			    'remark',
			    'file',
			    [
				    'label' => Mage::helper('adminhtml')->__('Proof of Close'),
				    'name'  => 'remark',
                    'note'  => Mage::helper('bs_misc')->__('Maximum file size allowed is 10MB'),
				    'disabled'  => $disableProof

                ]
		    );

            $fieldset->addField(
                'close_date',
                'date',
                [
                    'label' => Mage::helper('bs_qr')->__('Close Date'),
                    'name'  => 'close_date',

                    'image' => $this->getSkinUrl('images/grid-cal.gif'),
                    'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                ]
            );

	    }



        /*$fieldset->addField(
            'is_coa',
            'select',
            array(
                'label'  => Mage::helper('bs_coa')->__('Issue Corrective Action?'),
                'name'   => 'is_coa',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_coa')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_coa')->__('No'),
                    ),
                ),
            )
        );*/



	    /*$customers = Mage::getResourceModel('bs_acreg/customer_collection');
	    $customers = $customers->toOptionArray();
		array_unshift($customers, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'customer',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_qr')->__('Customer'),
			    'name'      => 'customer',
			    'required'  => false,
			    'values'    => $customers,
		    )
	    );

	    $acTypes = Mage::getResourceModel('bs_misc/aircraft_collection');
	    $acTypes = $acTypes->toOptionArray();
		array_unshift($acTypes, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'ac_type',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_qr')->__('A/C Type'),
			    'name'      => 'ac_type',
			    'required'  => false,
			    'values'    => $acTypes,
		    )
	    );

	    $acRegs = Mage::getResourceModel('bs_acreg/acreg_collection');
	    $acRegs = $acRegs->toOptionArray();
		array_unshift($acRegs, ['value' => 0, 'label' => 'N/A']);
	    $fieldset->addField(
		    'ac_reg',
		    'select',
		    array(
			    'label'     => Mage::helper('bs_qr')->__('A/C Reg'),
			    'name'      => 'ac_reg',
			    'required'  => false,
			    'values'    => $acRegs,
		    )
	    );

        $fieldset->addField(
            'qr_type',
            'select',
            array(
                'label' => Mage::helper('bs_qr')->__('Type'),
                'name'  => 'qr_type',

            'values'=> Mage::getModel('bs_qr/qr_attribute_source_qrtype')->getAllOptions(true),
                'disabled'  => $disable
           )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('bs_qr')->__('Description'),
                'name'  => 'description',
                'disabled'  => $disable
           )
        );

        $fieldset->addField(
            'due_date',
            'date',
            array(
                'label' => Mage::helper('bs_qr')->__('Due Date'),
                'name'  => 'due_date',

            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format'  => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'disabled'  => $disable
           )
        );




        $fieldset->addField(
            'remark',
            'file',
            array(
                'label' => Mage::helper('bs_qr')->__('Remark'),
                'name'  => 'remark',

           )
        );
*/


        $bypass = Mage::getSingleton('admin/session')->isAllowed("bs_work/qr/accept");
        if($misc->canAcceptReject($currentObj, null, [], $bypass)){//manager

            $fieldset->addField(
                'reject_reason',
                'text',
                [
                    'label' => Mage::helper('bs_qr')->__('Reject Reason'),
                    'name'  => 'reject_reason',

                ]
            );
        }



        $fieldset->addField(
            'self_remark',
            'textarea',
            [
                'label' => Mage::helper('bs_qr')->__('Note'),
                'name'  => 'self_remark'

            ]
        );



        $formValues = Mage::registry('current_qr')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getQrData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getQrData());
            Mage::getSingleton('adminhtml/session')->setQrData(null);
        } elseif (Mage::registry('current_qr')) {
            $formValues = array_merge($formValues, Mage::registry('current_qr')->getData());
        }

        $formValues = array_merge($formValues, [
            'ref_id'    => $refId,
            'ref_type'  => $refType

        ]);

        $form->setValues($formValues);

        return parent::_prepareForm();
    }
}
