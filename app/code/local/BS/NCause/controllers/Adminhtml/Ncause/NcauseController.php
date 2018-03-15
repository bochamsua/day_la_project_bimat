<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Cause admin controller
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Adminhtml_Ncause_NcauseController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the cause
     *
     * @access protected
     * @return BS_NCause_Model_Ncause
     */
    protected function _initNcause()
    {
        $ncauseId  = (int) $this->getRequest()->getParam('id');
        $ncause    = Mage::getModel('bs_ncause/ncause');
        if ($ncauseId) {
            $ncause->load($ncauseId);
        }
        Mage::register('current_ncause', $ncause);
        return $ncause;
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
        $this->_title(Mage::helper('bs_ncause')->__('Root Cause Sub Code'))
             ->_title(Mage::helper('bs_ncause')->__('Causes'));
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
     * edit cause - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $ncauseId    = $this->getRequest()->getParam('id');
        $ncause      = $this->_initNcause();
        if ($ncauseId && !$ncause->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_ncause')->__('This cause no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getNcauseData(true);
        if (!empty($data)) {
            $ncause->setData($data);
        }
        Mage::register('ncause_data', $ncause);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_ncause')->__('Root Cause Sub Code'))
             ->_title(Mage::helper('bs_ncause')->__('Causes'));
        if ($ncause->getId()) {
            $this->_title($ncause->getCauseCode());
        } else {
            $this->_title(Mage::helper('bs_ncause')->__('Add cause'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new cause action
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
     * save cause - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('ncause')) {
            try {
                $ncause = $this->_initNcause();
                $ncause->addData($data);
                $ncause->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncause')->__('Cause was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $ncause->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setNcauseData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was a problem saving the cause.')
                );
                Mage::getSingleton('adminhtml/session')->setNcauseData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_ncause')->__('Unable to find cause to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete cause - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $ncause = Mage::getModel('bs_ncause/ncause');
                $ncause->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncause')->__('Cause was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was an error deleting cause.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_ncause')->__('Could not find cause to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete cause - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $ncauseIds = $this->getRequest()->getParam('ncause');
        if (!is_array($ncauseIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncause')->__('Please select causes to delete.')
            );
        } else {
            try {
                foreach ($ncauseIds as $ncauseId) {
                    $ncause = Mage::getModel('bs_ncause/ncause');
                    $ncause->setId($ncauseId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncause')->__('Total of %d causes were successfully deleted.', count($ncauseIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was an error deleting causes.')
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
        $ncauseIds = $this->getRequest()->getParam('ncause');
        if (!is_array($ncauseIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncause')->__('Please select causes.')
            );
        } else {
            try {
                foreach ($ncauseIds as $ncauseId) {
                $ncause = Mage::getSingleton('bs_ncause/ncause')->load($ncauseId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d causes were successfully updated.', count($ncauseIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was an error updating causes.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass cause group change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massNcausegroupIdAction()
    {
        $ncauseIds = $this->getRequest()->getParam('ncause');
        if (!is_array($ncauseIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncause')->__('Please select causes.')
            );
        } else {
            try {
                foreach ($ncauseIds as $ncauseId) {
                $ncause = Mage::getSingleton('bs_ncause/ncause')->load($ncauseId)
                    ->setNcausegroupId($this->getRequest()->getParam('flag_ncausegroup_id'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d causes were successfully updated.', count($ncauseIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was an error updating causes.')
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
        $fileName   = 'ncause.csv';
        $content    = $this->getLayout()->createBlock('bs_ncause/adminhtml_ncause_grid')
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
        $fileName   = 'ncause.xls';
        $content    = $this->getLayout()->createBlock('bs_ncause/adminhtml_ncause_grid')
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
        $fileName   = 'ncause.xml';
        $content    = $this->getLayout()->createBlock('bs_ncause/adminhtml_ncause_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/ncause');
    }
}
