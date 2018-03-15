<?php
/**
 * BS_Logger extension
 * 
 * @category       BS
 * @package        BS_Logger
 * @copyright      Copyright (c) 2017
 */
/**
 * Logger admin controller
 *
 * @category    BS
 * @package     BS_Logger
 * @author Bui Phong
 */
class BS_Logger_Adminhtml_Logger_LoggerController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the logger
     *
     * @access protected
     * @return BS_Logger_Model_Logger
     */
    protected function _initLogger()
    {
        $loggerId  = (int) $this->getRequest()->getParam('id');
        $logger    = Mage::getModel('bs_logger/logger');
        if ($loggerId) {
            $logger->load($loggerId);
        }
        Mage::register('current_logger', $logger);
        return $logger;
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
        $this->_title(Mage::helper('bs_logger')->__('Admin Logger'))
             ->_title(Mage::helper('bs_logger')->__('Loggers'));
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
     * edit logger - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $loggerId    = $this->getRequest()->getParam('id');
        $logger      = $this->_initLogger();
        if ($loggerId && !$logger->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_logger')->__('This logger no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getLoggerData(true);
        if (!empty($data)) {
            $logger->setData($data);
        }
        Mage::register('logger_data', $logger);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_logger')->__('Admin Logger'))
             ->_title(Mage::helper('bs_logger')->__('Loggers'));
        if ($logger->getId()) {
            $this->_title($logger->getUserId());
        } else {
            $this->_title(Mage::helper('bs_logger')->__('Add logger'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new logger action
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
     * save logger - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('logger')) {
            try {
                $logger = $this->_initLogger();
                $logger->addData($data);
                $logger->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_logger')->__('Logger was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $logger->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setLoggerData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_logger')->__('There was a problem saving the logger.')
                );
                Mage::getSingleton('adminhtml/session')->setLoggerData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_logger')->__('Unable to find logger to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete logger - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $logger = Mage::getModel('bs_logger/logger');
                $logger->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_logger')->__('Logger was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_logger')->__('There was an error deleting logger.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_logger')->__('Could not find logger to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete logger - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $loggerIds = $this->getRequest()->getParam('logger');
        if (!is_array($loggerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_logger')->__('Please select loggers to delete.')
            );
        } else {
            try {
                foreach ($loggerIds as $loggerId) {
                    $logger = Mage::getModel('bs_logger/logger');
                    $logger->setId($loggerId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_logger')->__('Total of %d loggers were successfully deleted.', count($loggerIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_logger')->__('There was an error deleting loggers.')
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
        $loggerIds = $this->getRequest()->getParam('logger');
        if (!is_array($loggerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_logger')->__('Please select loggers.')
            );
        } else {
            try {
                foreach ($loggerIds as $loggerId) {
                $logger = Mage::getSingleton('bs_logger/logger')->load($loggerId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d loggers were successfully updated.', count($loggerIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_logger')->__('There was an error updating loggers.')
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
        $fileName   = 'logger.csv';
        $content    = $this->getLayout()->createBlock('bs_logger/adminhtml_logger_grid')
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
        $fileName   = 'logger.xls';
        $content    = $this->getLayout()->createBlock('bs_logger/adminhtml_logger_grid')
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
        $fileName   = 'logger.xml';
        $content    = $this->getLayout()->createBlock('bs_logger/adminhtml_logger_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('system/logger');
    }
}
