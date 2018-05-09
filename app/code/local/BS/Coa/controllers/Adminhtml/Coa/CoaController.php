<?php
/**
 * BS_Coa extension
 * 
 * @category       BS
 * @package        BS_Coa
 * @copyright      Copyright (c) 2018
 */
/**
 * Corrective Action admin controller
 *
 * @category    BS
 * @package     BS_Coa
 * @author Bui Phong
 */
class BS_Coa_Adminhtml_Coa_CoaController extends BS_Coa_Controller_Adminhtml_Coa
{
    /**
     * init the corrective action
     *
     * @access protected
     * @return BS_Coa_Model_Coa
     */
    protected function _initCoa()
    {
        $coaId  = (int) $this->getRequest()->getParam('id');
        $coa    = Mage::getModel('bs_coa/coa');
        if ($coaId) {
            $coa->load($coaId);
        }
        Mage::register('current_coa', $coa);
        return $coa;
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
        $this->_title(Mage::helper('bs_coa')->__('Corrective Action'))
             ->_title(Mage::helper('bs_coa')->__('Corrective Actions'));
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
     * edit corrective action - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $coaId    = $this->getRequest()->getParam('id');
        $coa      = $this->_initCoa();
        if ($coaId && !$coa->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_coa')->__('This corrective action no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCoaData(true);
        if (!empty($data)) {
            $coa->setData($data);
        }
        Mage::register('coa_data', $coa);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_coa')->__('Corrective Action'))
             ->_title(Mage::helper('bs_coa')->__('Corrective Actions'));
        if ($coa->getId()) {
            $this->_title($coa->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_coa')->__('Add corrective action'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new corrective action action
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
     * save corrective action - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('coa')) {
            try {
                $data = $this->_filterDates($data, array('report_date' ,'due_date' ,'close_date'));
                $coa = $this->_initCoa();
                $coa->addData($data);
                $coaSourceName = $this->_uploadAndGetName(
                    'coa_source',
                    Mage::helper('bs_coa/coa')->getFileBaseDir(),
                    $data
                );
                $coa->setData('coa_source', $coaSourceName);
                $coa->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    //$add = '<script>window.opener.location.reload(); window.close()</script>';
                    $add = "<script>doPopup('".$coa->getRefType()."','coa',".$coa->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_coa')->__('Corrective Action was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $coa->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['coa_source']['value'])) {
                    $data['coa_source'] = $data['coa_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCoaData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['coa_source']['value'])) {
                    $data['coa_source'] = $data['coa_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_coa')->__('There was a problem saving the corrective action.')
                );
                Mage::getSingleton('adminhtml/session')->setCoaData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_coa')->__('Unable to find corrective action to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete corrective action - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $coa = Mage::getModel('bs_coa/coa');
                $coa->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_coa')->__('Corrective Action was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_coa')->__('There was an error deleting corrective action.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_coa')->__('Could not find corrective action to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete corrective action - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $coaIds = $this->getRequest()->getParam('coa');
        if (!is_array($coaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_coa')->__('Please select corrective actions to delete.')
            );
        } else {
            try {
                foreach ($coaIds as $coaId) {
                    $coa = Mage::getModel('bs_coa/coa');
                    $coa->setId($coaId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_coa')->__('Total of %d corrective actions were successfully deleted.', count($coaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_coa')->__('There was an error deleting corrective actions.')
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
        $coaIds = $this->getRequest()->getParam('coa');
        if (!is_array($coaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_coa')->__('Please select corrective actions.')
            );
        } else {
            try {
                foreach ($coaIds as $coaId) {
                $coa = Mage::getSingleton('bs_coa/coa')->load($coaId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d corrective actions were successfully updated.', count($coaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_coa')->__('There was an error updating corrective actions.')
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
    public function massCoaStatusAction()
    {
        $coaIds = $this->getRequest()->getParam('coa');
        if (!is_array($coaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_coa')->__('Please select corrective actions.')
            );
        } else {
            try {
                foreach ($coaIds as $coaId) {
                $coa = Mage::getSingleton('bs_coa/coa')->load($coaId)
                    ->setCoaStatus($this->getRequest()->getParam('flag_coa_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d corrective actions were successfully updated.', count($coaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_coa')->__('There was an error updating corrective actions.')
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
        $fileName   = 'coa.csv';
        $content    = $this->getLayout()->createBlock('bs_coa/adminhtml_coa_grid')
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
        $fileName   = 'coa.xls';
        $content    = $this->getLayout()->createBlock('bs_coa/adminhtml_coa_grid')
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
        $fileName   = 'coa.xml';
        $content    = $this->getLayout()->createBlock('bs_coa/adminhtml_coa_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/coa');
    }
}
