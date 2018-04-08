<?php
/**
 * BS_Car extension
 * 
 * @category       BS
 * @package        BS_Car
 * @copyright      Copyright (c) 2016
 */
/**
 * Car admin edit form
 *
 * @category    BS
 * @package     BS_Car
 * @author Bui Phong
 */
class BS_Car_Block_Adminhtml_Car_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_blockGroup = 'bs_car';
        $this->_controller = 'adminhtml_car';

        /* $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('bs_car')->__('Save & Continue'),
                'onclick' => 'saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
                'class'   => 'save',
            ),
            -100
        ); */

	    $this->_removeButton('reset');

        $this->_updateButton('save','onclick','saveOnly()');
        $this->_updateButton('delete','onclick','deleteOnly()');

        $currentObj = Mage::registry('current_car');

        $misc = $this->helper('bs_misc');

	    if($currentObj->getId()){

		    $this->_addButton(
			    'close',
			    [
				    'label'   => Mage::helper('bs_car')->__('Close'),
				    'onclick'   => "closeCar()",
				    'class'   => 'save closes',
                ]
		    );

		    if($currentObj->getCarStatus() == 1){//car is closed, remove close button
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
                [
                    'label'   => Mage::helper('bs_car')->__('Close'),
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

            function closeCar() {
                $('car_remark').addClassName('required-entry');
                editForm.submit($('edit_form').action+'back/edit/close/1');
            }




            Event.observe(window, 'load', function() {
                var objName = '".$this->getSelectedTabId()."';
                if (objName != '') {
                    obj = $(objName);
                    //IE fix (bubbling event model)
                    if(typeof car_tabsJsTabs !== 'undefined'){
                        car_tabsJsTabs.setSkipDisplayFirstTab();
                        car_tabsJsTabs.showTabContent(obj);
                     }else {
                        car_info_tabsJsTabs.setSkipDisplayFirstTab();
                        car_info_tabsJsTabs.showTabContent(obj);
                     }

                }

            });
        ";

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_work/car/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_work/car/delete");

        if(!$isAllowedEdit){
            $this->_removeButton('save');
            $this->_removeButton('saveandcontinue');
        }
        if(!$isAllowedDelete){
            $this->_removeButton('delete');
        }

	    if($currentObj->getInsId() && !$misc->isAdmin($currentObj)){
		    if($misc->isManager($currentObj) || ($misc->isManager($currentObj) && !in_array($currentObj->getCarStatus(), [1]))){
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
			    [
				    'label'   => Mage::helper('bs_car')->__('Save admin slin kin kin'),
				    'onclick'   => "saveAndContinueEdit()",
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
        if (Mage::registry('current_car') && Mage::registry('current_car')->getId()) {

	        $curCar = Mage::registry('current_car');

	        return Mage::helper('bs_ir')->__(
		        "Edit Car '%s' - <span style='color: red;'>%s</span>",
		        $this->escapeHtml($curCar->getRefNo()), Mage::getSingleton('bs_car/car_attribute_source_carstatus')->getOptionText($curCar->getCarStatus())
	        );


        } else {
            return Mage::helper('bs_car')->__('Add Car');
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
