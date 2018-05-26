<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Export admin controller
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
class BS_Imex_Adminhtml_Imex_ExController extends BS_Imex_Controller_Adminhtml_Imex
{
    /**
     * init the export
     *
     * @access protected
     * @return BS_Imex_Model_Ex
     */
    protected function _initEx()
    {
        $exId  = (int) $this->getRequest()->getParam('id');
        $ex    = Mage::getModel('bs_imex/ex');
        if ($exId) {
            $ex->load($exId);
        }
        Mage::register('current_ex', $ex);
        return $ex;
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
        $this->_title(Mage::helper('bs_imex')->__('Import Export'))
             ->_title(Mage::helper('bs_imex')->__('Exports'));
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
     * edit export - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $exId    = $this->getRequest()->getParam('id');
        $ex      = $this->_initEx();
        if ($exId && !$ex->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_imex')->__('This export no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getExData(true);
        if (!empty($data)) {
            $ex->setData($data);
        }
        Mage::register('ex_data', $ex);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_imex')->__('Import Export'))
             ->_title(Mage::helper('bs_imex')->__('Exports'));
        if ($ex->getId()) {
            $this->_title($ex->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_imex')->__('Add export'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new export action
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
     * save export - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('ex')) {
            try {
                $data = $this->_filterDates($data, array('ex_date'));
                $ex = $this->_initEx();
                $ex->addData($data);
                $exSourceName = $this->_uploadAndGetName(
                    'ex_source',
                    Mage::helper('bs_imex/ex')->getFileBaseDir(),
                    $data
                );
                $ex->setData('ex_source', $exSourceName);
                $ex->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_imex')->__('Export was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $ex->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['ex_source']['value'])) {
                    $data['ex_source'] = $data['ex_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setExData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['ex_source']['value'])) {
                    $data['ex_source'] = $data['ex_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_imex')->__('There was a problem saving the export.')
                );
                Mage::getSingleton('adminhtml/session')->setExData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_imex')->__('Unable to find export to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete export - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $ex = Mage::getModel('bs_imex/ex');
                $ex->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_imex')->__('Export was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_imex')->__('There was an error deleting export.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_imex')->__('Could not find export to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete export - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $exIds = $this->getRequest()->getParam('ex');
        if (!is_array($exIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_imex')->__('Please select exports to delete.')
            );
        } else {
            try {
                foreach ($exIds as $exId) {
                    $ex = Mage::getModel('bs_imex/ex');
                    $ex->setId($exId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_imex')->__('Total of %d exports were successfully deleted.', count($exIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_imex')->__('There was an error deleting exports.')
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
        $exIds = $this->getRequest()->getParam('ex');
        if (!is_array($exIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_imex')->__('Please select exports.')
            );
        } else {
            try {
                foreach ($exIds as $exId) {
                $ex = Mage::getSingleton('bs_imex/ex')->load($exId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d exports were successfully updated.', count($exIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_imex')->__('There was an error updating exports.')
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
    public function massExTypeAction()
    {
        $exIds = $this->getRequest()->getParam('ex');
        if (!is_array($exIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_imex')->__('Please select exports.')
            );
        } else {
            try {
                foreach ($exIds as $exId) {
                $ex = Mage::getSingleton('bs_imex/ex')->load($exId)
                    ->setExType($this->getRequest()->getParam('flag_ex_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d exports were successfully updated.', count($exIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_imex')->__('There was an error updating exports.')
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
        $fileName   = 'ex.csv';
        $content    = $this->getLayout()->createBlock('bs_imex/adminhtml_ex_grid')
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
        $fileName   = 'ex.xls';
        $content    = $this->getLayout()->createBlock('bs_imex/adminhtml_ex_grid')
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
        $fileName   = 'ex.xml';
        $content    = $this->getLayout()->createBlock('bs_imex/adminhtml_ex_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('system/bs_imex/ex');
    }
}
