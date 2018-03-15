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

        $currentObj = Mage::registry('current_qr');

        $misc = $this->helper('bs_misc');

	    if($currentObj->getId()){

		    $this->_addButton(
			    '2059',
			    array(
				    'label'   => Mage::helper('bs_qr')->__('Print'),
				    'onclick'   => "setLocation('{$this->getUrl('*/*/generateQr', array('_current'=>true))}')",
				    'class'   => 'reset',
			    )
		    );

		    if($currentObj->getQrStatus() == 0 && $misc->isOwner($currentObj)){
			    $this->_addButton(
				    'submitted',
				    array(
					    'label'   => Mage::helper('bs_qr')->__('Submit'),
					    'onclick'   => "submitQr()",
					    'class'   => 'save submit',
				    ),1,888
			    );
		    }

		    if($currentObj->getQrStatus() == 1 && $misc->isManager($currentObj)){//manager

			    $this->_addButton(
				    'reject',
				    array(
					    'label'   => Mage::helper('bs_qr')->__('Reject'),
					    'onclick'   => "rejectQr()",
					    'class'   => 'save',
				    )
			    );

			    $this->_addButton(
				    'accept',
				    array(
					    'label'   => Mage::helper('bs_qr')->__('Accept'),
					    'onclick'   => "acceptQr()",
					    'class'   => 'save',
				    )
			    );




			    $this->_removeButton('save');
		    }

		    if(($currentObj->getQrStatus() == 2 || $currentObj->getQrStatus() == 4) && $misc->isOwner($currentObj)){

			    $dueDate = new DateTime($currentObj->getDueDate());
			    $currentDate = new DateTime("now");

			    //if($dueDate >= $currentDate){
			    $this->_addButton(
				    'close',
				    array(
					    'label'   => Mage::helper('adminhtml')->__('Close'),
					    'onclick'   => "closeQr()",
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
		    //$this->_removeButton('save');
		    $this->_addButton(
			    'accept1',
			    array(
				    'label'   => Mage::helper('bs_qr')->__('Accept'),
				    'onclick'   => "acceptQr()",
				    'class'   => 'save',
			    )
		    );

		    if($currentObj->getQrStatus() == 2){
			    $this->_removeButton('accept1');
		    }

		    $this->_removeButton('submitted');


	    }


	    if($currentObj->getQrStatus() == 1){//&& $currentObj->getAccept() != 1
		    $this->_removeButton('delete');
		    if($misc->isOwner($currentObj)){//Inspector cannot edit but Manager can
			    $this->_removeButton('save');
			    $this->_removeButton('saveandcontinue');
			    $this->_removeButton('submitted');
			    $this->_removeButton('reset');
			    $this->_removeButton('back');

			    $this->_addButton(
				    'submitted_already',
				    array(
					    'label'   => Mage::helper('bs_qr')->__('QR was submitted. You CANNOT edit.'),
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
                    'label'   => Mage::helper('bs_qr')->__('Close'),
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
            
            function submitQr() {
                editForm.submit($('edit_form').action+'back/edit/submitted/1');
            }
            
            function acceptQr() {
                editForm.submit($('edit_form').action+'back/edit/accept/1');
            }
            
            function closeQr() {
                $('qr_remark').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/close/1');
            }
            
            function rejectQr() {
                $('qr_reject_reason').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/reject/1');
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


	    //Final check, make sure only owner can edit or if it's submitted, manager can edit
	    if($currentObj->getInsId() && !$misc->isOwner($currentObj)){
		    if(!$misc->isManager($currentObj) || ($misc->isManager($currentObj) && $currentObj->getQrStatus() != 1)){
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
				    'label'   => Mage::helper('bs_qr')->__('Save'),
				    'onclick'   => "saveOnly()",
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
