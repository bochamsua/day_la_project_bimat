<?php
/**
 * BS_Qr extension
 * 
 * @category       BS
 * @package        BS_Qr
 * @copyright      Copyright (c) 2016
 */
/**
 * QR admin edit form
 *
 * @category    BS
 * @package     BS_Qr
 * @author Bui Phong
 */
class BS_Qr_Block_Adminhtml_Qr_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_qr';
        $this->_controller = 'adminhtml_qr';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_qr')->__('Save & Continue'),
                'onclick' => 'saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
                'class'   => 'save',
            ),
            -100
        ); */

        $this->_updateButton('save','onclick','saveOnly()');
        $this->_updateButton('delete','onclick','deleteOnly()');
	    $this->_removeButton('reset');

        $add = '';
        $popup = $this->getRequest()->getParam('popup');
        if($popup){
            $add = 'popup/1/';
            $this->_removeButton('saveandcontinue');
            $this->_removeButton('back');
            $this->_addButton(
                'closewindow',
                [
                    'label'   => Mage::helper('bs_qr')->__('Close'),
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
                 if(typeof qr_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:qr_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:qr_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof qr_tabsJsTabs !== 'undefined'){
                        qr_tabsJsTabs.setSkipDisplayFirstTab();
                        qr_tabsJsTabs.showTabContent(obj);
                     }else {
                        qr_info_tabsJsTabs.setSkipDisplayFirstTab();
                        qr_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_work/qr/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_work/qr/delete");

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
        if (Mage::registry('current_qr') && Mage::registry('current_qr')->getId()) {

	        $curQr = Mage::registry('current_qr');
	        $closeDate = $curQr->getCloseDate();
	        $closeDate = Mage::getModel('core/date')->date('d/m/Y', $closeDate);

	        $closeText = '';
	        if($curQr->getQrStatus() == 3){//closed
		        $closeText = ' ('.$closeDate.')';
	        }

	        return Mage::helper('bs_qr')->__(
		        "Edit QR '%s' - <span style='color: red;'>%s</span>  %s",
		        $this->escapeHtml($curQr->getRefNo()), Mage::getSingleton('bs_qr/qr_attribute_source_qrstatus')->getOptionText($curQr->getQrStatus()), $closeText
	        );

        } else {
            return Mage::helper('bs_qr')->__('Add QR');
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
