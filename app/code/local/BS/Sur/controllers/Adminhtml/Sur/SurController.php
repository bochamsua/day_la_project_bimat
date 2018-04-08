<?php
/**
 * BS_Sur extension
 * 
 * @category       BS
 * @package        BS_Sur
 * @copyright      Copyright (c) 2017
 */
/**
 * Surveillance admin controller
 *
 * @category    BS
 * @package     BS_Sur
 * @author Bui Phong
 */
class BS_Sur_Adminhtml_Sur_SurController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the surveillance
     *
     * @access protected
     * @return BS_Sur_Model_Sur
     */
    protected function _initSur()
    {
        $surId  = (int) $this->getRequest()->getParam('id');
        $sur    = Mage::getModel('bs_sur/sur');
        if ($surId) {
            $sur->load($surId);
        }
        Mage::register('current_sur', $sur);
        return $sur;
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
        $this->_title(Mage::helper('bs_sur')->__('Surveillance'))
             ->_title(Mage::helper('bs_sur')->__('Surveillances'));
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
     * edit surveillance - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $surId    = $this->getRequest()->getParam('id');
        $sur      = $this->_initSur();
        if ($surId && !$sur->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_sur')->__('This surveillance no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSurData(true);
        if (!empty($data)) {
            $sur->setData($data);
        }
        Mage::register('sur_data', $sur);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_sur')->__('Surveillance'))
             ->_title(Mage::helper('bs_sur')->__('Surveillances'));
        if ($sur->getId()) {
            $this->_title($sur->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_sur')->__('Add surveillance'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new surveillance action
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
     * save surveillance - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('sur')) {
            try {
                $data = $this->_filterDates($data, ['report_date']);

                //check date
                $currentDate = Mage::helper('bs_misc/date')->getNowStoreDate();
                $inputDate = $data['report_date'];

                $currentDateArray = [
                  'date' => $currentDate
                ];

                $inputDateArray = [
                  'date' => $inputDate
                ];

                $inputDate7Array = [
                    'date' => $inputDate,
                    'plus'  => 7
                ];

                $check1 = Mage::helper('bs_misc/date')->compareDate($currentDateArray, $inputDateArray, '<');
                $check2 = Mage::helper('bs_misc/date')->compareDate($inputDate7Array, $currentDateArray, '<=');
                if($check1){//if report date > current date --> fake!!!
                    Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('bs_sur')->__('Please check report date!')
                    );

                    if($id = $this->getRequest()->getParam('id')){
                        $this->_redirect('*/*/edit', ['id' => $id]);
                        return;
                    }
                    $this->_redirect('*/*/new');
                    return;
                }

                if($check2){
                    $data['record_status'] = 1;
                }else {
                    $data['record_status'] = 0;
                }




                if($data['description'] == ""){
                    Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('bs_sur')->__('Please enter description!')
                    );

                    //Mage::getSingleton('adminhtml/session')->setSurData($data);
                    $this->_redirect('*/*/new');
                    return;
                }
                $sur = $this->_initSur();

                $sur->addData($data);

                $surSourceName = $this->_uploadAndGetName(
                    'sur_source',
                    Mage::helper('bs_sur/sur')->getFileBaseDir(),
                    $data
                );
                $sur->setData('sur_source', $surSourceName);

                $sur->save();

                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_sur')->__('Surveillance was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $sur->getId()]);
                    return;
                }
                $this->_redirect('*/*/edit', ['id' => $sur->getId()]);
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSurData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was a problem saving the surveillance.')
                );
                Mage::getSingleton('adminhtml/session')->setSurData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_sur')->__('Unable to find surveillance to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete surveillance - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $sur = Mage::getModel('bs_sur/sur');
                $sur->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_sur')->__('Surveillance was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error deleting surveillance.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_sur')->__('Could not find surveillance to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete surveillance - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances to delete.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                    $sur = Mage::getModel('bs_sur/sur');
                    $sur->setId($surId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_sur')->__('Total of %d surveillances were successfully deleted.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error deleting surveillances.')
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
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                $sur = Mage::getSingleton('bs_sur/sur')->load($surId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d surveillances were successfully updated.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error updating surveillances.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Region change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massRegionAction()
    {
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                $sur = Mage::getSingleton('bs_sur/sur')->load($surId)
                    ->setRegion($this->getRequest()->getParam('flag_region'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d surveillances were successfully updated.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error updating surveillances.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Section change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSectionAction()
    {
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                $sur = Mage::getSingleton('bs_sur/sur')->load($surId)
                    ->setSection($this->getRequest()->getParam('flag_section'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d surveillances were successfully updated.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error updating surveillances.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass NCR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massNcrAction()
    {
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                $sur = Mage::getSingleton('bs_sur/sur')->load($surId)
                    ->setNcr($this->getRequest()->getParam('flag_ncr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d surveillances were successfully updated.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error updating surveillances.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass QR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massQrAction()
    {
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                $sur = Mage::getSingleton('bs_sur/sur')->load($surId)
                    ->setQr($this->getRequest()->getParam('flag_qr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d surveillances were successfully updated.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error updating surveillances.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass DRR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDrrAction()
    {
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                $sur = Mage::getSingleton('bs_sur/sur')->load($surId)
                    ->setDrr($this->getRequest()->getParam('flag_drr'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d surveillances were successfully updated.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error updating surveillances.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass CAR change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massCarAction()
    {
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                $sur = Mage::getSingleton('bs_sur/sur')->load($surId)
                    ->setCar($this->getRequest()->getParam('flag_car'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d surveillances were successfully updated.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error updating surveillances.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass QN change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massQnAction()
    {
        $surIds = $this->getRequest()->getParam('sur');
        if (!is_array($surIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sur')->__('Please select surveillances.')
            );
        } else {
            try {
                foreach ($surIds as $surId) {
                $sur = Mage::getSingleton('bs_sur/sur')->load($surId)
                    ->setQn($this->getRequest()->getParam('flag_qn'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d surveillances were successfully updated.', count($surIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sur')->__('There was an error updating surveillances.')
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
        $fileName   = 'sur.csv';
        $content    = $this->getLayout()->createBlock('bs_sur/adminhtml_sur_grid')
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
        $fileName   = 'sur.xls';
        $content    = $this->getLayout()->createBlock('bs_sur/adminhtml_sur_grid')
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
        $fileName   = 'sur.xml';
        $content    = $this->getLayout()->createBlock('bs_sur/adminhtml_sur_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function irsAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.qr');
        $this->renderLayout();
    }

    public function qnsAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.qn');
        $this->renderLayout();
    }

    public function qnsGridAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.qn');
        $this->renderLayout();
    }

    public function carsAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.car');
        $this->renderLayout();
    }

    public function carsGridAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.car');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initSur();
        $this->loadLayout();
        $this->getLayout()->getBlock('sur.edit.tab.drr');
        $this->renderLayout();
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/sur');
    }
}
