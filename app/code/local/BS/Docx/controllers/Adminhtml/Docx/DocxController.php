<?php
/**
 * BS_Docx extension
 * 
 * @category       BS
 * @package        BS_Docx
 * @copyright      Copyright (c) 2016
 */
/**
 * Docx admin controller
 *
 * @category    BS
 * @package     BS_Docx
 * @author Bui Phong
 */
class BS_Docx_Adminhtml_Docx_DocxController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the docx
     *
     * @access protected
     * @return BS_Docx_Model_Docx
     */
    protected function _initDocx()
    {
        $docxId  = (int) $this->getRequest()->getParam('id');
        $docx    = Mage::getModel('bs_docx/docx');
        if ($docxId) {
            $docx->load($docxId);
        }
        Mage::register('current_docx', $docx);
        return $docx;
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
        $this->_title(Mage::helper('bs_docx')->__('Docx'))
             ->_title(Mage::helper('bs_docx')->__('Docx'));
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
     * edit docx - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $docxId    = $this->getRequest()->getParam('id');
        $docx      = $this->_initDocx();
        if ($docxId && !$docx->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_docx')->__('This docx no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getDocxData(true);
        if (!empty($data)) {
            $docx->setData($data);
        }
        Mage::register('docx_data', $docx);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_docx')->__('Docx'))
             ->_title(Mage::helper('bs_docx')->__('Docx'));
        if ($docx->getId()) {
            $this->_title($docx->getName());
        } else {
            $this->_title(Mage::helper('bs_docx')->__('Add docx'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new docx action
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
     * save docx - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('docx')) {
            try {
                $docx = $this->_initDocx();
                $docx->addData($data);
                $docx->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_docx')->__('Docx was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $docx->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setDocxData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_docx')->__('There was a problem saving the docx.')
                );
                Mage::getSingleton('adminhtml/session')->setDocxData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_docx')->__('Unable to find docx to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete docx - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $docx = Mage::getModel('bs_docx/docx');
                $docx->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_docx')->__('Docx was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_docx')->__('There was an error deleting docx.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_docx')->__('Could not find docx to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete docx - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $docxIds = $this->getRequest()->getParam('docx');
        if (!is_array($docxIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_docx')->__('Please select docx to delete.')
            );
        } else {
            try {
                foreach ($docxIds as $docxId) {
                    $docx = Mage::getModel('bs_docx/docx');
                    $docx->setId($docxId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_docx')->__('Total of %d docx were successfully deleted.', count($docxIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_docx')->__('There was an error deleting docx.')
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
        $docxIds = $this->getRequest()->getParam('docx');
        if (!is_array($docxIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_docx')->__('Please select docx.')
            );
        } else {
            try {
                foreach ($docxIds as $docxId) {
                $docx = Mage::getSingleton('bs_docx/docx')->load($docxId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d docx were successfully updated.', count($docxIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_docx')->__('There was an error updating docx.')
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
        $fileName   = 'docx.csv';
        $content    = $this->getLayout()->createBlock('bs_docx/adminhtml_docx_grid')
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
        $fileName   = 'docx.xls';
        $content    = $this->getLayout()->createBlock('bs_docx/adminhtml_docx_grid')
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
        $fileName   = 'docx.xml';
        $content    = $this->getLayout()->createBlock('bs_docx/adminhtml_docx_grid')
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
        return true;
    }
}
