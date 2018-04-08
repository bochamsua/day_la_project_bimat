<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature admin edit form
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Block_Adminhtml_Signature_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'bs_signature';
        $this->_controller = 'adminhtml_signature';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_signature')->__('Save & Continue'),
                'onclick' => 'saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
                'class'   => 'save',
            ),
            -100
        ); */

        $this->_updateButton('save','onclick','saveOnly()');
        $this->_updateButton('delete','onclick','deleteOnly()');
        $add = '';
        $popup = $this->getRequest()->getParam('popup');
        if($popup){
            $add = 'popup/1/';
            $this->_removeButton('saveandcontinue');
            $this->_removeButton('back');
            $this->_addButton(
                'closewindow',
                [
                    'label'   => Mage::helper('bs_signature')->__('Close'),
                    'onclick' => 'window.close()',
                    'class'   => 'back',
                ],
                -1
            );
        }
        $this->_formScripts[] = "

            function deleteOnly() {
                deleteConfirm('". Mage::helper('adminhtml')->__('Are you sure you want to do this?')."','".$this->getUrl('*/*/delete', [$this->_objectId => $this->getRequest()->getParam($this->_objectId), 'popup'=>1]) . "');
            }
            function saveOnly() {
                editForm.submit($('edit_form').action+'".$add."');
                $$(\"button.save\").each(function(v) {v.disabled = true;});
            }

            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
                $$(\"button.save\").each(function(v) {v.disabled = true;});
            }

            var templateSyntax = /(^|.|\\r|\\n)({{(\w+)}})/;

            function saveAndContinueEdit(urlTemplate) {
                 var template = new Template(urlTemplate, templateSyntax);
                 if(typeof signature_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:signature_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:signature_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof signature_tabsJsTabs !== 'undefined'){
                        signature_tabsJsTabs.setSkipDisplayFirstTab();
                        signature_tabsJsTabs.showTabContent(obj);
                     }else {
                        signature_info_tabsJsTabs.setSkipDisplayFirstTab();
                        signature_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_misc/signature/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_misc/signature/delete");

        if(!$isAllowedEdit){
            $this->_removeButton('save');
            $this->_removeButton('saveandcontinue');
        }
        if(!$isAllowedDelete){
            $this->_removeButton('delete');
        }
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Bui Phong
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_signature') && Mage::registry('current_signature')->getId()) {
            return Mage::helper('bs_signature')->__(
                "Edit Signature '%s'",
                $this->escapeHtml(Mage::registry('current_signature')->getName())
            );
        } else {
            return Mage::helper('bs_signature')->__('Add Signature');
        }
    }
    public function getSaveAndContinueUrl()
        {
            return $this->getUrl('*/*/save', [
                '_current'   => true,
                'back'       => 'edit',
                'tab'        => '{{tab_id}}',
                'active_tab' => null
            ]);
        }
    public function getSelectedTabId()
        {
            return addslashes(htmlspecialchars($this->getRequest()->getParam('tab')));
        }
}
