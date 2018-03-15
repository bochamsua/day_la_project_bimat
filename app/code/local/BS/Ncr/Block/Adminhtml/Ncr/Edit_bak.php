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

        $currentObj = Mage::registry('current_ncr');

        $misc = $this->helper('bs_misc');

	    if($currentObj->getId()){
		    $this->_addButton(
			    '2029',
			    array(
				    'label'   => Mage::helper('bs_ncr')->__('Print'),
				    'onclick'   => "setLocation('{$this->getUrl('*/*/generateNcr', array('_current'=>true))}')",
				    'class'   => 'reset',
			    )
		    );

		    if($currentObj->getNcrStatus() == 0 && $misc->isOwner($currentObj)){
			    $this->_addButton(
				    'submitted',
				    array(
					    'label'   => Mage::helper('bs_ncr')->__('Submit'),
					    'onclick'   => "submitNcr()",
					    'class'   => 'save submit',
				    ),1,888
			    );
		    }

		    if($currentObj->getNcrStatus() == 1 && $misc->isManager($currentObj)){//manager

			    $this->_addButton(
				    'reject',
				    array(
					    'label'   => Mage::helper('bs_ncr')->__('Reject'),
					    'onclick'   => "rejectNcr()",
					    'class'   => 'save',
				    )
			    );

			    $this->_addButton(
				    'accept',
				    array(
					    'label'   => Mage::helper('bs_ncr')->__('Accept'),
					    'onclick'   => "acceptNcr()",
					    'class'   => 'save',
				    )
			    );




			    $this->_removeButton('save');
		    }



		    if(($currentObj->getNcrStatus() == 2 || $currentObj->getNcrStatus() == 4) && $misc->isOwner($currentObj)){

		    	$dueDate = new DateTime($currentObj->getDueDate());
			    $currentDate = new DateTime("now");

			    //if($dueDate >= $currentDate){
				    $this->_addButton(
					    'close',
					    array(
						    'label'   => Mage::helper('bs_ncr')->__('Close'),
						    'onclick'   => "closeNcr()",
						    'class'   => 'save closes',
					    )
				    );
			    //}


			    $this->_removeButton('delete');
			    $this->_removeButton('save');
		    }

		    if($currentObj->getNcrStatus() == 3){//nrc is closed, remove close button
			    $this->_removeButton('close');
			    $this->_removeButton('delete');
			    $this->_removeButton('save');
		    }

	    }

	    if($misc->isManager($currentObj)){//manager just accept
		    $this->_removeButton('accept');

		    $this->_addButton(
			    'accept1',
			    array(
				    'label'   => Mage::helper('bs_ncr')->__('Accept'),
				    'onclick'   => "acceptNcr()",
				    'class'   => 'save',
			    )
		    );
		    if($currentObj->getNcrStatus() == 2){
			    $this->_removeButton('accept1');
		    }

		    $this->_removeButton('submitted');


	    }

        if($currentObj->getId() && $currentObj->getNcrStatus() == 1){//&& $currentObj->getAccept() != 1
            $this->_removeButton('delete');
            if(!$misc->isManager($currentObj)){//Inspector cannot edit but Manager can
                $this->_removeButton('save');
                $this->_removeButton('saveandcontinue');

                $this->_removeButton('reset');
                $this->_removeButton('back');

                $this->_addButton(
                    'submitted',
                    array(
                        'label'   => Mage::helper('bs_ncr')->__('Ncr was submitted. You CANNOT edit.'),
                        'onclick' => 'history.back()',
                        'class'   => 'back',
                    ),
                    -1
                );
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

        //Final check, make sure only owner can edit or if it's submitted, manager can edit
        if(!$misc->isOwner($currentObj)){
            if(!$misc->isManager($currentObj) || ($misc->isOwner($currentObj) && !in_array($currentObj->getNcrStatus(), [1,6]))){
                $this->_removeButton('save');
                $this->_removeButton('saveandcontinue');
                $this->_removeButton('delete');
                $this->_removeButton('reset');
            }

        }

        //Make sure that admin can do anything
	    if($misc->isAdmin($currentObj)){//1 is super admin
		    //first we remove all buttons
		    $this->_removeButton('save');
		    $this->_removeButton('saveandcontinue');
		    $this->_removeButton('delete');
		    $this->_removeButton('reset');

		    $this->_addButton(
			    'save1',
			    array(
				    'label'   => Mage::helper('bs_ncr')->__('Save'),
				    'onclick'   => "saveAndContinueEdit()",
				    'class'   => 'save',
			    )
		    );
		    $this->_addButton(
			    'rintp',
			    array(
				    'label'   => Mage::helper('bs_ncr')->__('Print'),
				    'onclick'   => "setLocation('{$this->getUrl('*/*/generateNcr', array('_current'=>true))}')",
				    'class'   => 'print',
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
