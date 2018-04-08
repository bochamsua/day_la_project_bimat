<?php
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * QN edit form
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Block_Adminhtml_Qn_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     *
     * @access protected
     * @return BS_Qn_Block_Adminhtml_Qn_Edit_Form
     * @author Bui Phong
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            [
                'id'         => 'edit_form',
                'action'     => $this->getUrl(
                    '*/*/save',
                    [
                        'id' => $this->getRequest()->getParam('id')
                    ]
                ),
                'method'     => 'post',
                'enctype'    => 'multipart/form-data'
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
