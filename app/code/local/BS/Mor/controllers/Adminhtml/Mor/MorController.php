<?php
/**
 * BS_Mor extension
 * 
 * @category       BS
 * @package        BS_Mor
 * @copyright      Copyright (c) 2018
 */
/**
 * MOR admin controller
 *
 * @category    BS
 * @package     BS_Mor
 * @author Bui Phong
 */
class BS_Mor_Adminhtml_Mor_MorController extends BS_Mor_Controller_Adminhtml_Mor
{
    /**
     * init the mor
     *
     * @access protected
     * @return BS_Mor_Model_Mor
     */
    protected function _initMor()
    {
        $morId  = (int) $this->getRequest()->getParam('id');
        $mor    = Mage::getModel('bs_mor/mor');
        if ($morId) {
            $mor->load($morId);
        }
        Mage::register('current_mor', $mor);
        return $mor;
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
        $this->_title(Mage::helper('bs_mor')->__('MOR'))
             ->_title(Mage::helper('bs_mor')->__('MORs'));
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
     * edit mor - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $morId    = $this->getRequest()->getParam('id');
        $mor      = $this->_initMor();
        if ($morId && !$mor->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_mor')->__('This mor no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getMorData(true);
        if (!empty($data)) {
            $mor->setData($data);
        }
        Mage::register('mor_data', $mor);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_mor')->__('MOR'))
             ->_title(Mage::helper('bs_mor')->__('MORs'));
        if ($mor->getId()) {
            $this->_title($mor->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_mor')->__('Add mor'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new mor action
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
     * save mor - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('mor')) {
            try {
                $data = $this->_filterDates($data, ['report_date' ,'occur_date' ,'due_date' ,'close_date']);
                $mor = $this->_initMor();
                $mor->addData($data);
                $morSourceName = $this->_uploadAndGetName(
                    'mor_source',
                    Mage::helper('bs_mor/mor')->getFileBaseDir(),
                    $data
                );
                $mor->setData('mor_source', $morSourceName);
                $mor->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_mor')->__('MOR was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $mor->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['mor_source']['value'])) {
                    $data['mor_source'] = $data['mor_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setMorData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['mor_source']['value'])) {
                    $data['mor_source'] = $data['mor_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_mor')->__('There was a problem saving the mor.')
                );
                Mage::getSingleton('adminhtml/session')->setMorData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_mor')->__('Unable to find mor to save.')
        );
        $this->_redirect('*/*/');
    }


    /**
     * delete mor - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $mor = Mage::getModel('bs_mor/mor');
                $mor->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_mor')->__('MOR was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_mor')->__('There was an error deleting mor.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_mor')->__('Could not find mor to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete mor - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $morIds = $this->getRequest()->getParam('mor');
        if (!is_array($morIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_mor')->__('Please select mors to delete.')
            );
        } else {
            try {
                foreach ($morIds as $morId) {
                    $mor = Mage::getModel('bs_mor/mor');
                    $mor->setId($morId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_mor')->__('Total of %d mors were successfully deleted.', count($morIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_mor')->__('There was an error deleting mors.')
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
        $morIds = $this->getRequest()->getParam('mor');
        if (!is_array($morIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_mor')->__('Please select mors.')
            );
        } else {
            try {
                foreach ($morIds as $morId) {
                $mor = Mage::getSingleton('bs_mor/mor')->load($morId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d mors were successfully updated.', count($morIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_mor')->__('There was an error updating mors.')
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
    public function massMorTypeAction()
    {
        $morIds = $this->getRequest()->getParam('mor');
        if (!is_array($morIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_mor')->__('Please select mors.')
            );
        } else {
            try {
                foreach ($morIds as $morId) {
                $mor = Mage::getSingleton('bs_mor/mor')->load($morId)
                    ->setMorType($this->getRequest()->getParam('flag_mor_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d mors were successfully updated.', count($morIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_mor')->__('There was an error updating mors.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Filter change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massMorFilterAction()
    {
        $morIds = $this->getRequest()->getParam('mor');
        if (!is_array($morIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_mor')->__('Please select mors.')
            );
        } else {
            try {
                foreach ($morIds as $morId) {
                $mor = Mage::getSingleton('bs_mor/mor')->load($morId)
                    ->setMorFilter($this->getRequest()->getParam('flag_mor_filter'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d mors were successfully updated.', count($morIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_mor')->__('There was an error updating mors.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Report to Manufacturer change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massReportAction()
    {
        $morIds = $this->getRequest()->getParam('mor');
        if (!is_array($morIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_mor')->__('Please select mors.')
            );
        } else {
            try {
                foreach ($morIds as $morId) {
                $mor = Mage::getSingleton('bs_mor/mor')->load($morId)
                    ->setReport($this->getRequest()->getParam('flag_report'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d mors were successfully updated.', count($morIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_mor')->__('There was an error updating mors.')
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
    public function massMorStatusAction()
    {
        $morIds = $this->getRequest()->getParam('mor');
        if (!is_array($morIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_mor')->__('Please select mors.')
            );
        } else {
            try {
                foreach ($morIds as $morId) {
                $mor = Mage::getSingleton('bs_mor/mor')->load($morId)
                    ->setMorStatus($this->getRequest()->getParam('flag_mor_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d mors were successfully updated.', count($morIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_mor')->__('There was an error updating mors.')
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
        $fileName   = 'mor.csv';
        $content    = $this->getLayout()->createBlock('bs_mor/adminhtml_mor_grid')
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
        $fileName   = 'mor.xls';
        $content    = $this->getLayout()->createBlock('bs_mor/adminhtml_mor_grid')
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
        $fileName   = 'mor.xml';
        $content    = $this->getLayout()->createBlock('bs_mor/adminhtml_mor_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/mor');
    }
}
