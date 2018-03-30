<?php
/**
 * BS_Meda extension
 * 
 * @category       BS
 * @package        BS_Meda
 * @copyright      Copyright (c) 2018
 */
/**
 * MEDA admin controller
 *
 * @category    BS
 * @package     BS_Meda
 * @author Bui Phong
 */
class BS_Meda_Adminhtml_Meda_MedaController extends BS_Meda_Controller_Adminhtml_Meda
{
    /**
     * init the meda
     *
     * @access protected
     * @return BS_Meda_Model_Meda
     */
    protected function _initMeda()
    {
        $medaId  = (int) $this->getRequest()->getParam('id');
        $meda    = Mage::getModel('bs_meda/meda');
        if ($medaId) {
            $meda->load($medaId);
        }
        Mage::register('current_meda', $meda);
        return $meda;
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
        $this->_title(Mage::helper('bs_meda')->__('MEDA'))
             ->_title(Mage::helper('bs_meda')->__('MEDAs'));
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
     * edit meda - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $medaId    = $this->getRequest()->getParam('id');
        $meda      = $this->_initMeda();
        if ($medaId && !$meda->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_meda')->__('This meda no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getMedaData(true);
        if (!empty($data)) {
            $meda->setData($data);
        }
        Mage::register('meda_data', $meda);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_meda')->__('MEDA'))
             ->_title(Mage::helper('bs_meda')->__('MEDAs'));
        if ($meda->getId()) {
            $this->_title($meda->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_meda')->__('Add meda'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new meda action
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
     * save meda - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('meda')) {
            try {
                $data = $this->_filterDates($data, array('report_date' ,'event_date' ,'due_date' ,'close_date'));
                $meda = $this->_initMeda();
                $meda->addData($data);
                $meda->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_meda')->__('MEDA was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $meda->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setMedaData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_meda')->__('There was a problem saving the meda.')
                );
                Mage::getSingleton('adminhtml/session')->setMedaData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_meda')->__('Unable to find meda to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete meda - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $meda = Mage::getModel('bs_meda/meda');
                $meda->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_meda')->__('MEDA was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_meda')->__('There was an error deleting meda.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_meda')->__('Could not find meda to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete meda - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $medaIds = $this->getRequest()->getParam('meda');
        if (!is_array($medaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_meda')->__('Please select medas to delete.')
            );
        } else {
            try {
                foreach ($medaIds as $medaId) {
                    $meda = Mage::getModel('bs_meda/meda');
                    $meda->setId($medaId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_meda')->__('Total of %d medas were successfully deleted.', count($medaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_meda')->__('There was an error deleting medas.')
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
        $medaIds = $this->getRequest()->getParam('meda');
        if (!is_array($medaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_meda')->__('Please select medas.')
            );
        } else {
            try {
                foreach ($medaIds as $medaId) {
                $meda = Mage::getSingleton('bs_meda/meda')->load($medaId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d medas were successfully updated.', count($medaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_meda')->__('There was an error updating medas.')
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
    public function massMedaStatusAction()
    {
        $medaIds = $this->getRequest()->getParam('meda');
        if (!is_array($medaIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_meda')->__('Please select medas.')
            );
        } else {
            try {
                foreach ($medaIds as $medaId) {
                $meda = Mage::getSingleton('bs_meda/meda')->load($medaId)
                    ->setMedaStatus($this->getRequest()->getParam('flag_meda_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d medas were successfully updated.', count($medaIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_meda')->__('There was an error updating medas.')
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
        $fileName   = 'meda.csv';
        $content    = $this->getLayout()->createBlock('bs_meda/adminhtml_meda_grid')
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
        $fileName   = 'meda.xls';
        $content    = $this->getLayout()->createBlock('bs_meda/adminhtml_meda_grid')
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
        $fileName   = 'meda.xml';
        $content    = $this->getLayout()->createBlock('bs_meda/adminhtml_meda_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/meda');
    }
}
