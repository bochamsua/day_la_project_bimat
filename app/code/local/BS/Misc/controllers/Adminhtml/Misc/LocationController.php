<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Location admin controller
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Adminhtml_Misc_LocationController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the location
     *
     * @access protected
     * @return BS_Misc_Model_Location
     */
    protected function _initLocation()
    {
        $locationId  = (int) $this->getRequest()->getParam('id');
        $location    = Mage::getModel('bs_misc/location');
        if ($locationId) {
            $location->load($locationId);
        }
        Mage::register('current_location', $location);
        return $location;
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
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Locations'));
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
     * edit location - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $locationId    = $this->getRequest()->getParam('id');
        $location      = $this->_initLocation();
        if ($locationId && !$location->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_misc')->__('This location no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getLocationData(true);
        if (!empty($data)) {
            $location->setData($data);
        }
        Mage::register('location_data', $location);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Locations'));
        if ($location->getId()) {
            $this->_title($location->getLocName());
        } else {
            $this->_title(Mage::helper('bs_misc')->__('Add location'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new location action
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
     * save location - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('location')) {
            try {
                $location = $this->_initLocation();
                $location->addData($data);
                $location->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Location was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $location->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setLocationData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was a problem saving the location.')
                );
                Mage::getSingleton('adminhtml/session')->setLocationData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Unable to find location to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete location - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $location = Mage::getModel('bs_misc/location');
                $location->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Location was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting location.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Could not find location to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete location - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $locationIds = $this->getRequest()->getParam('location');
        if (!is_array($locationIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select locations to delete.')
            );
        } else {
            try {
                foreach ($locationIds as $locationId) {
                    $location = Mage::getModel('bs_misc/location');
                    $location->setId($locationId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Total of %d locations were successfully deleted.', count($locationIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting locations.')
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
        $locationIds = $this->getRequest()->getParam('location');
        if (!is_array($locationIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select locations.')
            );
        } else {
            try {
                foreach ($locationIds as $locationId) {
                $location = Mage::getSingleton('bs_misc/location')->load($locationId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d locations were successfully updated.', count($locationIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating locations.')
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
        $fileName   = 'location.csv';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_location_grid')
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
        $fileName   = 'location.xls';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_location_grid')
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
        $fileName   = 'location.xml';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_location_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/location');
    }
}
