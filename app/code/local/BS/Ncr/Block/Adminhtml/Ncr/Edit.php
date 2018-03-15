<?php
/**
 * BS_Ncr extension
 * 
 * @category       BS
 * @package        BS_Ncr
 * @copyright      Copyright (c) 2016
 */
/**
 * Ncr admin edit form
 *
 * @category    BS
 * @package     BS_Ncr
 * @author Bui Phong
 */
class BS_Ncr_Block_Adminhtml_Ncr_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_ncr';
        $this->_controller = 'adminhtml_ncr';


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
                array(
                    'label'   => Mage::helper('bs_ncr')->__('Close'),
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
                
                editForm.submit($('edit_form').action+'back/edit/'+'".$add."');
                $$(\"button.save\").each(function(v) {v.disabled = true;});
            }
            
            function submitNcr() {
                editForm.submit($('edit_form').action+'back/edit/submitted/1');
            }
            
            function acceptNcr() {
                editForm.submit($('edit_form').action+'back/edit/accept/1');
            }
            
            function closeNcr() {
                $('ncr_remark').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/close/1');
            }
            
            function rejectNcr() {
                $('ncr_reject_reason').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/reject/1');
            }

            




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof ncr_tabsJsTabs !== 'undefined'){
                        ncr_tabsJsTabs.setSkipDisplayFirstTab();
                        ncr_tabsJsTabs.showTabContent(obj);
                     }else {
                        ncr_info_tabsJsTabs.setSkipDisplayFirstTab();
                        ncr_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_work/ncr/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_work/ncr/delete");

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
        if (Mage::registry('current_ncr') && Mage::registry('current_ncr')->getId()) {

        	$curNcr = Mage::registry('current_ncr');
        	$closeDate = $curNcr->getCloseDate();
        	$closeDate = Mage::getModel('core/date')->date('d/m/Y', $closeDate);

        	$closeText = '';
        	if($curNcr->getNcrStatus() == 3){//closed
		        $closeText = ' ('.$closeDate.')';
	        }

            return Mage::helper('bs_ncr')->__(
                "Edit Ncr '%s' - <span style='color: red;'>%s</span>  %s",
                $this->escapeHtml($curNcr->getRefNo()), Mage::getSingleton('bs_ncr/ncr_attribute_source_ncrstatus')->getOptionText($curNcr->getNcrStatus()), $closeText
            );
        } else {
            return Mage::helper('bs_ncr')->__('Add NCR');
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
