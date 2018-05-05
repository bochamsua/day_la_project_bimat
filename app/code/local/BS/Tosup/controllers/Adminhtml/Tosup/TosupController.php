<?php
/**
 * BS_Tosup extension
 * 
 * @category       BS
 * @package        BS_Tosup
 * @copyright      Copyright (c) 2018
 */
/**
 * Tool Supplier admin controller
 *
 * @category    BS
 * @package     BS_Tosup
 * @author Bui Phong
 */
class BS_Tosup_Adminhtml_Tosup_TosupController extends BS_Tosup_Controller_Adminhtml_Tosup
{
    /**
     * init the tool supplier
     *
     * @access protected
     * @return BS_Tosup_Model_Tosup
     */
    protected function _initTosup()
    {
        $tosupId  = (int) $this->getRequest()->getParam('id');
        $tosup    = Mage::getModel('bs_tosup/tosup');
        if ($tosupId) {
            $tosup->load($tosupId);
        }
        Mage::register('current_tosup', $tosup);
        return $tosup;
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
        $this->_title(Mage::helper('bs_tosup')->__('Tool Supplier'))
             ->_title(Mage::helper('bs_tosup')->__('Tool Suppliers'));
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
     * edit tool supplier - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $tosupId    = $this->getRequest()->getParam('id');
        $tosup      = $this->_initTosup();
        if ($tosupId && !$tosup->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_tosup')->__('This tool supplier no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getTosupData(true);
        if (!empty($data)) {
            $tosup->setData($data);
        }
        Mage::register('tosup_data', $tosup);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_tosup')->__('Tool Supplier'))
             ->_title(Mage::helper('bs_tosup')->__('Tool Suppliers'));
        if ($tosup->getId()) {
            $this->_title($tosup->getTosupNo());
        } else {
            $this->_title(Mage::helper('bs_tosup')->__('Add tool supplier'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new tool supplier action
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
     * save tool supplier - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('tosup')) {
            try {
                $data = $this->_filterDates($data, array('issue_date' ,'expire_date'));
                $tosup = $this->_initTosup();
                $tosup->addData($data);
                $tosupSourceName = $this->_uploadAndGetName(
                    'tosup_source',
                    Mage::helper('bs_tosup/tosup')->getFileBaseDir(),
                    $data
                );
                $tosup->setData('tosup_source', $tosupSourceName);
                $tosup->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_tosup')->__('Tool Supplier was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $tosup->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['tosup_source']['value'])) {
                    $data['tosup_source'] = $data['tosup_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setTosupData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['tosup_source']['value'])) {
                    $data['tosup_source'] = $data['tosup_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_tosup')->__('There was a problem saving the tool supplier.')
                );
                Mage::getSingleton('adminhtml/session')->setTosupData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_tosup')->__('Unable to find tool supplier to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete tool supplier - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $tosup = Mage::getModel('bs_tosup/tosup');
                $tosup->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_tosup')->__('Tool Supplier was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_tosup')->__('There was an error deleting tool supplier.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_tosup')->__('Could not find tool supplier to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete tool supplier - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $tosupIds = $this->getRequest()->getParam('tosup');
        if (!is_array($tosupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_tosup')->__('Please select tool suppliers to delete.')
            );
        } else {
            try {
                foreach ($tosupIds as $tosupId) {
                    $tosup = Mage::getModel('bs_tosup/tosup');
                    $tosup->setId($tosupId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_tosup')->__('Total of %d tool suppliers were successfully deleted.', count($tosupIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_tosup')->__('There was an error deleting tool suppliers.')
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
        $tosupIds = $this->getRequest()->getParam('tosup');
        if (!is_array($tosupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_tosup')->__('Please select tool suppliers.')
            );
        } else {
            try {
                foreach ($tosupIds as $tosupId) {
                $tosup = Mage::getSingleton('bs_tosup/tosup')->load($tosupId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d tool suppliers were successfully updated.', count($tosupIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_tosup')->__('There was an error updating tool suppliers.')
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
    public function massSupStatusAction()
    {
        $tosupIds = $this->getRequest()->getParam('tosup');
        if (!is_array($tosupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_tosup')->__('Please select tool suppliers.')
            );
        } else {
            try {
                foreach ($tosupIds as $tosupId) {
                $tosup = Mage::getSingleton('bs_tosup/tosup')->load($tosupId)
                    ->setSupStatus($this->getRequest()->getParam('flag_sup_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d tool suppliers were successfully updated.', count($tosupIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_tosup')->__('There was an error updating tool suppliers.')
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
        $fileName   = 'tosup.csv';
        $content    = $this->getLayout()->createBlock('bs_tosup/adminhtml_tosup_grid')
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
        $fileName   = 'tosup.xls';
        $content    = $this->getLayout()->createBlock('bs_tosup/adminhtml_tosup_grid')
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
        $fileName   = 'tosup.xml';
        $content    = $this->getLayout()->createBlock('bs_tosup/adminhtml_tosup_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_data/tosup');
    }
}
