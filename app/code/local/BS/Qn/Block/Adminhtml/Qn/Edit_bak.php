<?php
/**
 * BS_Qn extension
 * 
 * @category       BS
 * @package        BS_Qn
 * @copyright      Copyright (c) 2016
 */
/**
 * QN admin edit form
 *
 * @category    BS
 * @package     BS_Qn
 * @author Bui Phong
 */
class BS_Qn_Block_Adminhtml_Qn_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_qn';
        $this->_controller = 'adminhtml_qn';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_qn')->__('Save & Continue'),
                'onclick' => 'saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
                'class'   => 'save',
            ),
            -100
        ); */

        $this->_updateButton('save','onclick','saveOnly()');
        $this->_updateButton('delete','onclick','deleteOnly()');
	    $this->_removeButton('reset');

        $currentObj = Mage::registry('current_qn');

        $misc = $this->helper('bs_misc');

	    if($currentObj->getId()){

		    $this->_addButton(
			    '2059',
			    [
				    'label'   => Mage::helper('bs_qn')->__('Print'),
				    'onclick'   => "setLocation('{$this->getUrl('*/*/generateQn', ['_current'=>true])}')",
				    'class'   => 'reset',
                ]
		    );

		    if($currentObj->getQnStatus() == 0 && $misc->isOwner($currentObj)){
			    $this->_addButton(
				    'submitted',
				    [
					    'label'   => Mage::helper('bs_qn')->__('Submit'),
					    'onclick'   => "submitQn()",
					    'class'   => 'save submit',
                    ],1,888
			    );
		    }

		    if($currentObj->getQnStatus() == 1 && $misc->isManager($currentObj)){//manager

			    $this->_addButton(
				    'reject',
				    [
					    'label'   => Mage::helper('bs_qn')->__('Reject'),
					    'onclick'   => "rejectQn()",
					    'class'   => 'save',
                    ]
			    );

			    $this->_addButton(
				    'accept',
				    [
					    'label'   => Mage::helper('bs_qn')->__('Accept'),
					    'onclick'   => "acceptQn()",
					    'class'   => 'save',
                    ]
			    );




			    $this->_removeButton('save');
		    }

		    if(($currentObj->getQnStatus() == 2 || $currentObj->getQnStatus() == 4) && $misc->isOwner($currentObj)){

			    $dueDate = new DateTime($currentObj->getDueDate());
			    $currentDate = new DateTime("now");

			    //if($dueDate >= $currentDate){
			    $this->_addButton(
				    'close',
				    [
					    'label'   => Mage::helper('adminhtml')->__('Close'),
					    'onclick'   => "closeQn()",
					    'class'   => 'save closes',
                    ]
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
			    [
				    'label'   => Mage::helper('bs_qn')->__('Accept'),
				    'onclick'   => "acceptQn()",
				    'class'   => 'save',
                ]
		    );

		    if($currentObj->getQnStatus() == 2){
			    $this->_removeButton('accept1');
		    }

		    $this->_removeButton('submitted');


	    }


	    if($currentObj->getQnStatus() == 1){//&& $currentObj->getAccept() != 1
		    $this->_removeButton('delete');
		    if($misc->isOwner($currentObj)){//Inspector cannot edit but Manager can
			    $this->_removeButton('save');
			    $this->_removeButton('saveandcontinue');
			    $this->_removeButton('submitted');
			    $this->_removeButton('reset');
			    $this->_removeButton('back');

			    $this->_addButton(
				    'submitted_already',
				    [
					    'label'   => Mage::helper('bs_qn')->__('QN was submitted. You CANNOT edit.'),
					    'onclick' => 'history.back()',
					    'class'   => 'back',
                    ],
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
                [
                    'label'   => Mage::helper('bs_qn')->__('Close'),
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
            
            function submitQn() {
                editForm.submit($('edit_form').action+'back/edit/submitted/1');
            }
            
            function acceptQn() {
                editForm.submit($('edit_form').action+'back/edit/accept/1');
            }
            
            function closeQn() {
                $('qn_remark').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/close/1');
            }
            
            function rejectQn() {
                $('qn_reject_reason').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/reject/1');
            }

            var templateSyntax = /(^|.|\\r|\\n)({{(\w+)}})/;

            function saveAndContinueEdit(urlTemplate) {
                 var template = new Template(urlTemplate, templateSyntax);
                 if(typeof qn_tabsJsTabs !== 'undefined'){
                    var url = template.evaluate({tab_id:qn_tabsJsTabs.activeTab.id});
                 }else {
                    var url = template.evaluate({tab_id:qn_info_tabsJsTabs.activeTab.id});
                 }

                 editForm.submit(url + '".$add."');

            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof qn_tabsJsTabs !== 'undefined'){
                        qn_tabsJsTabs.setSkipDisplayFirstTab();
                        qn_tabsJsTabs.showTabContent(obj);
                     }else {
                        qn_info_tabsJsTabs.setSkipDisplayFirstTab();
                        qn_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_work/qn/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_work/qn/delete");

        if(!$isAllowedEdit){
            $this->_removeButton('save');
            $this->_removeButton('saveandcontinue');
        }
        if(!$isAllowedDelete){
            $this->_removeButton('delete');
        }


	    //Final check, make sure only owner can edit or if it's submitted, manager can edit
	    if($currentObj->getInsId() && !$misc->isOwner($currentObj)){
		    if(!$misc->isManager($currentObj) || ($misc->isManager($currentObj) && $currentObj->getQnStatus() != 1)){
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
			    [
				    'label'   => Mage::helper('bs_qn')->__('Save'),
				    'onclick'   => "saveOnly()",
				    'class'   => 'save',
                ]
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
        if (Mage::registry('current_qn') && Mage::registry('current_qn')->getId()) {

	        $curQn = Mage::registry('current_qn');
	        $closeDate = $curQn->getCloseDate();
	        $closeDate = Mage::getModel('core/date')->date('d/m/Y', $closeDate);

	        $closeText = '';
	        if($curQn->getQnStatus() == 3){//closed
		        $closeText = ' ('.$closeDate.')';
	        }

	        return Mage::helper('bs_qn')->__(
		        "Edit QN '%s' - <span style='color: red;'>%s</span>  %s",
		        $this->escapeHtml($curQn->getRefNo()), Mage::getSingleton('bs_qn/qn_attribute_source_qnstatus')->getOptionText($curQn->getQnStatus()), $closeText
	        );

        } else {
            return Mage::helper('bs_qn')->__('Add QN');
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
