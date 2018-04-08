<?php
/**
 * BS_Signoff extension
 * 
 * @category       BS
 * @package        BS_Signoff
 * @copyright      Copyright (c) 2016
 */
/**
 * AC Sign-off edit form
 *
 * @category    BS
 * @package     BS_Signoff
 * @author Bui Phong
 */
class BS_Signoff_Block_Adminhtml_Signoff_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     *
     * @access protected
     * @return BS_Signoff_Block_Adminhtml_Signoff_Edit_Form
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
