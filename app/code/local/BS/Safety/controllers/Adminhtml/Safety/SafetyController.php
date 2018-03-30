<?php
/**
 * BS_Safety extension
 * 
 * @category       BS
 * @package        BS_Safety
 * @copyright      Copyright (c) 2018
 */
/**
 * Safety Data admin controller
 *
 * @category    BS
 * @package     BS_Safety
 * @author Bui Phong
 */
class BS_Safety_Adminhtml_Safety_SafetyController extends BS_Safety_Controller_Adminhtml_Safety
{
    /**
     * init the safety data
     *
     * @access protected
     * @return BS_Safety_Model_Safety
     */
    protected function _initSafety()
    {
        $safetyId  = (int) $this->getRequest()->getParam('id');
        $safety    = Mage::getModel('bs_safety/safety');
        if ($safetyId) {
            $safety->load($safetyId);
        }
        Mage::register('current_safety', $safety);
        return $safety;
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
        $this->_title(Mage::helper('bs_safety')->__('SAFETY DATA'))
             ->_title(Mage::helper('bs_safety')->__('Safety Data'));
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
     * edit safety data - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $safetyId    = $this->getRequest()->getParam('id');
        $safety      = $this->_initSafety();
        if ($safetyId && !$safety->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_safety')->__('This safety data no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSafetyData(true);
        if (!empty($data)) {
            $safety->setData($data);
        }
        Mage::register('safety_data', $safety);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_safety')->__('SAFETY DATA'))
             ->_title(Mage::helper('bs_safety')->__('Safety Data'));
        if ($safety->getId()) {
            $this->_title($safety->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_safety')->__('Add safety data'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new safety data action
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
     * save safety data - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('safety')) {
            try {
                $data = $this->_filterDates($data, array('occur_date' ,'report_date' ,'due_date' ,'close_date'));
                $safety = $this->_initSafety();
                $safety->addData($data);
                $safety->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_safety')->__('Safety Data was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $safety->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSafetyData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_safety')->__('There was a problem saving the safety data.')
                );
                Mage::getSingleton('adminhtml/session')->setSafetyData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_safety')->__('Unable to find safety data to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete safety data - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $safety = Mage::getModel('bs_safety/safety');
                $safety->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_safety')->__('Safety Data was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_safety')->__('There was an error deleting safety data.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_safety')->__('Could not find safety data to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete safety data - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $safetyIds = $this->getRequest()->getParam('safety');
        if (!is_array($safetyIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_safety')->__('Please select safety data to delete.')
            );
        } else {
            try {
                foreach ($safetyIds as $safetyId) {
                    $safety = Mage::getModel('bs_safety/safety');
                    $safety->setId($safetyId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_safety')->__('Total of %d safety data were successfully deleted.', count($safetyIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_safety')->__('There was an error deleting safety data.')
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
        $safetyIds = $this->getRequest()->getParam('safety');
        if (!is_array($safetyIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_safety')->__('Please select safety data.')
            );
        } else {
            try {
                foreach ($safetyIds as $safetyId) {
                $safety = Mage::getSingleton('bs_safety/safety')->load($safetyId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d safety data were successfully updated.', count($safetyIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_safety')->__('There was an error updating safety data.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Type change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSafetyTypeAction()
    {
        $safetyIds = $this->getRequest()->getParam('safety');
        if (!is_array($safetyIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_safety')->__('Please select safety data.')
            );
        } else {
            try {
                foreach ($safetyIds as $safetyId) {
                $safety = Mage::getSingleton('bs_safety/safety')->load($safetyId)
                    ->setSafetyType($this->getRequest()->getParam('flag_safety_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d safety data were successfully updated.', count($safetyIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_safety')->__('There was an error updating safety data.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Status change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSafetyStatusAction()
    {
        $safetyIds = $this->getRequest()->getParam('safety');
        if (!is_array($safetyIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_safety')->__('Please select safety data.')
            );
        } else {
            try {
                foreach ($safetyIds as $safetyId) {
                $safety = Mage::getSingleton('bs_safety/safety')->load($safetyId)
                    ->setSafetyStatus($this->getRequest()->getParam('flag_safety_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d safety data were successfully updated.', count($safetyIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_safety')->__('There was an error updating safety data.')
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
        $fileName   = 'safety.csv';
        $content    = $this->getLayout()->createBlock('bs_safety/adminhtml_safety_grid')
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
        $fileName   = 'safety.xls';
        $content    = $this->getLayout()->createBlock('bs_safety/adminhtml_safety_grid')
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
        $fileName   = 'safety.xml';
        $content    = $this->getLayout()->createBlock('bs_safety/adminhtml_safety_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/safety');
    }
}
