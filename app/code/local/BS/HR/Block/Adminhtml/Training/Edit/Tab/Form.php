<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Training edit form tab
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Training_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Training_Edit_Tab_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $form->setHtmlIdPrefix('training_');
        $form->setFieldNameSuffix('training');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'training_form',
            ['legend' => Mage::helper('bs_hr')->__('Training')]
        );

        $fieldset->addField(
            'training_desc',
            'text',
            [
                'label' => Mage::helper('bs_hr')->__('Description'),
                'name'  => 'training_desc',

            ]
        );

        $currentTraining = Mage::registry('current_training');
        $inspectorId = null;
        if($this->getRequest()->getParam('inspector_id')){
            $inspectorId = $this->getRequest()->getParam('inspector_id');
        }elseif ($currentTraining){
            $inspectorId = $currentTraining->getInsId();
        }

        $values = Mage::getResourceModel('bs_hr/inspector_collection');
        if($inspectorId){
            $values->addFieldToFilter('entity_id', $inspectorId);
        }
        $values = $values->toOptionArray();

        $fieldset->addField(
            'ins_id',
            'select',
            [
                'label'     => Mage::helper('bs_hr')->__('Inspector'),
                'name'      => 'ins_id',
                'required'  => false,
                'values'    => $values,
                //'after_element_html' => $html
            ]
        );

        $fieldset->addField(
            'type_training',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Completed Type training course for at least 2 months?'),
                'name'  => 'type_training',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );

        $fieldset->addField(
            'line_six',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Line maintenance experience for at least 6 months? '),
                'name'  => 'line_six',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );

        $fieldset->addField(
            'base_six',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Base maintenance experience for at least 6 months '),
                'name'  => 'base_six',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );

        $fieldset->addField(
            'crs_a',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Holding CRS A certificate for at least 14 months?'),
                'name'  => 'crs_a',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );

        $fieldset->addField(
            'line_twelve',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Line maintenance experience for at least 12 months?'),
                'name'  => 'line_twelve',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );

        $fieldset->addField(
            'base_twelve',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Base maintenance experience for at least 12 months?'),
                'name'  => 'base_twelve',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );

        $fieldset->addField(
            'crs_b',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Hoding CRS B certificate for at least 38 months?'),
                'name'  => 'crs_b',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );

        $fieldset->addField(
            'line_twentyfour',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Line maintenance experience for at least 24 months?'),
                'name'  => 'line_twentyfour',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );

        $fieldset->addField(
            'base_twentyfour',
            'select',
            [
                'label' => Mage::helper('bs_hr')->__('Base maintenance experience for at least 24 months?'),
                'name'  => 'base_twentyfour',

            'values'=> [
                [
                    'value' => 1,
                    'label' => Mage::helper('bs_hr')->__('Yes'),
                ],
                [
                    'value' => 0,
                    'label' => Mage::helper('bs_hr')->__('No'),
                ],
            ],
            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('bs_hr')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('bs_hr')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('bs_hr')->__('Disabled'),
                    ),
                ),
            )
        );*/
        $formValues = Mage::registry('current_training')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = [];
        }
        if (Mage::getSingleton('adminhtml/session')->getTrainingData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getTrainingData());
            Mage::getSingleton('adminhtml/session')->setTrainingData(null);
        } elseif (Mage::registry('current_training')) {
            $formValues = array_merge($formValues, Mage::registry('current_training')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
