<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other Work admin controller
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
class BS_Other_Adminhtml_Other_OtherController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the other task
     *
     * @access protected
     * @return BS_Other_Model_Other
     */
    protected function _initOther()
    {
        $otherId  = (int) $this->getRequest()->getParam('id');
        $other    = Mage::getModel('bs_other/other');
        if ($otherId) {
            $other->load($otherId);
        }
        Mage::register('current_other', $other);
        return $other;
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
        $this->_title(Mage::helper('bs_other')->__('Other'))
             ->_title(Mage::helper('bs_other')->__('Other Works'));
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
     * edit other task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $otherId    = $this->getRequest()->getParam('id');
        $other      = $this->_initOther();
        if ($otherId && !$other->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_other')->__('This other task no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getOtherData(true);
        if (!empty($data)) {
            $other->setData($data);
        }
        Mage::register('other_data', $other);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_other')->__('Other'))
             ->_title(Mage::helper('bs_other')->__('Other Works'));
        if ($other->getId()) {
            $this->_title($other->getRefNo());
        } else {
            $this->_title(Mage::helper('bs_other')->__('Add other task'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new other task action
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
     * save other task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('other')) {
            try {
                $data = $this->_filterDates($data, array('report_date'));
                $other = $this->_initOther();


                $other->addData($data);
                $other->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = "<script>doPopup('".$other->getRefType()."','other',".$other->getCount().")</script>";
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_other')->__('Other Work was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $other->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setOtherData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_other')->__('There was a problem saving the other task.')
                );
                Mage::getSingleton('adminhtml/session')->setOtherData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_other')->__('Unable to find other task to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete other task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $other = Mage::getModel('bs_other/other');
                $other->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_other')->__('Other Work was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_other')->__('There was an error deleting other task.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_other')->__('Could not find other task to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete other task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $otherIds = $this->getRequest()->getParam('other');
        if (!is_array($otherIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_other')->__('Please select other tasks to delete.')
            );
        } else {
            try {
                foreach ($otherIds as $otherId) {
                    $other = Mage::getModel('bs_other/other');
                    $other->setId($otherId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_other')->__('Total of %d other tasks were successfully deleted.', count($otherIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_other')->__('There was an error deleting other tasks.')
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
        $otherIds = $this->getRequest()->getParam('other');
        if (!is_array($otherIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_other')->__('Please select other tasks.')
            );
        } else {
            try {
                foreach ($otherIds as $otherId) {
                $other = Mage::getSingleton('bs_other/other')->load($otherId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d other tasks were successfully updated.', count($otherIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_other')->__('There was an error updating other tasks.')
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
        $fileName   = 'other.csv';
        $content    = $this->getLayout()->createBlock('bs_other/adminhtml_other_grid')
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
        $fileName   = 'other.xls';
        $content    = $this->getLayout()->createBlock('bs_other/adminhtml_other_grid')
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
        $fileName   = 'other.xml';
        $content    = $this->getLayout()->createBlock('bs_other/adminhtml_other_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }


    public function irsAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.ir');
        $this->renderLayout();
    }

    public function irsGridAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.ir');
        $this->renderLayout();
    }

    public function ncrsAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.ncr');
        $this->renderLayout();
    }

    public function ncrsGridAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.ncr');
        $this->renderLayout();
    }

    public function qrsAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.qr');
        $this->renderLayout();
    }

    public function qrsGridAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.qr');
        $this->renderLayout();
    }

    public function qnsAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.qn');
        $this->renderLayout();
    }

    public function qnsGridAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.qn');
        $this->renderLayout();
    }

    public function carsAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.car');
        $this->renderLayout();
    }

    public function carsGridAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.car');
        $this->renderLayout();
    }

    public function drrsAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.drr');
        $this->renderLayout();
    }

    public function drrsGridAction()
    {
        $this->_initOther();
        $this->loadLayout();
        $this->getLayout()->getBlock('other.edit.tab.drr');
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_work/other');
    }
}
