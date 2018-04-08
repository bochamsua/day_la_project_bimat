<?php
/**
 * BS_Signoff extension
 * 
 * @category       BS
 * @package        BS_Signoff
 * @copyright      Copyright (c) 2016
 */
/**
 * AC Sign-off admin controller
 *
 * @category    BS
 * @package     BS_Signoff
 * @author Bui Phong
 */
class BS_Signoff_Adminhtml_Signoff_SignoffController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the sign-off
     *
     * @access protected
     * @return BS_Signoff_Model_Signoff
     */
    protected function _initSignoff()
    {
        $signoffId  = (int) $this->getRequest()->getParam('id');
        $signoff    = Mage::getModel('bs_signoff/signoff');
        if ($signoffId) {
            $signoff->load($signoffId);
        }
        Mage::register('current_signoff', $signoff);
        return $signoff;
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
        $this->_title(Mage::helper('bs_signoff')->__('AC Sign-off Check'))
             ->_title(Mage::helper('bs_signoff')->__('AC Sign-offs'));
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
     * edit sign-off - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $signoffId    = $this->getRequest()->getParam('id');
        $signoff      = $this->_initSignoff();
        if ($signoffId && !$signoff->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_signoff')->__('This sign-off no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSignoffData(true);
        if (!empty($data)) {
            $signoff->setData($data);
        }
        Mage::register('signoff_data', $signoff);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_signoff')->__('AC Sign-off Check'))
             ->_title(Mage::helper('bs_signoff')->__('AC Sign-offs'));
        if ($signoff->getId()) {
            $this->_title($signoff->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_signoff')->__('Add sign-off'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new sign-off action
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
     * save sign-off - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('signoff')) {
            try {
                $data = $this->_filterDates($data, ['report_date']);
                $signoff = $this->_initSignoff();

                $signoff->addData($data);
                $signoff->save();

                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_signoff')->__('AC Sign-off was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $signoff->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSignoffData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signoff')->__('There was a problem saving the sign-off.')
                );
                Mage::getSingleton('adminhtml/session')->setSignoffData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_signoff')->__('Unable to find sign-off to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete sign-off - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $signoff = Mage::getModel('bs_signoff/signoff');
                $signoff->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_signoff')->__('AC Sign-off was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signoff')->__('There was an error deleting sign-off.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_signoff')->__('Could not find sign-off to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete sign-off - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $signoffIds = $this->getRequest()->getParam('signoff');
        if (!is_array($signoffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_signoff')->__('Please select sign-offs to delete.')
            );
        } else {
            try {
                foreach ($signoffIds as $signoffId) {
                    $signoff = Mage::getModel('bs_signoff/signoff');
                    $signoff->setId($signoffId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_signoff')->__('Total of %d sign-offs were successfully deleted.', count($signoffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signoff')->__('There was an error deleting sign-offs.')
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
        $signoffIds = $this->getRequest()->getParam('signoff');
        if (!is_array($signoffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_signoff')->__('Please select sign-offs.')
            );
        } else {
            try {
                foreach ($signoffIds as $signoffId) {
                $signoff = Mage::getSingleton('bs_signoff/signoff')->load($signoffId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sign-offs were successfully updated.', count($signoffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signoff')->__('There was an error updating sign-offs.')
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
        $signoffIds = $this->getRequest()->getParam('signoff');
        if (!is_array($signoffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_signoff')->__('Please select sign-offs.')
            );
        } else {
            try {
                foreach ($signoffIds as $signoffId) {
                $signoff = Mage::getSingleton('bs_signoff/signoff')->load($signoffId)
                    ->setIr($this->getRequest()->getParam('flag_ir'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sign-offs were successfully updated.', count($signoffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signoff')->__('There was an error updating sign-offs.')
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
        $signoffIds = $this->getRequest()->getParam('signoff');
        if (!is_array($signoffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_signoff')->__('Please select sign-offs.')
            );
        } else {
            try {
                foreach ($signoffIds as $signoffId) {
                $signoff = Mage::getSingleton('bs_signoff/signoff')->load($signoffId)
                    ->setNcr($this->getRequest()->getParam('flag_ncr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sign-offs were successfully updated.', count($signoffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signoff')->__('There was an error updating sign-offs.')
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
        $signoffIds = $this->getRequest()->getParam('signoff');
        if (!is_array($signoffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_signoff')->__('Please select sign-offs.')
            );
        } else {
            try {
                foreach ($signoffIds as $signoffId) {
                $signoff = Mage::getSingleton('bs_signoff/signoff')->load($signoffId)
                    ->setQr($this->getRequest()->getParam('flag_qr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sign-offs were successfully updated.', count($signoffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signoff')->__('There was an error updating sign-offs.')
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
        $fileName   = 'signoff.csv';
        $content    = $this->getLayout()->createBlock('bs_signoff/adminhtml_signoff_grid')
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
        $fileName   = 'signoff.xls';
        $content    = $this->getLayout()->createBlock('bs_signoff/adminhtml_signoff_grid')
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
        $fileName   = 'signoff.xml';
        $content    = $this->getLayout()->createBlock('bs_signoff/adminhtml_signoff_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function irsAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.qr');
        $this->renderLayout();
    }

    public function qnsAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.qn');
        $this->renderLayout();
    }

    public function qnsGridAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.qn');
        $this->renderLayout();
    }

    public function carsAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.car');
        $this->renderLayout();
    }

    public function carsGridAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.car');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initSignoff();
        $this->loadLayout();
        $this->getLayout()->getBlock('signoff.edit.tab.drr');
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/signoff');
    }
}
