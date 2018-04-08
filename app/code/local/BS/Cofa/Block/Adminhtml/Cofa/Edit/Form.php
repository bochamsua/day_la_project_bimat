<?php
/**
 * BS_Cofa extension
 * 
 * @category       BS
 * @package        BS_Cofa
 * @copyright      Copyright (c) 2017
 */
/**
 * CoA Data edit form
 *
 * @category    BS
 * @package     BS_Cofa
 * @author Bui Phong
 */
class BS_Cofa_Block_Adminhtml_Cofa_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form
     *
     * @access protected
     * @return BS_Cofa_Block_Adminhtml_Cofa_Edit_Form
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
