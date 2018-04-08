<?php
/**
 * BS_Rii extension
 * 
 * @category       BS
 * @package        BS_Rii
 * @copyright      Copyright (c) 2016
 */
/**
 * RII Sign-off admin controller
 *
 * @category    BS
 * @package     BS_Rii
 * @author Bui Phong
 */
class BS_Rii_Adminhtml_Rii_RiiController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the rii sign-off
     *
     * @access protected
     * @return BS_Rii_Model_Rii
     */
    protected function _initRii()
    {
        $riiId  = (int) $this->getRequest()->getParam('id');
        $rii    = Mage::getModel('bs_rii/rii');
        if ($riiId) {
            $rii->load($riiId);
        }
        Mage::register('current_rii', $rii);
        return $rii;
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
        $this->_title(Mage::helper('bs_rii')->__('RII'))
             ->_title(Mage::helper('bs_rii')->__('RII Sign-offs'));
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
     * edit rii sign-off - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $riiId    = $this->getRequest()->getParam('id');
        $rii      = $this->_initRii();
        if ($riiId && !$rii->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_rii')->__('This rii sign-off no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getRiiData(true);
        if (!empty($data)) {
            $rii->setData($data);
        }
        Mage::register('rii_data', $rii);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_rii')->__('RII'))
             ->_title(Mage::helper('bs_rii')->__('RII Sign-offs'));
        if ($rii->getId()) {
            $this->_title($rii->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_rii')->__('Add rii sign-off'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new rii sign-off action
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
     * save rii sign-off - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('rii')) {
            try {
                $data = $this->_filterDates($data, ['report_date']);
                $rii = $this->_initRii();

                $rii->addData($data);
                $rii->save();

                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_rii')->__('RII Sign-off was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $rii->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setRiiData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_rii')->__('There was a problem saving the rii sign-off.')
                );
                Mage::getSingleton('adminhtml/session')->setRiiData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_rii')->__('Unable to find rii sign-off to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete rii sign-off - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $rii = Mage::getModel('bs_rii/rii');
                $rii->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_rii')->__('RII Sign-off was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_rii')->__('There was an error deleting rii sign-off.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_rii')->__('Could not find rii sign-off to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete rii sign-off - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $riiIds = $this->getRequest()->getParam('rii');
        if (!is_array($riiIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_rii')->__('Please select rii sign-offs to delete.')
            );
        } else {
            try {
                foreach ($riiIds as $riiId) {
                    $rii = Mage::getModel('bs_rii/rii');
                    $rii->setId($riiId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_rii')->__('Total of %d rii sign-offs were successfully deleted.', count($riiIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_rii')->__('There was an error deleting rii sign-offs.')
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
        $riiIds = $this->getRequest()->getParam('rii');
        if (!is_array($riiIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_rii')->__('Please select rii sign-offs.')
            );
        } else {
            try {
                foreach ($riiIds as $riiId) {
                $rii = Mage::getSingleton('bs_rii/rii')->load($riiId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d rii sign-offs were successfully updated.', count($riiIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_rii')->__('There was an error updating rii sign-offs.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Ir change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massIrAction()
    {
        $riiIds = $this->getRequest()->getParam('rii');
        if (!is_array($riiIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_rii')->__('Please select rii sign-offs.')
            );
        } else {
            try {
                foreach ($riiIds as $riiId) {
                $rii = Mage::getSingleton('bs_rii/rii')->load($riiId)
                    ->setIr($this->getRequest()->getParam('flag_ir'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d rii sign-offs were successfully updated.', count($riiIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_rii')->__('There was an error updating rii sign-offs.')
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
        $riiIds = $this->getRequest()->getParam('rii');
        if (!is_array($riiIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_rii')->__('Please select rii sign-offs.')
            );
        } else {
            try {
                foreach ($riiIds as $riiId) {
                $rii = Mage::getSingleton('bs_rii/rii')->load($riiId)
                    ->setNcr($this->getRequest()->getParam('flag_ncr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d rii sign-offs were successfully updated.', count($riiIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_rii')->__('There was an error updating rii sign-offs.')
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
        $riiIds = $this->getRequest()->getParam('rii');
        if (!is_array($riiIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_rii')->__('Please select rii sign-offs.')
            );
        } else {
            try {
                foreach ($riiIds as $riiId) {
                $rii = Mage::getSingleton('bs_rii/rii')->load($riiId)
                    ->setQr($this->getRequest()->getParam('flag_qr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d rii sign-offs were successfully updated.', count($riiIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_rii')->__('There was an error updating rii sign-offs.')
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
        $fileName   = 'rii.csv';
        $content    = $this->getLayout()->createBlock('bs_rii/adminhtml_rii_grid')
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
        $fileName   = 'rii.xls';
        $content    = $this->getLayout()->createBlock('bs_rii/adminhtml_rii_grid')
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
        $fileName   = 'rii.xml';
        $content    = $this->getLayout()->createBlock('bs_rii/adminhtml_rii_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function irsAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.qr');
        $this->renderLayout();
    }

    public function qnsAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.qn');
        $this->renderLayout();
    }

    public function qnsGridAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.qn');
        $this->renderLayout();
    }

    public function carsAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.car');
        $this->renderLayout();
    }

    public function carsGridAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.car');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initRii();
        $this->loadLayout();
        $this->getLayout()->getBlock('rii.edit.tab.drr');
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/rii');
    }
}
