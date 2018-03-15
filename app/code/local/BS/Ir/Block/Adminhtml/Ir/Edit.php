<?php
/**
 * BS_Ir extension
 * 
 * @category       BS
 * @package        BS_Ir
 * @copyright      Copyright (c) 2016
 */
/**
 * Ir admin edit form
 *
 * @category    BS
 * @package     BS_Ir
 * @author Bui Phong
 */
class BS_Ir_Block_Adminhtml_Ir_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_ir';
        $this->_controller = 'adminhtml_ir';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_ir')->__('Save & Continue'),
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
                array(
                    'label'   => Mage::helper('bs_ir')->__('Close'),
                    'onclick' => 'window.close()',
                    'class'   => 'back',
                ),
                -1
            );
        }
        $this->_formScripts[] = "

            function deleteOnly() {
                deleteConfirm('". Mage::helper('adminhtml')->__('Are you sure you want to do this?')."','".$this->getUrl('*/*/delete', array($this->_objectId => $this->getRequest()->getParam($this->_objectId), 'popup'=>1)) . "');
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
                 if(typeof ir_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:ir_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:ir_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }
            
            function submitIr() {
                editForm.submit($('edit_form').action+'back/edit/submitted/1');
            }
            
            function acceptIr() {
                editForm.submit($('edit_form').action+'back/edit/accept/1');
            }
            function rejectIr() {
                $('ir_reject_reason').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/reject/1');
            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof ir_tabsJsTabs !== 'undefined'){
                        ir_tabsJsTabs.setSkipDisplayFirstTab();
                        ir_tabsJsTabs.showTabContent(obj);
                     }else {
                        ir_info_tabsJsTabs.setSkipDisplayFirstTab();
                        ir_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_work/ir/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_work/ir/delete");

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
        if (Mage::registry('current_ir') && Mage::registry('current_ir')->getId()) {

	        $curIr = Mage::registry('current_ir');

	        return Mage::helper('bs_ir')->__(
		        "Edit Ir '%s' - <span style='color: red;'>%s</span>",
		        $this->escapeHtml($curIr->getRefNo()), Mage::getSingleton('bs_ir/ir_attribute_source_irstatus')->getOptionText($curIr->getIrStatus())
	        );


        } else {
            return Mage::helper('bs_ir')->__('Add Ir');
        }
    }
    public function getSaveAndContinueUrl()
        {
            return $this->getUrl('*/*/save', array(
                '_current'   => true,
                'back'       => 'edit',
                'tab'        => '{{tab_id}}',
                'active_tab' => null
            ));
        }
    public function getSelectedTabId()
        {
            return addslashes(htmlspecialchars($this->getRequest()->getParam('tab')));
        }
}
