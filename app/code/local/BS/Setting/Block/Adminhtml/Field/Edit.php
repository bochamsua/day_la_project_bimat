<?php
/**
 * BS_Setting extension
 * 
 * @category       BS
 * @package        BS_Setting
 * @copyright      Copyright (c) 2017
 */
/**
 * Field Dependance admin edit form
 *
 * @category    BS
 * @package     BS_Setting
 * @author Bui Phong
 */
class BS_Setting_Block_Adminhtml_Field_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_setting';
        $this->_controller = 'adminhtml_field';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_setting')->__('Save & Continue'),
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
                    'label'   => Mage::helper('bs_setting')->__('Close'),
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
                 if(typeof field_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:field_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:field_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof field_tabsJsTabs !== 'undefined'){
                        field_tabsJsTabs.setSkipDisplayFirstTab();
                        field_tabsJsTabs.showTabContent(obj);
                     }else {
                        field_info_tabsJsTabs.setSkipDisplayFirstTab();
                        field_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("system/field/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("system/field/delete");

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
        if (Mage::registry('current_field') && Mage::registry('current_field')->getId()) {
            return Mage::helper('bs_setting')->__(
                "Edit Field Dependance '%s'",
                $this->escapeHtml(Mage::registry('current_field')->getName())
            );
        } else {
            return Mage::helper('bs_setting')->__('Add Field Dependance');
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
