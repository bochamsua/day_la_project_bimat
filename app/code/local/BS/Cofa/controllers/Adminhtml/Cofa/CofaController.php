<?php
/**
 * BS_Cofa extension
 * 
 * @category       BS
 * @package        BS_Cofa
 * @copyright      Copyright (c) 2017
 */
/**
 * CoA Data admin controller
 *
 * @category    BS
 * @package     BS_Cofa
 * @author Bui Phong
 */
class BS_Cofa_Adminhtml_Cofa_CofaController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the cofa
     *
     * @access protected
     * @return BS_Cofa_Model_Cofa
     */
    protected function _initCofa()
    {
        $cofaId  = (int) $this->getRequest()->getParam('id');
        $cofa    = Mage::getModel('bs_cofa/cofa');
        if ($cofaId) {
            $cofa->load($cofaId);
        }
        Mage::register('current_cofa', $cofa);
        return $cofa;
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
        $this->_title(Mage::helper('bs_cofa')->__('CoA Data Data'))
             ->_title(Mage::helper('bs_cofa')->__('CoA Data'));
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
     * edit cofa - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $cofaId    = $this->getRequest()->getParam('id');
        $cofa      = $this->_initCofa();
        if ($cofaId && !$cofa->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_cofa')->__('This cofa no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCofaData(true);
        if (!empty($data)) {
            $cofa->setData($data);
        }
        Mage::register('cofa_data', $cofa);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_cofa')->__('CoA Data Data'))
             ->_title(Mage::helper('bs_cofa')->__('CoA Data'));
        if ($cofa->getId()) {
            $this->_title($cofa->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_cofa')->__('Add cofa'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new cofa action
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
     * save cofa - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('cofa')) {
            try {
                $data = $this->_filterDates($data, array('report_date' ,'due_date' ,'close_date'));
                $cofa = $this->_initCofa();

                $cofa->addData($data);
                $cofa->save();

                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$cofa->getRefType()."','cofa',".$cofa->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cofa')->__('CoA Data was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $cofa->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCofaData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was a problem saving the cofa.')
                );
                Mage::getSingleton('adminhtml/session')->setCofaData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_cofa')->__('Unable to find cofa to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete cofa - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $cofa = Mage::getModel('bs_cofa/cofa');
                $cofa->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cofa')->__('CoA Data was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was an error deleting cofa.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_cofa')->__('Could not find cofa to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete cofa - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $cofaIds = $this->getRequest()->getParam('cofa');
        if (!is_array($cofaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cofa')->__('Please select cofa to delete.')
            );
        } else {
            try {
                foreach ($cofaIds as $cofaId) {
                    $cofa = Mage::getModel('bs_cofa/cofa');
                    $cofa->setId($cofaId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_cofa')->__('Total of %d cofa were successfully deleted.', count($cofaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was an error deleting cofa.')
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
        $cofaIds = $this->getRequest()->getParam('cofa');
        if (!is_array($cofaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cofa')->__('Please select cofa.')
            );
        } else {
            try {
                foreach ($cofaIds as $cofaId) {
                $cofa = Mage::getSingleton('bs_cofa/cofa')->load($cofaId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cofa were successfully updated.', count($cofaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was an error updating cofa.')
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
        $cofaIds = $this->getRequest()->getParam('cofa');
        if (!is_array($cofaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cofa')->__('Please select cofa.')
            );
        } else {
            try {
                foreach ($cofaIds as $cofaId) {
                $cofa = Mage::getSingleton('bs_cofa/cofa')->load($cofaId)
                    ->setRepetitive($this->getRequest()->getParam('flag_repetitive'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cofa were successfully updated.', count($cofaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was an error updating cofa.')
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
        $cofaIds = $this->getRequest()->getParam('cofa');
        if (!is_array($cofaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cofa')->__('Please select cofa.')
            );
        } else {
            try {
                foreach ($cofaIds as $cofaId) {
                $cofa = Mage::getSingleton('bs_cofa/cofa')->load($cofaId)
                    ->setIr($this->getRequest()->getParam('flag_ir'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cofa were successfully updated.', count($cofaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was an error updating cofa.')
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
        $cofaIds = $this->getRequest()->getParam('cofa');
        if (!is_array($cofaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cofa')->__('Please select cofa.')
            );
        } else {
            try {
                foreach ($cofaIds as $cofaId) {
                $cofa = Mage::getSingleton('bs_cofa/cofa')->load($cofaId)
                    ->setNcr($this->getRequest()->getParam('flag_ncr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cofa were successfully updated.', count($cofaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was an error updating cofa.')
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
        $cofaIds = $this->getRequest()->getParam('cofa');
        if (!is_array($cofaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cofa')->__('Please select cofa.')
            );
        } else {
            try {
                foreach ($cofaIds as $cofaId) {
                $cofa = Mage::getSingleton('bs_cofa/cofa')->load($cofaId)
                    ->setQr($this->getRequest()->getParam('flag_qr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cofa were successfully updated.', count($cofaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was an error updating cofa.')
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
        $cofaIds = $this->getRequest()->getParam('cofa');
        if (!is_array($cofaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_cofa')->__('Please select cofa.')
            );
        } else {
            try {
                foreach ($cofaIds as $cofaId) {
                $cofa = Mage::getSingleton('bs_cofa/cofa')->load($cofaId)
                    ->setDrr($this->getRequest()->getParam('flag_drr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cofa were successfully updated.', count($cofaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_cofa')->__('There was an error updating cofa.')
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
        $fileName   = 'cofa.csv';
        $content    = $this->getLayout()->createBlock('bs_cofa/adminhtml_cofa_grid')
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
        $fileName   = 'cofa.xls';
        $content    = $this->getLayout()->createBlock('bs_cofa/adminhtml_cofa_grid')
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
        $fileName   = 'cofa.xml';
        $content    = $this->getLayout()->createBlock('bs_cofa/adminhtml_cofa_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function irsAction()
    {
        $this->_initCofa();
        $this->loadLayout();
        $this->getLayout()->getBlock('cofa.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initCofa();
        $this->loadLayout();
        $this->getLayout()->getBlock('cofa.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initCofa();
        $this->loadLayout();
        $this->getLayout()->getBlock('cofa.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initCofa();
        $this->loadLayout();
        $this->getLayout()->getBlock('cofa.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initCofa();
        $this->loadLayout();
        $this->getLayout()->getBlock('cofa.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initCofa();
        $this->loadLayout();
        $this->getLayout()->getBlock('cofa.edit.tab.qr');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initCofa();
        $this->loadLayout();
        $this->getLayout()->getBlock('cofa.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initCofa();
        $this->loadLayout();
        $this->getLayout()->getBlock('cofa.edit.tab.drr');
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_data/cofa');
    }
}
