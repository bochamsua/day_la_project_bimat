<?php
/**
 * BS_KPIReport extension
 * 
 * @category       BS
 * @package        BS_KPIReport
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Report admin edit form
 *
 * @category    BS
 * @package     BS_KPIReport
 * @author Bui Phong
 */
class BS_KPIReport_Block_Adminhtml_Kpireport_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_kpireport';
        $this->_controller = 'adminhtml_kpireport';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_kpireport')->__('Save & Continue'),
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
                    'label'   => Mage::helper('bs_kpireport')->__('Close'),
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
                 if(typeof kpireport_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:kpireport_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:kpireport_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof kpireport_tabsJsTabs !== 'undefined'){
                        kpireport_tabsJsTabs.setSkipDisplayFirstTab();
                        kpireport_tabsJsTabs.showTabContent(obj);
                     }else {
                        kpireport_info_tabsJsTabs.setSkipDisplayFirstTab();
                        kpireport_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_report/kpireport/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_report/kpireport/delete");

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
        if (Mage::registry('current_kpireport') && Mage::registry('current_kpireport')->getId()) {
            return Mage::helper('bs_kpireport')->__(
                "Edit KPI Report '%s'",
                $this->escapeHtml(Mage::getModel('bs_misc/department')->load(Mage::registry('current_kpireport')->getDeptId())->getDeptName())
            );
        } else {
            return Mage::helper('bs_kpireport')->__('Add KPI Report');
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
