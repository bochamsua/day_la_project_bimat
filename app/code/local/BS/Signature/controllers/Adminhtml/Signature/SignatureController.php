<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature admin controller
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Adminhtml_Signature_SignatureController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the signature
     *
     * @access protected
     * @return BS_Signature_Model_Signature
     */
    protected function _initSignature()
    {
        $signatureId  = (int) $this->getRequest()->getParam('id');
        $signature    = Mage::getModel('bs_signature/signature');
        if ($signatureId) {
            $signature->load($signatureId);
        }
        Mage::register('current_signature', $signature);
        return $signature;
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
        $this->_title(Mage::helper('bs_signature')->__('Signature'))
             ->_title(Mage::helper('bs_signature')->__('Signature'));
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
     * edit signature - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $signatureId    = $this->getRequest()->getParam('id');
        $signature      = $this->_initSignature();
        if ($signatureId && !$signature->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_signature')->__('This signature no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSignatureData(true);
        if (!empty($data)) {
            $signature->setData($data);
        }
        Mage::register('signature_data', $signature);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_signature')->__('Signature'))
             ->_title(Mage::helper('bs_signature')->__('Signature'));
        if ($signature->getId()) {
            $this->_title($signature->getName());
        } else {
            $this->_title(Mage::helper('bs_signature')->__('Add signature'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new signature action
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
     * save signature - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('signature')) {
            try {
                $data = $this->_filterDates($data, ['update_date']);

                if(!isset($data['user_id'])){
	                $user = Mage::getSingleton('admin/session')->getUser();
	                $userId = $user->getUserId();

	                $data['user_id'] = $userId;
                }

	            $data['name'] = 'Signature-'.microtime();
                $signature = $this->_initSignature();
                $signature->addData($data);
                $signatureName = $this->_uploadAndGetName(
                    'signature',
                    Mage::helper('bs_signature/signature')->getFileBaseDir(),
                    $data
                );
                $signature->setData('signature', $signatureName);
                $signature->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_signature')->__('Signature was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $signature->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['signature']['value'])) {
                    $data['signature'] = $data['signature']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSignatureData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['signature']['value'])) {
                    $data['signature'] = $data['signature']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signature')->__('There was a problem saving the signature.')
                );
                Mage::getSingleton('adminhtml/session')->setSignatureData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_signature')->__('Unable to find signature to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete signature - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $signature = Mage::getModel('bs_signature/signature');
                $signature->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_signature')->__('Signature was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signature')->__('There was an error deleting signature.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_signature')->__('Could not find signature to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete signature - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $signatureIds = $this->getRequest()->getParam('signature');
        if (!is_array($signatureIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_signature')->__('Please select signature to delete.')
            );
        } else {
            try {
                foreach ($signatureIds as $signatureId) {
                    $signature = Mage::getModel('bs_signature/signature');
                    $signature->setId($signatureId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_signature')->__('Total of %d signature were successfully deleted.', count($signatureIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signature')->__('There was an error deleting signature.')
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
        $signatureIds = $this->getRequest()->getParam('signature');
        if (!is_array($signatureIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_signature')->__('Please select signature.')
            );
        } else {
            try {
                foreach ($signatureIds as $signatureId) {
                $signature = Mage::getSingleton('bs_signature/signature')->load($signatureId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d signature were successfully updated.', count($signatureIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_signature')->__('There was an error updating signature.')
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
        $fileName   = 'signature.csv';
        $content    = $this->getLayout()->createBlock('bs_signature/adminhtml_signature_grid')
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
        $fileName   = 'signature.xls';
        $content    = $this->getLayout()->createBlock('bs_signature/adminhtml_signature_grid')
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
        $fileName   = 'signature.xml';
        $content    = $this->getLayout()->createBlock('bs_signature/adminhtml_signature_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/signature');
    }
}
