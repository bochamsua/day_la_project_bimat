<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * HIRA admin edit form
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Block_Adminhtml_Hira_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_hira';
        $this->_controller = 'adminhtml_hira';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_hira')->__('Save & Continue'),
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
                    'label'   => Mage::helper('bs_hira')->__('Close'),
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
            }

            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }

            var templateSyntax = /(^|.|\\r|\\n)({{(\w+)}})/;

            function saveAndContinueEdit(urlTemplate) {
                 var template = new Template(urlTemplate, templateSyntax);
                 if(typeof hira_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:hira_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:hira_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof hira_tabsJsTabs !== 'undefined'){
                        hira_tabsJsTabs.setSkipDisplayFirstTab();
                        hira_tabsJsTabs.showTabContent(obj);
                     }else {
                        hira_info_tabsJsTabs.setSkipDisplayFirstTab();
                        hira_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_work/hira/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_work/hira/delete");

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
        if (Mage::registry('current_hira') && Mage::registry('current_hira')->getId()) {
            return Mage::helper('bs_hira')->__(
                "Edit HIRA '%s'",
                $this->escapeHtml(Mage::registry('current_hira')->getRefNo())
            );
        } else {
            return Mage::helper('bs_hira')->__('Add HIRA');
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
