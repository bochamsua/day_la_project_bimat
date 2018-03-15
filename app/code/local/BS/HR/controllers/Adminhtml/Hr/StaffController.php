<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2017
 */
/**
 * Staff admin controller
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Adminhtml_Hr_StaffController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the staff
     *
     * @access protected
     * @return BS_HR_Model_Staff
     */
    protected function _initStaff()
    {
        $staffId  = (int) $this->getRequest()->getParam('id');
        $staff    = Mage::getModel('bs_hr/staff');
        if ($staffId) {
            $staff->load($staffId);
        }
        Mage::register('current_staff', $staff);
        return $staff;
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
        $this->_title(Mage::helper('bs_hr')->__('HR'))
             ->_title(Mage::helper('bs_hr')->__('Staff'));
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
     * edit staff - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $staffId    = $this->getRequest()->getParam('id');
        $staff      = $this->_initStaff();
        if ($staffId && !$staff->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_hr')->__('This staff no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getStaffData(true);
        if (!empty($data)) {
            $staff->setData($data);
        }
        Mage::register('staff_data', $staff);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_hr')->__('HR'))
             ->_title(Mage::helper('bs_hr')->__('Staff'));
        if ($staff->getId()) {
            $this->_title($staff->getUserId());
        } else {
            $this->_title(Mage::helper('bs_hr')->__('Add staff'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new staff action
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
     * save staff - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('staff')) {
            try {
                $staff = $this->_initStaff();
                $staff->addData($data);
                $staff->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hr')->__('Staff was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $staff->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setStaffData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was a problem saving the staff.')
                );
                Mage::getSingleton('adminhtml/session')->setStaffData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_hr')->__('Unable to find staff to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete staff - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $staff = Mage::getModel('bs_hr/staff');
                $staff->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hr')->__('Staff was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error deleting staff.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_hr')->__('Could not find staff to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete staff - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $staffIds = $this->getRequest()->getParam('staff');
        if (!is_array($staffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select staff to delete.')
            );
        } else {
            try {
                foreach ($staffIds as $staffId) {
                    $staff = Mage::getModel('bs_hr/staff');
                    $staff->setId($staffId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hr')->__('Total of %d staff were successfully deleted.', count($staffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error deleting staff.')
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
        $staffIds = $this->getRequest()->getParam('staff');
        if (!is_array($staffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select staff.')
            );
        } else {
            try {
                foreach ($staffIds as $staffId) {
                $staff = Mage::getSingleton('bs_hr/staff')->load($staffId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d staff were successfully updated.', count($staffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating staff.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Room change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massRoomAction()
    {
        $staffIds = $this->getRequest()->getParam('staff');
        if (!is_array($staffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select staff.')
            );
        } else {
            try {
                foreach ($staffIds as $staffId) {
                $staff = Mage::getSingleton('bs_hr/staff')->load($staffId)
                    ->setRoom($this->getRequest()->getParam('flag_room'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d staff were successfully updated.', count($staffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating staff.')
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
        $staffIds = $this->getRequest()->getParam('staff');
        if (!is_array($staffIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select staff.')
            );
        } else {
            try {
                foreach ($staffIds as $staffId) {
                $staff = Mage::getSingleton('bs_hr/staff')->load($staffId)
                    ->setRegion($this->getRequest()->getParam('flag_region'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d staff were successfully updated.', count($staffIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating staff.')
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
        $fileName   = 'staff.csv';
        $content    = $this->getLayout()->createBlock('bs_hr/adminhtml_staff_grid')
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
        $fileName   = 'staff.xls';
        $content    = $this->getLayout()->createBlock('bs_hr/adminhtml_staff_grid')
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
        $fileName   = 'staff.xml';
        $content    = $this->getLayout()->createBlock('bs_hr/adminhtml_staff_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_hr/staff');
    }
}
