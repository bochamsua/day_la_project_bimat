<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Task admin controller
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Adminhtml_Misc_MiscController extends BS_Sur_Controller_Adminhtml_Sur
{

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Misc'));
        $this->renderLayout();
    }


    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massInspectorAction()
    {
    	$type = $this->getRequest()->getParam('type');
        $itemIds = $this->getRequest()->getParam($type);
        $misc = Mage::helper('bs_misc');

        if (!is_array($itemIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select %ss.', strtoupper($type))
            );
        } else {
            try {
                $count = 0;
                foreach ($itemIds as $itemId) {
                    $obj = Mage::getSingleton("bs_{$type}/{$type}")->load($itemId);

                    if($misc->canChangeInspector($obj)){
                        $obj->setInsId($this->getRequest()->getParam('inspector'))
                            ->setIsMassupdate(true)
                            ->save();

                        $count++;
                    }

                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d %ss were successfully updated.', $count, strtoupper($type))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating %ss.', strtoupper($type))
                );
                Mage::logException($e);
            }
        }
        $this->_redirect("*/{$type}_{$type}/index");
    }

	public function massApprovalAction()
	{
        $type = $this->getRequest()->getParam('type');
        $itemIds = $this->getRequest()->getParam($type);
        $misc = Mage::helper('bs_misc');

		if (!is_array($itemIds)) {
			Mage::getSingleton('adminhtml/session')->addError(
				Mage::helper('bs_misc')->__('Please select %ss.', strtoupper($type))
			);
		} else {
			try {
                $count = 0;
				foreach ($itemIds as $itemId) {
                    $obj = Mage::getSingleton("bs_{$type}/{$type}")->load($itemId);

                    if($misc->canChangeApproval($obj)){
                        $obj->setApprovalId($this->getRequest()->getParam('approval_id'))
                            ->setIsMassupdate(true)
                            ->save();
                        $count++;
                    }

				}
				$this->_getSession()->addSuccess(
					$this->__('Total of %d %ss were successfully updated.', $count, strtoupper($type))
				);
			} catch (Mage_Core_Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(
					Mage::helper('bs_misc')->__('There was an error updating %ss.', strtoupper($type))
				);
				Mage::logException($e);
			}
		}
        $this->_redirect("*/{$type}_{$type}/index");
	}

    public function massStatusAction()
    {
        $type = $this->getRequest()->getParam('type');
        $itemIds = $this->getRequest()->getParam($type);
        $misc = Mage::helper('bs_misc');

        if (!is_array($itemIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select %ss.', strtoupper($type))
            );
        } else {
            try {
                $status = $this->getRequest()->getParam('status');
                $count = 0;
                foreach ($itemIds as $itemId) {
                    $obj = Mage::getSingleton("bs_{$type}/{$type}")->load($itemId);
                    if($misc->canChangeStatus($obj)){
                        $obj->setData($type.'_status', $status)
                            ->setIsMassupdate(true)
                            ->save();
                        $count++;
                    }

                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d %ss were successfully updated.', $count, strtoupper($type))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating items.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect("*/{$type}_{$type}/index");
    }

    public function massDeleteAction()
    {
        $type = $this->getRequest()->getParam('type');
        $itemIds = $this->getRequest()->getParam($type);
        $misc = Mage::helper('bs_misc');

        if (!is_array($itemIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select %ss.', strtoupper($type))
            );
        } else {
            try {
                $count = 0;
                foreach ($itemIds as $itemId) {
                    $model = Mage::getModel("bs_{$type}/{$type}");
                    if($model){
                        $obj = $model->load($itemId);
                        if($misc->canDelete($obj)){
                            $obj->delete();
                            $count++;
                        }
                    }


                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d %ss were successfully deleted.', $count, strtoupper($type))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting %ss.', strtoupper($type))
                );
                Mage::logException($e);
            }
        }
        $this->_redirect("*/{$type}_{$type}/index");
    }

    public function doSpecialAction(){
        $message = $this->getRequest()->getParam('a');//submited/accepted/rejected/closed
        $type   = $this->getRequest()->getParam('t');//ncr,ir,qr...
        $id   = $this->getRequest()->getParam('id');
        $status   = $this->getRequest()->getParam('s');//status of action
        $date   = $this->getRequest()->getParam('d', false);//date fields will be automatically updated

        $currentUser = Mage::helper('bs_misc')->getCurrentUserInfo();
        $approvalId = $currentUser[0];
        //load object
        $obj = Mage::getModel("bs_{$type}/{$type}")->load($id);
        //$obj->setData("{$type}_status", $status);

        if($message == 'accepted'){//submit, we need to set Approval Id
            $obj->setData('approval_id', $approvalId);

        }

        $data = $this->getRequest()->getPost($type);
        $data = $this->_filterDates($data, ['report_date' ,'due_date' ,'close_date', 'event_date', 'issue_date', 'expire_date', 'res_date']);


        if($date){//we update the date fields automatically
            $dates = explode(",", $date);
            foreach ($dates as $d) {
                $obj->setData($d, Mage::getSingleton('core/date')->gmtDate());
            }
        }


        $fields = $this->getRequest()->getParam('f');//fields require to save when do action, default all
        if($fields == 'all'){//submit

            $obj->addData($data);
            foreach ($data as $key => $value) {
                if(is_array($data[$key]) || isset($_FILES[$key])){
                    $fileName = $this->_uploadAndGetName(
                        $key,
                        Mage::helper("bs_{$type}/{$type}")->getFileBaseDir(),
                        $data
                    );
                    $obj->setData($key, $fileName);
                }
            }
        }else {
            $fields = explode(",", $fields);

            $clear = $this->getRequest()->getParam('c');//clear when reject
            $clear = explode(",", $clear);

            if(count($fields)){
                foreach ($fields as $field) {
                    if(
                        (isset($data[$field]) && is_array($data[$field]))  //file exists 
                        || isset($_FILES[$field])      //new file
                    ){     //in case
                        $fileName = $this->_uploadAndGetName(
                            $field,
                            Mage::helper("bs_{$type}/{$type}")->getFileBaseDir(),
                            $data
                        );
                        $obj->setData($field, $fileName);
                    }else {//save as normal
                        $obj->setData($field, $data[$field]);
                    }
                }
            }

            if(count($clear)){
                foreach ($clear as $item) {
                    $obj->setData($item, '');//clear
                }
            }

        }

        if($message == 'closed' && !in_array($type,['coa', 'nrw'])){//when we close NCR/DRR/CAR

            $match = [
                'ncr' => [
                    '1' => '3',
                    '2' => '6'
                ],//res status => close status
                'drr' => [
                    '1' => '2',
                    '2' => '3'
                ],//res status => close status
                'car' => [
                    '1' => '2',
                    '2' => '3'
                ],//res status => close status
                'qr' => [
                    '1' => '3',
                    '2' => '5'
                ],//res status => close status
            ];

            if(isset($match[$type])){
                //res date
                $resDate = $obj->getResDate();
                $dueDate = $obj->getDueDate();
                $closeDate = $resDate;


                $compare = Mage::helper('bs_misc/date')->compareDate(['date' => $resDate], ['date' => $dueDate], '>');
                if($compare){
                    $resStatus = 2;//overdue
                }else {
                    $resStatus = 1;//on time
                }

                $objStatus = $match[$type][$resStatus];

                $obj->setData("{$type}_status", $objStatus);
                $obj->setData("res_status", $resStatus);
                $obj->setData("close_date", $closeDate);
            }

/*
            //we check if the object has COA or not
            $coa = Mage::getModel('bs_coa/coa')->getCollection();
            $coa->addFieldToFilter('ref_id', ['eq' => $obj->getId()]);
            $coa->addFieldToFilter('ref_type', ['eq' => $type]);

            //$closeInfo = Mage::getModel('bs_observation/observer')->getCloseInfo();

            if($coa->count()){
                $canClose = true;
                $lateClose = false;
                $closeDates = [];
                foreach ($coa as $item) {
                    if(!in_array($item->getCoaStatus(), [1,3])){//if not closed or close late
                        $canClose = false;
                    }else {
                        if($item->getCoaStatus() == 3){//late close
                            $lateClose = true;
                        }
                    }
                    $closeDates[] = new DateTime($item->getCloseDate());
                }

                if($canClose){

                    arsort($closeDates);
                    $cDate = $closeDates[0]->format('Y-m-d');

                    if($lateClose){
                        $resStatus = 2;//overdue
                    }else {
                        $resStatus = 1;//on time
                    }


                    $objStatus = $match[$type][$resStatus];

                    $obj->setData("{$type}_status", $objStatus);
                    $obj->setData("res_status", $resStatus);
                    $obj->setData("close_date", $cDate);


                }else {
                    Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('bs_misc')->__('Please close all related Corrective Actions first!')
                    );
                }

            }else {



            }*/

        }else {
            //for item doesnt have close date info
            //nrw, for example
            if($message == 'closed' && in_array($type, ['nrw'])){
                $obj->setData("close_date", Mage::helper('bs_misc/date')->getNowStoreDate());
            }
            $obj->setData("{$type}_status", $status);
        }




        $obj->save();

        Mage::getSingleton('adminhtml/session')->addSuccess(
            Mage::helper('bs_misc')->__('%s was successfully %s.', strtoupper($type), $message)
        );

        $this->_redirect("*/{$type}_{$type}/edit", ['id' => $id]);
        return;


    }



    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Bui Phong
     */
    protected function _isAllowed()
    {
        return true;
    }
}
