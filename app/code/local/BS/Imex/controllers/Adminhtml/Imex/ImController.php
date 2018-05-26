<?php
/**
 * BS_Imex extension
 * 
 * @category       BS
 * @package        BS_Imex
 * @copyright      Copyright (c) 2018
 */
/**
 * Import admin controller
 *
 * @category    BS
 * @package     BS_Imex
 * @author Bui Phong
 */
class BS_Imex_Adminhtml_Imex_ImController extends BS_Imex_Controller_Adminhtml_Imex
{
    /**
     * init the import
     *
     * @access protected
     * @return BS_Imex_Model_Im
     */
    protected function _initIm()
    {
        $imId  = (int) $this->getRequest()->getParam('id');
        $im    = Mage::getModel('bs_imex/im');
        if ($imId) {
            $im->load($imId);
        }
        Mage::register('current_im', $im);
        return $im;
    }

    protected function _initAction()
    {
        $this->_title($this->__('Import/Export'))
            ->loadLayout()
            ->_setActiveMenu('system/bs_imex');

        return $this;
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
        $maxUploadSize = Mage::helper('bs_imex')->getMaxUploadSize();
        $this->_getSession()->addNotice(
            $this->__('Total size of uploadable files must not exceed %s', $maxUploadSize)
        );
        $this->_initAction()
            ->_title($this->__('Import'))
            ->_addBreadcrumb($this->__('Import'), $this->__('Import'));

        $this->renderLayout();
    }



    /**
     * Validate uploaded files action.
     *
     * @return void
     */
    public function startAction()
    {
        $data = $this->getRequest()->getPost();
        if ($data) {
            $this->loadLayout(false);
            /** @var $resultBlock Mage_ImportExport_Block_Adminhtml_Import_Frame_Result */
            $resultBlock = $this->getLayout()->getBlock('import.frame.result');
            // common actions
            $resultBlock->addAction('show', 'import_validation_container')
                ->addAction('clear', array(
                        'im_source',
                        )
                );

            try {
                /** @var $import Mage_ImportExport_Model_Import */
                $import = Mage::getModel('bs_imex/im');
                $res = $import->setData($data)->doImport();
                //$validationResult = $import->validateSource($import->setData($data)->uploadSource());

                if($res){
                    $resultBlock->addSuccess(
                        $this->__('%s rows are successfully imported.', $res)
                    );
                }



                /*if (!$import->getProcessedRowsCount()) {
                    $resultBlock->addError($this->__('File does not contain data. Please upload another one'));
                } else {
                    if (!$validationResult) {
                        if ($import->getProcessedRowsCount() == $import->getInvalidRowsCount()) {
                            $resultBlock->addNotice(
                                $this->__('File is totally invalid. Please fix errors and re-upload file')
                            );
                        } elseif ($import->getErrorsCount() >= $import->getErrorsLimit()) {
                            $resultBlock->addNotice(
                                $this->__('Errors limit (%d) reached. Please fix errors and re-upload file', $import->getErrorsLimit())
                            );
                        } else {
                            if ($import->isImportAllowed()) {
                                $resultBlock->addNotice(
                                    $this->__('Please fix errors and re-upload file or simply press "Import" button to skip rows with errors'),
                                    true
                                );
                            } else {
                                $resultBlock->addNotice(
                                    $this->__('File is partially valid, but import is not possible'), false
                                );
                            }
                        }
                        // errors info
                        foreach ($import->getErrors() as $errorCode => $rows) {
                            $error = $errorCode . ' ' . $this->__('in rows:') . ' ' . implode(', ', $rows);
                            $resultBlock->addError($error);
                        }
                    } else {
                        if ($import->isImportAllowed()) {
                            $resultBlock->addSuccess(
                                $this->__('File is valid! To start import process press "Import" button'), true
                            );
                        } else {
                            $resultBlock->addError(
                                $this->__('File is valid, but import is not possible'), false
                            );
                        }
                    }
                    //$resultBlock->addNotice($import->getNotices());
                    //$resultBlock->addNotice($this->__('Checked rows: %d, checked entities: %d, invalid rows: %d, total errors: %d', $import->getProcessedRowsCount(), $import->getProcessedEntitiesCount(), $import->getInvalidRowsCount(), $import->getErrorsCount()));
                }*/
            } catch (Exception $e) {
                $resultBlock->addNotice($this->__('Please fix errors and re-upload file'))
                    ->addError($e->getMessage());
            }
            $this->renderLayout();
        } elseif ($this->getRequest()->isPost() && empty($_FILES)) {
            $this->loadLayout(false);
            $resultBlock = $this->getLayout()->getBlock('import.frame.result');
            $resultBlock->addError($this->__('File was not uploaded'));
            $this->renderLayout();
        } else {
            $this->_getSession()->addError($this->__('Data is invalid or file is not uploaded'));
            $this->_redirect('*/*/index');
        }
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
        return Mage::getSingleton('admin/session')->isAllowed('system/bs_imex/im');
    }
}
