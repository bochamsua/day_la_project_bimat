<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tool Supplier admin edit form
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Block_Adminhtml_Tosup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_tosup';
        $this->_controller = 'adminhtml_tosup';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_tosup')->__('Save & Continue'),
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
                    'label'   => Mage::helper('bs_tosup')->__('Close'),
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
            }

            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }

            var templateSyntax = /(^|.|\\r|\\n)({{(\w+)}})/;

            function saveAndContinueEdit(urlTemplate) {
                 var template = new Template(urlTemplate, templateSyntax);
                 if(typeof tosup_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:tosup_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:tosup_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof tosup_tabsJsTabs !== 'undefined'){
                        tosup_tabsJsTabs.setSkipDisplayFirstTab();
                        tosup_tabsJsTabs.showTabContent(obj);
                     }else {
                        tosup_info_tabsJsTabs.setSkipDisplayFirstTab();
                        tosup_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_data/tosup/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_data/tosup/delete");

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
        if (Mage::registry('current_tosup') && Mage::registry('current_tosup')->getId()) {
            return Mage::helper('bs_tosup')->__(
                "Edit Tool Supplier '%s'",
                $this->escapeHtml(Mage::registry('current_tosup')->getTosupNo())
            );
        } else {
            return Mage::helper('bs_tosup')->__('Add Tool Supplier');
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
