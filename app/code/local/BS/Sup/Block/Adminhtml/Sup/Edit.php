<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Supplier admin edit form
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Block_Adminhtml_Sup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_sup';
        $this->_controller = 'adminhtml_sup';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_sup')->__('Save & Continue'),
                'onclick' => 'saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
                'class'   => 'save',
            ),
            -100
        ); */

        $this->_updateButton('save','onclick','saveOnly()');
        $this->_updateButton('delete','onclick','deleteOnly()');


        if (Mage::registry('current_sup') && Mage::registry('current_sup')->getId()) {
            $this->_addButton(
                '2005',
                [
                    'label'   => Mage::helper('bs_qn')->__('2005'),
                    'onclick'   => "setLocation('{$this->getUrl('*/*/generateFive', ['_current'=>true])}')",
                    'class'   => 'reset',
                ]
            );

            $this->_addButton(
                '2007',
                [
                    'label'   => Mage::helper('bs_qn')->__('2007'),
                    'onclick'   => "setLocation('{$this->getUrl('*/*/generateSeven', ['_current'=>true])}')",
                    'class'   => 'reset',
                ]
            );
        }
        $add = '';
        $popup = $this->getRequest()->getParam('popup');
        if($popup){
            $add = 'popup/1/';
            $this->_removeButton('saveandcontinue');
            $this->_removeButton('back');
            $this->_addButton(
                'closewindow',
                [
                    'label'   => Mage::helper('bs_sup')->__('Close'),
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
                 if(typeof sup_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:sup_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:sup_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof sup_tabsJsTabs !== 'undefined'){
                        sup_tabsJsTabs.setSkipDisplayFirstTab();
                        sup_tabsJsTabs.showTabContent(obj);
                     }else {
                        sup_info_tabsJsTabs.setSkipDisplayFirstTab();
                        sup_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_data/sup/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_data/sup/delete");

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
        if (Mage::registry('current_sup') && Mage::registry('current_sup')->getId()) {
            return Mage::helper('bs_sup')->__(
                "Edit Supplier '%s'",
                $this->escapeHtml(Mage::registry('current_sup')->getSupCode())
            );
        } else {
            return Mage::helper('bs_sup')->__('Add Supplier');
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
