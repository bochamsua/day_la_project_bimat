<?php
/**
 * BS_Drr extension
 * 
 * @category       BS
 * @package        BS_Drr
 * @copyright      Copyright (c) 2016
 */
/**
 * Drr admin edit form
 *
 * @category    BS
 * @package     BS_Drr
 * @author Bui Phong
 */
class BS_Drr_Block_Adminhtml_Drr_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_drr';
        $this->_controller = 'adminhtml_drr';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_drr')->__('Save & Continue'),
                'onclick' => 'saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
                'class'   => 'save',
            ),
            -100
        ); */

	    $this->_removeButton('reset');

        $this->_updateButton('save','onclick','saveOnly()');
        $this->_updateButton('delete','onclick','deleteOnly()');


        $currentObj = Mage::registry('current_drr');
        $misc = $this->helper('bs_misc');

	    if($currentObj->getId()){

		    $this->_addButton(
			    'close',
			    array(
				    'label'   => Mage::helper('bs_drr')->__('Close'),
				    'onclick'   => "closeDrr()",
				    'class'   => 'save closes',
			    )
		    );

		    if($currentObj->getDrrStatus() == 1){//drr is closed, remove close button
			    $this->_removeButton('close');
			    $this->_removeButton('delete');
			    $this->_removeButton('save');
		    }
	    }




        $add = '';
        $popup = $this->getRequest()->getParam('popup');
        if($popup){
            $add = 'popup/1/';
            $this->_removeButton('saveandcontinue');
            $this->_removeButton('back');
            $this->_addButton(
                'closewindow',
                array(
                    'label'   => Mage::helper('bs_drr')->__('Close'),
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

            function closeDrr() {
                $('drr_remark').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/close/1');
            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof drr_tabsJsTabs !== 'undefined'){
                        drr_tabsJsTabs.setSkipDisplayFirstTab();
                        drr_tabsJsTabs.showTabContent(obj);
                     }else {
                        drr_info_tabsJsTabs.setSkipDisplayFirstTab();
                        drr_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_work/drr/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_work/drr/delete");

        if(!$isAllowedEdit){
            $this->_removeButton('save');
            $this->_removeButton('saveandcontinue');
        }
        if(!$isAllowedDelete){
            $this->_removeButton('delete');
        }

	    if($currentObj->getInsId() && !$misc->isOwner($currentObj)){
		    if(!$misc->isManager($currentObj) || ($misc->isManager($currentObj) && !in_array($currentObj->getDrrStatus(), [1]))){
			    $this->_removeButton('save');
			    $this->_removeButton('saveandcontinue');
			    $this->_removeButton('delete');
			    $this->_removeButton('reset');
		    }

	    }

	    //Make sure that admin can do anything
	    if($misc->isAdmin($currentObj) || $misc->isSuperAdmin()){//1 is super admin
		    //first we remove all buttons
		    $this->_removeButton('save');
		    $this->_removeButton('saveandcontinue');
		    $this->_removeButton('delete');
		    $this->_removeButton('reset');

		    $this->_addButton(
			    'save1',
			    array(
				    'label'   => Mage::helper('bs_drr')->__('Save'),
				    'onclick'   => "saveAndContinueEdit()",
				    'class'   => 'save',
			    )
		    );
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
        if (Mage::registry('current_drr') && Mage::registry('current_drr')->getId()) {

	        $curDrr = Mage::registry('current_drr');

	        return Mage::helper('bs_ir')->__(
		        "Edit Drr '%s' - <span style='color: red;'>%s</span>",
		        $this->escapeHtml($curDrr->getRefNo()), Mage::getSingleton('bs_drr/drr_attribute_source_drrstatus')->getOptionText($curDrr->getDrrStatus())
	        );


        } else {
            return Mage::helper('bs_drr')->__('Add Drr');
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
