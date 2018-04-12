<?php
/**
 * BS_Nrw extension
 * 
 * @category       BS
 * @package        BS_Nrw
 * @copyright      Copyright (c) 2018
 */
/**
 * Non-routine Work admin controller
 *
 * @category    BS
 * @package     BS_Nrw
 * @author Bui Phong
 */
class BS_Nrw_Adminhtml_Nrw_NrwController extends BS_Nrw_Controller_Adminhtml_Nrw
{
    /**
     * init the non-routine work
     *
     * @access protected
     * @return BS_Nrw_Model_Nrw
     */
    protected function _initNrw()
    {
        $nrwId  = (int) $this->getRequest()->getParam('id');
        $nrw    = Mage::getModel('bs_nrw/nrw');
        if ($nrwId) {
            $nrw->load($nrwId);
        }
        Mage::register('current_nrw', $nrw);
        return $nrw;
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
        $this->_title(Mage::helper('bs_nrw')->__('Non-routine Work'))
             ->_title(Mage::helper('bs_nrw')->__('Non-routine Works'));
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
     * edit non-routine work - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $nrwId    = $this->getRequest()->getParam('id');
        $nrw      = $this->_initNrw();
        if ($nrwId && !$nrw->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_nrw')->__('This non-routine work no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getNrwData(true);
        if (!empty($data)) {
            $nrw->setData($data);
        }
        Mage::register('nrw_data', $nrw);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_nrw')->__('Non-routine Work'))
             ->_title(Mage::helper('bs_nrw')->__('Non-routine Works'));
        if ($nrw->getId()) {
            $this->_title($nrw->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_nrw')->__('Add non-routine work'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new non-routine work action
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
     * save non-routine work - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('nrw')) {
            try {
                $data = $this->_filterDates($data, array('report_date' ,'due_date' ,'close_date'));
                $nrw = $this->_initNrw();
                $nrw->addData($data);
                $nrwSourceName = $this->_uploadAndGetName(
                    'nrw_source',
                    Mage::helper('bs_nrw/nrw')->getFileBaseDir(),
                    $data
                );
                $nrw->setData('nrw_source', $nrwSourceName);
                $nrw->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_nrw')->__('Non-routine Work was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $nrw->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['nrw_source']['value'])) {
                    $data['nrw_source'] = $data['nrw_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setNrwData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['nrw_source']['value'])) {
                    $data['nrw_source'] = $data['nrw_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nrw')->__('There was a problem saving the non-routine work.')
                );
                Mage::getSingleton('adminhtml/session')->setNrwData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_nrw')->__('Unable to find non-routine work to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete non-routine work - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $nrw = Mage::getModel('bs_nrw/nrw');
                $nrw->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_nrw')->__('Non-routine Work was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nrw')->__('There was an error deleting non-routine work.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_nrw')->__('Could not find non-routine work to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete non-routine work - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $nrwIds = $this->getRequest()->getParam('nrw');
        if (!is_array($nrwIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_nrw')->__('Please select non-routine works to delete.')
            );
        } else {
            try {
                foreach ($nrwIds as $nrwId) {
                    $nrw = Mage::getModel('bs_nrw/nrw');
                    $nrw->setId($nrwId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_nrw')->__('Total of %d non-routine works were successfully deleted.', count($nrwIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nrw')->__('There was an error deleting non-routine works.')
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
        $nrwIds = $this->getRequest()->getParam('nrw');
        if (!is_array($nrwIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_nrw')->__('Please select non-routine works.')
            );
        } else {
            try {
                foreach ($nrwIds as $nrwId) {
                $nrw = Mage::getSingleton('bs_nrw/nrw')->load($nrwId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d non-routine works were successfully updated.', count($nrwIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nrw')->__('There was an error updating non-routine works.')
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
    public function massNrwTypeAction()
    {
        $nrwIds = $this->getRequest()->getParam('nrw');
        if (!is_array($nrwIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_nrw')->__('Please select non-routine works.')
            );
        } else {
            try {
                foreach ($nrwIds as $nrwId) {
                $nrw = Mage::getSingleton('bs_nrw/nrw')->load($nrwId)
                    ->setNrwType($this->getRequest()->getParam('flag_nrw_type'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d non-routine works were successfully updated.', count($nrwIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nrw')->__('There was an error updating non-routine works.')
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
    public function massNrwStatusAction()
    {
        $nrwIds = $this->getRequest()->getParam('nrw');
        if (!is_array($nrwIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_nrw')->__('Please select non-routine works.')
            );
        } else {
            try {
                foreach ($nrwIds as $nrwId) {
                $nrw = Mage::getSingleton('bs_nrw/nrw')->load($nrwId)
                    ->setNrwStatus($this->getRequest()->getParam('flag_nrw_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d non-routine works were successfully updated.', count($nrwIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_nrw')->__('There was an error updating non-routine works.')
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
        $fileName   = 'nrw.csv';
        $content    = $this->getLayout()->createBlock('bs_nrw/adminhtml_nrw_grid')
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
        $fileName   = 'nrw.xls';
        $content    = $this->getLayout()->createBlock('bs_nrw/adminhtml_nrw_grid')
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
        $fileName   = 'nrw.xml';
        $content    = $this->getLayout()->createBlock('bs_nrw/adminhtml_nrw_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function loadOngoingWorksAction(){
        $result = [];
        $staffId = $this->getRequest()->getPost('staff_id', false);

        $result['works'] = '';
        if($staffId){

            $collection = Mage::getModel('bs_nrw/nrw')
                ->getCollection()
                ->addFieldToFilter('staff_id', $staffId)
                ->addFieldToFilter('nrw_status', [
                    ['in' => [1]],
                    //['null' => true],
                ])
                ->setOrder('ref_no', 'DESC')

            ;

            if($collection->count()){
                $works = [];
                foreach ($collection as $item) {

                    $url = $this->getUrl("*/nrw_nrw/edit", ['id' =>$item->getId()]);
                    $works[] = $this->__('<a href="%s" target="_blank">%s</a>', $url, $item->getRefNo());
                }
                $result['works'] = 'Ongoing works ('.$collection->count().'): '.implode(", ", $works);
            }
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_sched/nrw');
    }
}
