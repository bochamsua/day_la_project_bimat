<?php
/**
 * BS_Client extension
 * 
 * @category       BS
 * @package        BS_Client
 * @copyright      Copyright (c) 2018
 */
/**
 * Client admin controller
 *
 * @category    BS
 * @package     BS_Client
 * @author Bui Phong
 */
class BS_Client_Adminhtml_Client_ClientController extends BS_Client_Controller_Adminhtml_Client
{
    /**
     * init the client
     *
     * @access protected
     * @return BS_Client_Model_Client
     */
    protected function _initClient()
    {
        $clientId  = (int) $this->getRequest()->getParam('id');
        $client    = Mage::getModel('bs_client/client');
        if ($clientId) {
            $client->load($clientId);
        }
        Mage::register('current_client', $client);
        return $client;
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
        $this->_title(Mage::helper('bs_client')->__('Client'))
             ->_title(Mage::helper('bs_client')->__('Clients'));
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
     * edit client - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $clientId    = $this->getRequest()->getParam('id');
        $client      = $this->_initClient();
        if ($clientId && !$client->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_client')->__('This client no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getClientData(true);
        if (!empty($data)) {
            $client->setData($data);
        }
        Mage::register('client_data', $client);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_client')->__('Client'))
             ->_title(Mage::helper('bs_client')->__('Clients'));
        if ($client->getId()) {
            $this->_title($client->getClientId());
        } else {
            $this->_title(Mage::helper('bs_client')->__('Add client'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new client action
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
     * save client - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('client')) {
            try {
                $data = $this->_filterDates($data, array('issue_date' ,'expire_date'));
                $client = $this->_initClient();
                $client->addData($data);
                $clientSourceName = $this->_uploadAndGetName(
                    'client_source',
                    Mage::helper('bs_client/client')->getFileBaseDir(),
                    $data
                );
                $client->setData('client_source', $clientSourceName);
                $client->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_client')->__('Client was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $client->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['client_source']['value'])) {
                    $data['client_source'] = $data['client_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setClientData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['client_source']['value'])) {
                    $data['client_source'] = $data['client_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_client')->__('There was a problem saving the client.')
                );
                Mage::getSingleton('adminhtml/session')->setClientData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_client')->__('Unable to find client to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete client - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $client = Mage::getModel('bs_client/client');
                $client->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_client')->__('Client was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_client')->__('There was an error deleting client.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_client')->__('Could not find client to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete client - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $clientIds = $this->getRequest()->getParam('client');
        if (!is_array($clientIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_client')->__('Please select clients to delete.')
            );
        } else {
            try {
                foreach ($clientIds as $clientId) {
                    $client = Mage::getModel('bs_client/client');
                    $client->setId($clientId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_client')->__('Total of %d clients were successfully deleted.', count($clientIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_client')->__('There was an error deleting clients.')
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
        $clientIds = $this->getRequest()->getParam('client');
        if (!is_array($clientIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_client')->__('Please select clients.')
            );
        } else {
            try {
                foreach ($clientIds as $clientId) {
                $client = Mage::getSingleton('bs_client/client')->load($clientId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d clients were successfully updated.', count($clientIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_client')->__('There was an error updating clients.')
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
    public function massClientStatusAction()
    {
        $clientIds = $this->getRequest()->getParam('client');
        if (!is_array($clientIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_client')->__('Please select clients.')
            );
        } else {
            try {
                foreach ($clientIds as $clientId) {
                $client = Mage::getSingleton('bs_client/client')->load($clientId)
                    ->setClientStatus($this->getRequest()->getParam('flag_client_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d clients were successfully updated.', count($clientIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_client')->__('There was an error updating clients.')
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
        $fileName   = 'client.csv';
        $content    = $this->getLayout()->createBlock('bs_client/adminhtml_client_grid')
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
        $fileName   = 'client.xls';
        $content    = $this->getLayout()->createBlock('bs_client/adminhtml_client_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }


    public function getCustomerCOdeAction(){
        $result = [];
        $customer = $this->getRequest()->getPost('customer', false);

        $result['code'] = '';
        if($customer){

            $customerModel = Mage::getModel('bs_acreg/customer')->load($customer);
            $result['code'] = $customerModel->getCode();
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
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
        $fileName   = 'client.xml';
        $content    = $this->getLayout()->createBlock('bs_client/adminhtml_client_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_data/client');
    }
}
