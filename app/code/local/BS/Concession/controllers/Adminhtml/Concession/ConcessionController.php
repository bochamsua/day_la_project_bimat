<?php
/**
 * BS_Concession extension
 * 
 * @category       BS
 * @package        BS_Concession
 * @copyright      Copyright (c) 2017
 */
/**
 * Concession Data admin controller
 *
 * @category    BS
 * @package     BS_Concession
 * @author Bui Phong
 */
class BS_Concession_Adminhtml_Concession_ConcessionController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the concession
     *
     * @access protected
     * @return BS_Concession_Model_Concession
     */
    protected function _initConcession()
    {
        $concessionId  = (int) $this->getRequest()->getParam('id');
        $concession    = Mage::getModel('bs_concession/concession');
        if ($concessionId) {
            $concession->load($concessionId);
        }
        Mage::register('current_concession', $concession);
        return $concession;
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
        $this->_title(Mage::helper('bs_concession')->__('Concession Data'))
             ->_title(Mage::helper('bs_concession')->__('Concession Data'));
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
     * edit concession - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $concessionId    = $this->getRequest()->getParam('id');
        $concession      = $this->_initConcession();
        if ($concessionId && !$concession->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_concession')->__('This concession no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getConcessionData(true);
        if (!empty($data)) {
            $concession->setData($data);
        }
        Mage::register('concession_data', $concession);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_concession')->__('Concession Data'))
             ->_title(Mage::helper('bs_concession')->__('Concession Data'));
        if ($concession->getId()) {
            $this->_title($concession->getName());
        } else {
            $this->_title(Mage::helper('bs_concession')->__('Add concession'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new concession action
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
     * save concession - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('concession')) {
            try {
                $data = $this->_filterDates($data, ['report_date' ,'spare_do']);
                $concession = $this->_initConcession();

	            /*$tobeRaised = false;
	            if(!$concession->getId()){
		            $tobeRaised = true;
		            $data['ins_id'] = Mage::getSingleton('admin/session')->getUser()->getId();
		            //$data['name'] = Mage::helper('bs_concession')->getNextRefNo();
	            }*/

                $concession->addData($data);
                $sourceName = $this->_uploadAndGetName(
                    'source',
                    Mage::helper('bs_concession/concession')->getFileBaseDir(),
                    $data
                );
                $concession->setData('source', $sourceName);
                $reasonSourceName = $this->_uploadAndGetName(
                    'reason_source',
                    Mage::helper('bs_concession/concession')->getFileBaseDir(),
                    $data
                );
                $concession->setData('reason_source', $reasonSourceName);
                $concession->save();

	            $newId = $concession->getId();
                /*$message = Mage::helper('bs_misc/relation')->createRelation($newId, 'concession', $data);

	            Mage::getSingleton('adminhtml/session')->addSuccess(
		            implode("<br>", $message)
	            );*/

                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$concession->getRefType()."','concession',".$concession->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_concession')->__('Concession Data was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $concession->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['source']['value'])) {
                    $data['source'] = $data['source']['value'];
                }
                if (isset($data['reason_source']['value'])) {
                    $data['reason_source'] = $data['reason_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setConcessionData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['source']['value'])) {
                    $data['source'] = $data['source']['value'];
                }
                if (isset($data['reason_source']['value'])) {
                    $data['reason_source'] = $data['reason_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was a problem saving the concession.')
                );
                Mage::getSingleton('adminhtml/session')->setConcessionData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_concession')->__('Unable to find concession to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete concession - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $concession = Mage::getModel('bs_concession/concession');
                $concession->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_concession')->__('Concession Data was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error deleting concession.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_concession')->__('Could not find concession to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete concession - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession to delete.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                    $concession = Mage::getModel('bs_concession/concession');
                    $concession->setId($concessionId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_concession')->__('Total of %d concession were successfully deleted.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error deleting concession.')
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
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Reason change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massReasonAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                    ->setReason($this->getRequest()->getParam('flag_reason'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Spare Type change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSpareTypeAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                    ->setSpareType($this->getRequest()->getParam('flag_spare_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Requester change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSpareRequesterAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                    ->setSpareRequester($this->getRequest()->getParam('flag_spare_requester'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Troubleshooting Type change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massTbTypeAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                    ->setTbType($this->getRequest()->getParam('flag_tb_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Downtime Type change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDtTypeAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                    ->setDtType($this->getRequest()->getParam('flag_dt_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass NCR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massNcrAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                    ->setNcr($this->getRequest()->getParam('flag_ncr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass IR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massIrAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                    ->setIr($this->getRequest()->getParam('flag_ir'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass QR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massQrAction()
    {
        $concessionIds = $this->getRequest()->getParam('concession');
        if (!is_array($concessionIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_concession')->__('Please select concession.')
            );
        } else {
            try {
                foreach ($concessionIds as $concessionId) {
                $concession = Mage::getSingleton('bs_concession/concession')->load($concessionId)
                    ->setQr($this->getRequest()->getParam('flag_qr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d concession were successfully updated.', count($concessionIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_concession')->__('There was an error updating concession.')
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
        $fileName   = 'concession.csv';
        $content    = $this->getLayout()->createBlock('bs_concession/adminhtml_concession_grid')
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
        $fileName   = 'concession.xls';
        $content    = $this->getLayout()->createBlock('bs_concession/adminhtml_concession_grid')
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
        $fileName   = 'concession.xml';
        $content    = $this->getLayout()->createBlock('bs_concession/adminhtml_concession_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function irsAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.qr');
        $this->renderLayout();
    }

    public function qnsAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.qn');
        $this->renderLayout();
    }

    public function qnsGridAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.qn');
        $this->renderLayout();
    }

    public function carsAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.car');
        $this->renderLayout();
    }

    public function carsGridAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.car');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initConcession();
        $this->loadLayout();
        $this->getLayout()->getBlock('concession.edit.tab.drr');
        $this->renderLayout();
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_data/concession');
    }
}
