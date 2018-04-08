<?php
/**
 * BS_Cmr extension
 * 
 * @category       BS
 * @package        BS_Cmr
 * @copyright      Copyright (c) 2017
 */
/**
 * CMR Data admin controller
 *
 * @category    BS
 * @package     BS_Cmr
 * @author Bui Phong
 */
class BS_Cmr_Adminhtml_Cmr_CmrController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the cmr
     *
     * @access protected
     * @return BS_Cmr_Model_Cmr
     */
    protected function _initCmr()
    {
        $cmrId  = (int) $this->getRequest()->getParam('id');
        $cmr    = Mage::getModel('bs_cmr/cmr');
        if ($cmrId) {
            $cmr->load($cmrId);
        }
        Mage::register('current_cmr', $cmr);
        return $cmr;
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
        $this->_title(Mage::helper('bs_cmr')->__('CMR Data Data'))
             ->_title(Mage::helper('bs_cmr')->__('CMR Data'));
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
     * edit cmr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $cmrId    = $this->getRequest()->getParam('id');
        $cmr      = $this->_initCmr();
        if ($cmrId && !$cmr->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_cmr')->__('This cmr no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCmrData(true);
        if (!empty($data)) {
            $cmr->setData($data);
        }
        Mage::register('cmr_data', $cmr);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_cmr')->__('CMR Data Data'))
             ->_title(Mage::helper('bs_cmr')->__('CMR Data'));
        if ($cmr->getId()) {
            $this->_title($cmr->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_cmr')->__('Add cmr'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new cmr action
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
     * save cmr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('cmr')) {
            try {
                $data = $this->_filterDates($data, ['report_date' ,'due_date' ,'close_date']);
                $cmr = $this->_initCmr();

                $cmr->addData($data);
                $cmr->save();

                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$cmr->getRefType()."','cmr',".$cmr->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cmr')->__('CMR Data was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/edit', ['id' => $cmr->getId()]);
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCmrData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was a problem saving the cmr.')
                );
                Mage::getSingleton('adminhtml/session')->setCmrData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_cmr')->__('Unable to find cmr to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete cmr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $cmr = Mage::getModel('bs_cmr/cmr');
                $cmr->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cmr')->__('CMR Data was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was an error deleting cmr.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_cmr')->__('Could not find cmr to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete cmr - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $cmrIds = $this->getRequest()->getParam('cmr');
        if (!is_array($cmrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmr')->__('Please select cmr to delete.')
            );
        } else {
            try {
                foreach ($cmrIds as $cmrId) {
                    $cmr = Mage::getModel('bs_cmr/cmr');
                    $cmr->setId($cmrId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cmr')->__('Total of %d cmr were successfully deleted.', count($cmrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was an error deleting cmr.')
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
        $cmrIds = $this->getRequest()->getParam('cmr');
        if (!is_array($cmrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmr')->__('Please select cmr.')
            );
        } else {
            try {
                foreach ($cmrIds as $cmrId) {
                $cmr = Mage::getSingleton('bs_cmr/cmr')->load($cmrId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cmr were successfully updated.', count($cmrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was an error updating cmr.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Repetitive change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massRepetitiveAction()
    {
        $cmrIds = $this->getRequest()->getParam('cmr');
        if (!is_array($cmrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmr')->__('Please select cmr.')
            );
        } else {
            try {
                foreach ($cmrIds as $cmrId) {
                $cmr = Mage::getSingleton('bs_cmr/cmr')->load($cmrId)
                    ->setRepetitive($this->getRequest()->getParam('flag_repetitive'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cmr were successfully updated.', count($cmrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was an error updating cmr.')
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
        $cmrIds = $this->getRequest()->getParam('cmr');
        if (!is_array($cmrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmr')->__('Please select cmr.')
            );
        } else {
            try {
                foreach ($cmrIds as $cmrId) {
                $cmr = Mage::getSingleton('bs_cmr/cmr')->load($cmrId)
                    ->setIr($this->getRequest()->getParam('flag_ir'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cmr were successfully updated.', count($cmrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was an error updating cmr.')
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
        $cmrIds = $this->getRequest()->getParam('cmr');
        if (!is_array($cmrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmr')->__('Please select cmr.')
            );
        } else {
            try {
                foreach ($cmrIds as $cmrId) {
                $cmr = Mage::getSingleton('bs_cmr/cmr')->load($cmrId)
                    ->setNcr($this->getRequest()->getParam('flag_ncr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cmr were successfully updated.', count($cmrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was an error updating cmr.')
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
        $cmrIds = $this->getRequest()->getParam('cmr');
        if (!is_array($cmrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmr')->__('Please select cmr.')
            );
        } else {
            try {
                foreach ($cmrIds as $cmrId) {
                $cmr = Mage::getSingleton('bs_cmr/cmr')->load($cmrId)
                    ->setQr($this->getRequest()->getParam('flag_qr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cmr were successfully updated.', count($cmrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was an error updating cmr.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass DRR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDrrAction()
    {
        $cmrIds = $this->getRequest()->getParam('cmr');
        if (!is_array($cmrIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cmr')->__('Please select cmr.')
            );
        } else {
            try {
                foreach ($cmrIds as $cmrId) {
                $cmr = Mage::getSingleton('bs_cmr/cmr')->load($cmrId)
                    ->setDrr($this->getRequest()->getParam('flag_drr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cmr were successfully updated.', count($cmrIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cmr')->__('There was an error updating cmr.')
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
        $fileName   = 'cmr.csv';
        $content    = $this->getLayout()->createBlock('bs_cmr/adminhtml_cmr_grid')
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
        $fileName   = 'cmr.xls';
        $content    = $this->getLayout()->createBlock('bs_cmr/adminhtml_cmr_grid')
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
        $fileName   = 'cmr.xml';
        $content    = $this->getLayout()->createBlock('bs_cmr/adminhtml_cmr_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function irsAction()
    {
        $this->_initCmr();
        $this->loadLayout();
        $this->getLayout()->getBlock('cmr.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initCmr();
        $this->loadLayout();
        $this->getLayout()->getBlock('cmr.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initCmr();
        $this->loadLayout();
        $this->getLayout()->getBlock('cmr.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initCmr();
        $this->loadLayout();
        $this->getLayout()->getBlock('cmr.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initCmr();
        $this->loadLayout();
        $this->getLayout()->getBlock('cmr.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initCmr();
        $this->loadLayout();
        $this->getLayout()->getBlock('cmr.edit.tab.qr');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initCmr();
        $this->loadLayout();
        $this->getLayout()->getBlock('cmr.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initCmr();
        $this->loadLayout();
        $this->getLayout()->getBlock('cmr.edit.tab.drr');
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_data/cmr');
    }
}
