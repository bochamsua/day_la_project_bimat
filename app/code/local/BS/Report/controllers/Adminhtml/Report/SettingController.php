<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Setting admin controller
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Adminhtml_Report_SettingController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the setting
     *
     * @access protected
     * @return BS_Report_Model_Setting
     */
    protected function _initSetting()
    {
        $settingId  = (int) $this->getRequest()->getParam('id');
        $setting    = Mage::getModel('bs_report/setting');
        if ($settingId) {
            $setting->load($settingId);
        }
        Mage::register('current_setting', $setting);
        return $setting;
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
        $this->_title(Mage::helper('bs_report')->__('Report'))
             ->_title(Mage::helper('bs_report')->__('Settings'));
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
     * edit setting - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $settingId    = $this->getRequest()->getParam('id');
        $setting      = $this->_initSetting();
        if ($settingId && !$setting->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_report')->__('This setting no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSettingData(true);
        if (!empty($data)) {
            $setting->setData($data);
        }
        Mage::register('setting_data', $setting);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_report')->__('Report'))
             ->_title(Mage::helper('bs_report')->__('Settings'));
        if ($setting->getId()) {
            $this->_title($setting->getCode());
        } else {
            $this->_title(Mage::helper('bs_report')->__('Add setting'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new setting action
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
     * save setting - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('setting')) {
            try {
                $setting = $this->_initSetting();
                $setting->addData($data);
                $setting->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('Setting was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $setting->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSettingData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was a problem saving the setting.')
                );
                Mage::getSingleton('adminhtml/session')->setSettingData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_report')->__('Unable to find setting to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete setting - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $setting = Mage::getModel('bs_report/setting');
                $setting->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('Setting was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error deleting setting.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_report')->__('Could not find setting to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete setting - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $settingIds = $this->getRequest()->getParam('setting');
        if (!is_array($settingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_report')->__('Please select settings to delete.')
            );
        } else {
            try {
                foreach ($settingIds as $settingId) {
                    $setting = Mage::getModel('bs_report/setting');
                    $setting->setId($settingId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_report')->__('Total of %d settings were successfully deleted.', count($settingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error deleting settings.')
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
        $settingIds = $this->getRequest()->getParam('setting');
        if (!is_array($settingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_report')->__('Please select settings.')
            );
        } else {
            try {
                foreach ($settingIds as $settingId) {
                $setting = Mage::getSingleton('bs_report/setting')->load($settingId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d settings were successfully updated.', count($settingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_report')->__('There was an error updating settings.')
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
        $fileName   = 'setting.csv';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_setting_grid')
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
        $fileName   = 'setting.xls';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_setting_grid')
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
        $fileName   = 'setting.xml';
        $content    = $this->getLayout()->createBlock('bs_report/adminhtml_setting_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_evaluation/setting');
    }
}
