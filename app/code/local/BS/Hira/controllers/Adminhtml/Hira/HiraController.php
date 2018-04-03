<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * HIRA admin controller
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Adminhtml_Hira_HiraController extends BS_Hira_Controller_Adminhtml_Hira
{
    /**
     * init the hira
     *
     * @access protected
     * @return BS_Hira_Model_Hira
     */
    protected function _initHira()
    {
        $hiraId  = (int) $this->getRequest()->getParam('id');
        $hira    = Mage::getModel('bs_hira/hira');
        if ($hiraId) {
            $hira->load($hiraId);
        }
        Mage::register('current_hira', $hira);
        return $hira;
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
        $this->_title(Mage::helper('bs_hira')->__('HIRA'))
             ->_title(Mage::helper('bs_hira')->__('HIRAs'));
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
     * edit hira - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $hiraId    = $this->getRequest()->getParam('id');
        $hira      = $this->_initHira();
        if ($hiraId && !$hira->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_hira')->__('This hira no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getHiraData(true);
        if (!empty($data)) {
            $hira->setData($data);
        }
        Mage::register('hira_data', $hira);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_hira')->__('HIRA'))
             ->_title(Mage::helper('bs_hira')->__('HIRAs'));
        if ($hira->getId()) {
            $this->_title($hira->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_hira')->__('Add hira'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new hira action
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
     * save hira - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('hira')) {
            try {
                $data = $this->_filterDates($data, array('report_date' ,'due_date' ,'close_date'));
                $hira = $this->_initHira();
                $hira->addData($data);
                $hiraSourceName = $this->_uploadAndGetName(
                    'hira_source',
                    Mage::helper('bs_hira/hira')->getFileBaseDir(),
                    $data
                );
                $hira->setData('hira_source', $hiraSourceName);
                $hira->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hira')->__('HIRA was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $hira->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['hira_source']['value'])) {
                    $data['hira_source'] = $data['hira_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setHiraData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['hira_source']['value'])) {
                    $data['hira_source'] = $data['hira_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was a problem saving the hira.')
                );
                Mage::getSingleton('adminhtml/session')->setHiraData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_hira')->__('Unable to find hira to save.')
        );
        $this->_redirect('*/*/');
    }


    /**
     * delete hira - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $hira = Mage::getModel('bs_hira/hira');
                $hira->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hira')->__('HIRA was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error deleting hira.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_hira')->__('Could not find hira to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete hira - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $hiraIds = $this->getRequest()->getParam('hira');
        if (!is_array($hiraIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hira')->__('Please select hiras to delete.')
            );
        } else {
            try {
                foreach ($hiraIds as $hiraId) {
                    $hira = Mage::getModel('bs_hira/hira');
                    $hira->setId($hiraId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hira')->__('Total of %d hiras were successfully deleted.', count($hiraIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error deleting hiras.')
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
        $hiraIds = $this->getRequest()->getParam('hira');
        if (!is_array($hiraIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hira')->__('Please select hiras.')
            );
        } else {
            try {
                foreach ($hiraIds as $hiraId) {
                $hira = Mage::getSingleton('bs_hira/hira')->load($hiraId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d hiras were successfully updated.', count($hiraIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error updating hiras.')
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
    public function massHiraTypeAction()
    {
        $hiraIds = $this->getRequest()->getParam('hira');
        if (!is_array($hiraIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hira')->__('Please select hiras.')
            );
        } else {
            try {
                foreach ($hiraIds as $hiraId) {
                $hira = Mage::getSingleton('bs_hira/hira')->load($hiraId)
                    ->setHiraType($this->getRequest()->getParam('flag_hira_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d hiras were successfully updated.', count($hiraIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error updating hiras.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Probability of occurrent change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massProbabilityAction()
    {
        $hiraIds = $this->getRequest()->getParam('hira');
        if (!is_array($hiraIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hira')->__('Please select hiras.')
            );
        } else {
            try {
                foreach ($hiraIds as $hiraId) {
                $hira = Mage::getSingleton('bs_hira/hira')->load($hiraId)
                    ->setProbability($this->getRequest()->getParam('flag_probability'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d hiras were successfully updated.', count($hiraIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error updating hiras.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Severity of occurrent change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSeverityAction()
    {
        $hiraIds = $this->getRequest()->getParam('hira');
        if (!is_array($hiraIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hira')->__('Please select hiras.')
            );
        } else {
            try {
                foreach ($hiraIds as $hiraId) {
                $hira = Mage::getSingleton('bs_hira/hira')->load($hiraId)
                    ->setSeverity($this->getRequest()->getParam('flag_severity'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d hiras were successfully updated.', count($hiraIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error updating hiras.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Probability after mitigation change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massProbabilityAfterAction()
    {
        $hiraIds = $this->getRequest()->getParam('hira');
        if (!is_array($hiraIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hira')->__('Please select hiras.')
            );
        } else {
            try {
                foreach ($hiraIds as $hiraId) {
                $hira = Mage::getSingleton('bs_hira/hira')->load($hiraId)
                    ->setProbabilityAfter($this->getRequest()->getParam('flag_probability_after'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d hiras were successfully updated.', count($hiraIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error updating hiras.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Severity after mitigation change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSeverityAfterAction()
    {
        $hiraIds = $this->getRequest()->getParam('hira');
        if (!is_array($hiraIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hira')->__('Please select hiras.')
            );
        } else {
            try {
                foreach ($hiraIds as $hiraId) {
                $hira = Mage::getSingleton('bs_hira/hira')->load($hiraId)
                    ->setSeverityAfter($this->getRequest()->getParam('flag_severity_after'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d hiras were successfully updated.', count($hiraIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error updating hiras.')
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
    public function massHiraStatusAction()
    {
        $hiraIds = $this->getRequest()->getParam('hira');
        if (!is_array($hiraIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hira')->__('Please select hiras.')
            );
        } else {
            try {
                foreach ($hiraIds as $hiraId) {
                $hira = Mage::getSingleton('bs_hira/hira')->load($hiraId)
                    ->setHiraStatus($this->getRequest()->getParam('flag_hira_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d hiras were successfully updated.', count($hiraIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hira')->__('There was an error updating hiras.')
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
        $fileName   = 'hira.csv';
        $content    = $this->getLayout()->createBlock('bs_hira/adminhtml_hira_grid')
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
        $fileName   = 'hira.xls';
        $content    = $this->getLayout()->createBlock('bs_hira/adminhtml_hira_grid')
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
        $fileName   = 'hira.xml';
        $content    = $this->getLayout()->createBlock('bs_hira/adminhtml_hira_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/hira');
    }
}
