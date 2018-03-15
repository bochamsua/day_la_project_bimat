<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate Type admin controller
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Adminhtml_Misc_CerttypeController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the certificate type
     *
     * @access protected
     * @return BS_Misc_Model_Certtype
     */
    protected function _initCerttype()
    {
        $certtypeId  = (int) $this->getRequest()->getParam('id');
        $certtype    = Mage::getModel('bs_misc/certtype');
        if ($certtypeId) {
            $certtype->load($certtypeId);
        }
        Mage::register('current_certtype', $certtype);
        return $certtype;
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
             ->_title(Mage::helper('bs_misc')->__('Certificate Types'));
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
     * edit certificate type - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $certtypeId    = $this->getRequest()->getParam('id');
        $certtype      = $this->_initCerttype();
        if ($certtypeId && !$certtype->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_misc')->__('This certificate type no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCerttypeData(true);
        if (!empty($data)) {
            $certtype->setData($data);
        }
        Mage::register('certtype_data', $certtype);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Certificate Types'));
        if ($certtype->getId()) {
            $this->_title($certtype->getCertCode());
        } else {
            $this->_title(Mage::helper('bs_misc')->__('Add certificate type'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new certificate type action
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
     * save certificate type - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('certtype')) {
            try {
                $certtype = $this->_initCerttype();
                if($data['import'] != ''){
                    $import = $data['import'];
                    $import = explode("\r\n", $import);
                    foreach ($import as $line) {
                        //$item = explode("\t", $line);
                        $line = trim($line);
                        $certtype    = Mage::getModel('bs_misc/certtype');
                        $certtype->setData('cert_code', $line)->save();

                    }

                }else {
                    $certtype->addData($data);
                    $certtype->save();
                }

                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Certificate Type was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $certtype->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCerttypeData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was a problem saving the certificate type.')
                );
                Mage::getSingleton('adminhtml/session')->setCerttypeData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Unable to find certificate type to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete certificate type - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $certtype = Mage::getModel('bs_misc/certtype');
                $certtype->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Certificate Type was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting certificate type.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Could not find certificate type to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete certificate type - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $certtypeIds = $this->getRequest()->getParam('certtype');
        if (!is_array($certtypeIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select certificate types to delete.')
            );
        } else {
            try {
                foreach ($certtypeIds as $certtypeId) {
                    $certtype = Mage::getModel('bs_misc/certtype');
                    $certtype->setId($certtypeId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Total of %d certificate types were successfully deleted.', count($certtypeIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting certificate types.')
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
        $certtypeIds = $this->getRequest()->getParam('certtype');
        if (!is_array($certtypeIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select certificate types.')
            );
        } else {
            try {
                foreach ($certtypeIds as $certtypeId) {
                $certtype = Mage::getSingleton('bs_misc/certtype')->load($certtypeId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d certificate types were successfully updated.', count($certtypeIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating certificate types.')
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
        $fileName   = 'certtype.csv';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_certtype_grid')
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
        $fileName   = 'certtype.xls';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_certtype_grid')
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
        $fileName   = 'certtype.xml';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_certtype_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/certtype');
    }
}
