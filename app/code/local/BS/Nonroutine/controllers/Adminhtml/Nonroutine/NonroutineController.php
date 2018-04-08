<?php
/**
 * BS_Nonroutine extension
 * 
 * @category       BS
 * @package        BS_Nonroutine
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Work Non-Routine admin controller
 *
 * @category    BS
 * @package     BS_Nonroutine
 * @author Bui Phong
 */
class BS_Nonroutine_Adminhtml_Nonroutine_NonroutineController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the qc han work non-routine
     *
     * @access protected
     * @return BS_Nonroutine_Model_Nonroutine
     */
    protected function _initNonroutine()
    {
        $nonroutineId  = (int) $this->getRequest()->getParam('id');
        $nonroutine    = Mage::getModel('bs_nonroutine/nonroutine');
        if ($nonroutineId) {
            $nonroutine->load($nonroutineId);
        }
        Mage::register('current_nonroutine', $nonroutine);
        return $nonroutine;
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
        $this->_title(Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine'))
             ->_title(Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routines'));
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
     * edit qc han work non-routine - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $nonroutineId    = $this->getRequest()->getParam('id');
        $nonroutine      = $this->_initNonroutine();
        if ($nonroutineId && !$nonroutine->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_nonroutine')->__('This qc han work non-routine no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getNonroutineData(true);
        if (!empty($data)) {
            $nonroutine->setData($data);
        }
        Mage::register('nonroutine_data', $nonroutine);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine'))
             ->_title(Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routines'));
        if ($nonroutine->getId()) {
            $this->_title($nonroutine->getName());
        } else {
            $this->_title(Mage::helper('bs_nonroutine')->__('Add qc han work non-routine'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new qc han work non-routine action
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
     * save qc han work non-routine - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('nonroutine')) {
            try {
                $nonroutine = $this->_initNonroutine();
                $nonroutine->addData($data);
                $nonroutine->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $nonroutine->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setNonroutineData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nonroutine')->__('There was a problem saving the qc han work non-routine.')
                );
                Mage::getSingleton('adminhtml/session')->setNonroutineData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_nonroutine')->__('Unable to find qc han work non-routine to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete qc han work non-routine - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $nonroutine = Mage::getModel('bs_nonroutine/nonroutine');
                $nonroutine->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_nonroutine')->__('QC HAN Work Non-Routine was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nonroutine')->__('There was an error deleting qc han work non-routine.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_nonroutine')->__('Could not find qc han work non-routine to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete qc han work non-routine - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $nonroutineIds = $this->getRequest()->getParam('nonroutine');
        if (!is_array($nonroutineIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_nonroutine')->__('Please select qc han work non-routines to delete.')
            );
        } else {
            try {
                foreach ($nonroutineIds as $nonroutineId) {
                    $nonroutine = Mage::getModel('bs_nonroutine/nonroutine');
                    $nonroutine->setId($nonroutineId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_nonroutine')->__('Total of %d qc han work non-routines were successfully deleted.', count($nonroutineIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nonroutine')->__('There was an error deleting qc han work non-routines.')
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
        $nonroutineIds = $this->getRequest()->getParam('nonroutine');
        if (!is_array($nonroutineIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_nonroutine')->__('Please select qc han work non-routines.')
            );
        } else {
            try {
                foreach ($nonroutineIds as $nonroutineId) {
                $nonroutine = Mage::getSingleton('bs_nonroutine/nonroutine')->load($nonroutineId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d qc han work non-routines were successfully updated.', count($nonroutineIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nonroutine')->__('There was an error updating qc han work non-routines.')
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
        $fileName   = 'nonroutine.csv';
        $content    = $this->getLayout()->createBlock('bs_nonroutine/adminhtml_nonroutine_grid')
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
        $fileName   = 'nonroutine.xls';
        $content    = $this->getLayout()->createBlock('bs_nonroutine/adminhtml_nonroutine_grid')
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
        $fileName   = 'nonroutine.xml';
        $content    = $this->getLayout()->createBlock('bs_nonroutine/adminhtml_nonroutine_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_sched/nonroutine');
    }
}
