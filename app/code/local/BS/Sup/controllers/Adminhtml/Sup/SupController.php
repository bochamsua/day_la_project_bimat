<?php
/**
 * BS_Sup extension
 * 
 * @category       BS
 * @package        BS_Sup
 * @copyright      Copyright (c) 2018
 */
/**
 * Supplier admin controller
 *
 * @category    BS
 * @package     BS_Sup
 * @author Bui Phong
 */
class BS_Sup_Adminhtml_Sup_SupController extends BS_Sup_Controller_Adminhtml_Sup
{
    /**
     * init the supplier
     *
     * @access protected
     * @return BS_Sup_Model_Sup
     */
    protected function _initSup()
    {
        $supId  = (int) $this->getRequest()->getParam('id');
        $sup    = Mage::getModel('bs_sup/sup');
        if ($supId) {
            $sup->load($supId);
        }
        Mage::register('current_sup', $sup);
        return $sup;
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
        $this->_title(Mage::helper('bs_sup')->__('Supplier'))
             ->_title(Mage::helper('bs_sup')->__('Suppliers'));
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
     * edit supplier - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $supId    = $this->getRequest()->getParam('id');
        $sup      = $this->_initSup();
        if ($supId && !$sup->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_sup')->__('This supplier no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSupData(true);
        if (!empty($data)) {
            $sup->setData($data);
        }
        Mage::register('sup_data', $sup);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_sup')->__('Supplier'))
             ->_title(Mage::helper('bs_sup')->__('Suppliers'));
        if ($sup->getId()) {
            $this->_title($sup->getSupCode());
        } else {
            $this->_title(Mage::helper('bs_sup')->__('Add supplier'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new supplier action
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
     * save supplier - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('sup')) {
            try {
                $data = $this->_filterDates($data, array('issue_date' ,'expire_date'));
                $sup = $this->_initSup();
                $sup->addData($data);
                $supSourceName = $this->_uploadAndGetName(
                    'sup_source',
                    Mage::helper('bs_sup/sup')->getFileBaseDir(),
                    $data
                );
                $sup->setData('sup_source', $supSourceName);
                $sup->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_sup')->__('Supplier was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $sup->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['sup_source']['value'])) {
                    $data['sup_source'] = $data['sup_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSupData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['sup_source']['value'])) {
                    $data['sup_source'] = $data['sup_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sup')->__('There was a problem saving the supplier.')
                );
                Mage::getSingleton('adminhtml/session')->setSupData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_sup')->__('Unable to find supplier to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete supplier - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $sup = Mage::getModel('bs_sup/sup');
                $sup->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_sup')->__('Supplier was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sup')->__('There was an error deleting supplier.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_sup')->__('Could not find supplier to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete supplier - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $supIds = $this->getRequest()->getParam('sup');
        if (!is_array($supIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sup')->__('Please select suppliers to delete.')
            );
        } else {
            try {
                foreach ($supIds as $supId) {
                    $sup = Mage::getModel('bs_sup/sup');
                    $sup->setId($supId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_sup')->__('Total of %d suppliers were successfully deleted.', count($supIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sup')->__('There was an error deleting suppliers.')
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
        $supIds = $this->getRequest()->getParam('sup');
        if (!is_array($supIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sup')->__('Please select suppliers.')
            );
        } else {
            try {
                foreach ($supIds as $supId) {
                $sup = Mage::getSingleton('bs_sup/sup')->load($supId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d suppliers were successfully updated.', count($supIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sup')->__('There was an error updating suppliers.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Class change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSupClassAction()
    {
        $supIds = $this->getRequest()->getParam('sup');
        if (!is_array($supIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sup')->__('Please select suppliers.')
            );
        } else {
            try {
                foreach ($supIds as $supId) {
                $sup = Mage::getSingleton('bs_sup/sup')->load($supId)
                    ->setSupClass($this->getRequest()->getParam('flag_sup_class'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d suppliers were successfully updated.', count($supIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sup')->__('There was an error updating suppliers.')
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
    public function massSupStatusAction()
    {
        $supIds = $this->getRequest()->getParam('sup');
        if (!is_array($supIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_sup')->__('Please select suppliers.')
            );
        } else {
            try {
                foreach ($supIds as $supId) {
                $sup = Mage::getSingleton('bs_sup/sup')->load($supId)
                    ->setSupStatus($this->getRequest()->getParam('flag_sup_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d suppliers were successfully updated.', count($supIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_sup')->__('There was an error updating suppliers.')
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
        $fileName   = 'sup.csv';
        $content    = $this->getLayout()->createBlock('bs_sup/adminhtml_sup_grid')
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
        $fileName   = 'sup.xls';
        $content    = $this->getLayout()->createBlock('bs_sup/adminhtml_sup_grid')
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
        $fileName   = 'sup.xml';
        $content    = $this->getLayout()->createBlock('bs_sup/adminhtml_sup_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_data/sup');
    }

    public function generateFiveAction()
    {

        if ($id = $this->getRequest()->getParam('id')) {
            $obj = Mage::getSingleton('bs_sup/sup')->load($id);

            $this->generateFive($obj);

        }
        $this->_redirect(
            '*/sup_sup/edit',
            [
                'id' => $this->getRequest()->getParam('id'),
                '_current' => true
            ]
        );

    }

    public function generateFive($obj)
    {
        $template = Mage::helper('bs_formtemplate')->getFormtemplate('2005');

        $fileName = $obj->getCertNo() . '_2005 Supplier Approval Certificate '.microtime();


        $issueDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getIssueDate());
        $expireDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getExpireDate());

        $data = [
            'cert_no' => $obj->getCertNo(),

            'name' => $obj->getSupName(),
            'address' => $obj->getSupAddress(),
            'class' => Mage::getModel('bs_sup/sup_attribute_source_supclass')->getOptionText($obj->getSupClass()),
            'rating' => $obj->getRating(),
            'issue_date' => $issueDate,
            'expire_date' => $expireDate,


        ];





        try {
            $res = Mage::helper('bs_docx')->generateDocx($fileName, $template, $data);
            $this->_getSession()->addSuccess(
                Mage::helper('bs_ncr')->__('Click <a href="%s">%s</a>. to open', $res['url'], $res['name'])
            );


        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
    }


    public function generateSevenAction()
    {

        if ($id = $this->getRequest()->getParam('id')) {
            $obj = Mage::getSingleton('bs_sup/sup')->load($id);

            $this->generateSeven($obj);

        }
        $this->_redirect(
            '*/sup_sup/edit',
            [
                'id' => $this->getRequest()->getParam('id'),
                '_current' => true
            ]
        );

    }

    public function generateSeven($obj)
    {
        $template = Mage::helper('bs_formtemplate')->getFormtemplate('2007');

        $fileName = $obj->getCertNo() . '_2007 SUBCONTRACTOR_APPROVAL_CERTIFICATE '.microtime();


        $issueDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getIssueDate());
        $expireDate = Mage::getModel('core/date')->date("d/m/Y", $obj->getExpireDate());

        $data = [
            'cert_no' => $obj->getCertNo(),
            'name' => $obj->getSupName(),
            'address' => $obj->getSupAddress(),
            'class' => Mage::getModel('bs_sup/sup_attribute_source_supclass')->getOptionText($obj->getSupClass()),
            'rating' => $obj->getRating(),
            'issue_date' => $issueDate,
            'expire_date' => $expireDate,


        ];





        try {
            $res = Mage::helper('bs_docx')->generateDocx($fileName, $template, $data);
            $this->_getSession()->addSuccess(
                Mage::helper('bs_ncr')->__('Click <a href="%s">%s</a>. to open', $res['url'], $res['name'])
            );


        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
    }
}
