<?php
/**
 * BS_Kpi extension
 * 
 * @category       BS
 * @package        BS_Kpi
 * @copyright      Copyright (c) 2017
 */
/**
 * KPI Data admin controller
 *
 * @category    BS
 * @package     BS_Kpi
 * @author Bui Phong
 */
class BS_Kpi_Adminhtml_Kpi_KpiController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the kpi data
     *
     * @access protected
     * @return BS_Kpi_Model_Kpi
     */
    protected function _initKpi()
    {
        $kpiId  = (int) $this->getRequest()->getParam('id');
        $kpi    = Mage::getModel('bs_kpi/kpi');
        if ($kpiId) {
            $kpi->load($kpiId);
        }
        Mage::register('current_kpi', $kpi);
        return $kpi;
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
        $this->_title(Mage::helper('bs_kpi')->__('KPI'))
             ->_title(Mage::helper('bs_kpi')->__('KPI Data'));
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
     * edit kpi data - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $kpiId    = $this->getRequest()->getParam('id');
        $kpi      = $this->_initKpi();
        if ($kpiId && !$kpi->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_kpi')->__('This kpi data no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getKpiData(true);
        if (!empty($data)) {
            $kpi->setData($data);
        }
        Mage::register('kpi_data', $kpi);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_kpi')->__('KPI'))
             ->_title(Mage::helper('bs_kpi')->__('KPI Data'));
        if ($kpi->getId()) {
            $this->_title($kpi->getDeptId());
        } else {
            $this->_title(Mage::helper('bs_kpi')->__('Add kpi data'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new kpi data action
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
     * save kpi data - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('kpi')) {
            try {
                $kpi = $this->_initKpi();
                $kpi->addData($data);
                $kpi->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_kpi')->__('KPI Data was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $kpi->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setKpiData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_kpi')->__('There was a problem saving the kpi data.')
                );
                Mage::getSingleton('adminhtml/session')->setKpiData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_kpi')->__('Unable to find kpi data to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete kpi data - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $kpi = Mage::getModel('bs_kpi/kpi');
                $kpi->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_kpi')->__('KPI Data was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_kpi')->__('There was an error deleting kpi data.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_kpi')->__('Could not find kpi data to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete kpi data - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $kpiIds = $this->getRequest()->getParam('kpi');
        if (!is_array($kpiIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_kpi')->__('Please select kpi data to delete.')
            );
        } else {
            try {
                foreach ($kpiIds as $kpiId) {
                    $kpi = Mage::getModel('bs_kpi/kpi');
                    $kpi->setId($kpiId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_kpi')->__('Total of %d kpi data were successfully deleted.', count($kpiIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_kpi')->__('There was an error deleting kpi data.')
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
        $kpiIds = $this->getRequest()->getParam('kpi');
        if (!is_array($kpiIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_kpi')->__('Please select kpi data.')
            );
        } else {
            try {
                foreach ($kpiIds as $kpiId) {
                $kpi = Mage::getSingleton('bs_kpi/kpi')->load($kpiId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d kpi data were successfully updated.', count($kpiIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_kpi')->__('There was an error updating kpi data.')
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
        $fileName   = 'kpi.csv';
        $content    = $this->getLayout()->createBlock('bs_kpi/adminhtml_kpi_grid')
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
        $fileName   = 'kpi.xls';
        $content    = $this->getLayout()->createBlock('bs_kpi/adminhtml_kpi_grid')
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
        $fileName   = 'kpi.xml';
        $content    = $this->getLayout()->createBlock('bs_kpi/adminhtml_kpi_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_data/kpi');
    }
}
