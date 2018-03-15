<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * A/C Reg admin controller
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Adminhtml_Acreg_AcregController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the a/c reg
     *
     * @access protected
     * @return BS_Acreg_Model_Acreg
     */
    protected function _initAcreg()
    {
        $acregId  = (int) $this->getRequest()->getParam('id');
        $acreg    = Mage::getModel('bs_acreg/acreg');
        if ($acregId) {
            $acreg->load($acregId);
        }
        Mage::register('current_acreg', $acreg);
        return $acreg;
    }

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
        $this->_title(Mage::helper('bs_acreg')->__('A/C Reg'))
             ->_title(Mage::helper('bs_acreg')->__('A/C Reg'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit a/c reg - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $acregId    = $this->getRequest()->getParam('id');
        $acreg      = $this->_initAcreg();
        if ($acregId && !$acreg->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_acreg')->__('This a/c reg no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getAcregData(true);
        if (!empty($data)) {
            $acreg->setData($data);
        }
        Mage::register('acreg_data', $acreg);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_acreg')->__('A/C Reg'))
             ->_title(Mage::helper('bs_acreg')->__('A/C Reg'));
        if ($acreg->getId()) {
            $this->_title($acreg->getReg());
        } else {
            $this->_title(Mage::helper('bs_acreg')->__('Add a/c reg'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new a/c reg action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save a/c reg - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('acreg')) {
            try {
                $acreg = $this->_initAcreg();

	            if($data['import'] != ''){
		            $import = $data['import'];
		            $import = explode("\r\n", $import);
		            $customerId = $data['customer_id'];
		            $acTypeId = $data['ac_type'];
		            $total = 0;
		            foreach ($import as $line) {
			            $line = trim($line);
			            $acreg    = Mage::getModel('bs_acreg/acreg');
			            $acreg->setCustomerId($customerId);
			            $acreg->setAcType($acTypeId);
			            $acreg->setReg($line);
			            $acreg->save();

			            $total += 1;



		            }

		            Mage::getSingleton('adminhtml/session')->addSuccess(
			            Mage::helper('bs_acreg')->__('%s A/C Reg was successfully added', $total)
		            );

		            //back to new import
		            $this->_redirect('*/*/new', array());
		            return;

	            }else {
		            $acreg->addData($data);
		            $acreg->save();
	            }


                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_acreg')->__('A/C Reg was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $acreg->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setAcregData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was a problem saving the a/c reg.')
                );
                Mage::getSingleton('adminhtml/session')->setAcregData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_acreg')->__('Unable to find a/c reg to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete a/c reg - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $acreg = Mage::getModel('bs_acreg/acreg');
                $acreg->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_acreg')->__('A/C Reg was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was an error deleting a/c reg.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_acreg')->__('Could not find a/c reg to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete a/c reg - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $acregIds = $this->getRequest()->getParam('acreg');
        if (!is_array($acregIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_acreg')->__('Please select a/c reg to delete.')
            );
        } else {
            try {
                foreach ($acregIds as $acregId) {
                    $acreg = Mage::getModel('bs_acreg/acreg');
                    $acreg->setId($acregId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_acreg')->__('Total of %d a/c reg were successfully deleted.', count($acregIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was an error deleting a/c reg.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massStatusAction()
    {
        $acregIds = $this->getRequest()->getParam('acreg');
        if (!is_array($acregIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_acreg')->__('Please select a/c reg.')
            );
        } else {
            try {
                foreach ($acregIds as $acregId) {
                $acreg = Mage::getSingleton('bs_acreg/acreg')->load($acregId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d a/c reg were successfully updated.', count($acregIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was an error updating a/c reg.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass customer change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massCustomerIdAction()
    {
        $acregIds = $this->getRequest()->getParam('acreg');
        if (!is_array($acregIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_acreg')->__('Please select a/c reg.')
            );
        } else {
            try {
                foreach ($acregIds as $acregId) {
                $acreg = Mage::getSingleton('bs_acreg/acreg')->load($acregId)
                    ->setCustomerId($this->getRequest()->getParam('flag_customer_id'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d a/c reg were successfully updated.', count($acregIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was an error updating a/c reg.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function exportCsvAction()
    {
        $fileName   = 'acreg.csv';
        $content    = $this->getLayout()->createBlock('bs_acreg/adminhtml_acreg_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function exportExcelAction()
    {
        $fileName   = 'acreg.xls';
        $content    = $this->getLayout()->createBlock('bs_acreg/adminhtml_acreg_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function exportXmlAction()
    {
        $fileName   = 'acreg.xml';
        $content    = $this->getLayout()->createBlock('bs_acreg/adminhtml_acreg_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

	public function updateAcregAction(){
		$result = array();
		$customerId = $this->getRequest()->getPost('customer_id');
		$acTypeId = $this->getRequest()->getPost('ac_type');
		$result['acreg'] = '<option value="">No A/C Reg</option>';
		if($customerId){

			$aregs = Mage::getModel('bs_acreg/acreg')->getCollection()
				->addFieldToFilter('customer_id', $customerId)
				->addFieldToFilter('ac_type', $acTypeId)
                ->setOrder('reg', 'ASC')
			;


			if($aregs->count()){
				$text = '';
				foreach ($aregs as $reg) {

					$text  .= '<option value="'.$reg->getId().'">'.$reg->getReg().'</option>';
				}
				$result['acreg'] = $text;
			}
		}

		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/acreg');
    }
}
