<?php
/**
 * BS_Acreg extension
 * 
 * @category       BS
 * @package        BS_Acreg
 * @copyright      Copyright (c) 2016
 */
/**
 * Customer admin controller
 *
 * @category    BS
 * @package     BS_Acreg
 * @author Bui Phong
 */
class BS_Acreg_Adminhtml_Acreg_CustomerController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the customer
     *
     * @access protected
     * @return BS_Acreg_Model_Customer
     */
    protected function _initCustomer()
    {
        $customerId  = (int) $this->getRequest()->getParam('id');
        $customer    = Mage::getModel('bs_acreg/customer');
        if ($customerId) {
            $customer->load($customerId);
        }
        Mage::register('current_customer', $customer);
        return $customer;
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
        $this->_title(Mage::helper('bs_acreg')->__('A/C Reg'))
             ->_title(Mage::helper('bs_acreg')->__('Customers'));
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
     * edit customer - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $customerId    = $this->getRequest()->getParam('id');
        $customer      = $this->_initCustomer();
        if ($customerId && !$customer->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_acreg')->__('This customer no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getCustomerData(true);
        if (!empty($data)) {
            $customer->setData($data);
        }
        Mage::register('customer_data', $customer);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_acreg')->__('A/C Reg'))
             ->_title(Mage::helper('bs_acreg')->__('Customers'));
        if ($customer->getId()) {
            $this->_title($customer->getName());
        } else {
            $this->_title(Mage::helper('bs_acreg')->__('Add customer'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new customer action
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
     * save customer - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('customer')) {
            try {
                $customer = $this->_initCustomer();
                $customer->addData($data);
                $customer->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_acreg')->__('Customer was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $customer->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCustomerData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was a problem saving the customer.')
                );
                Mage::getSingleton('adminhtml/session')->setCustomerData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_acreg')->__('Unable to find customer to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete customer - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $customer = Mage::getModel('bs_acreg/customer');
                $customer->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_acreg')->__('Customer was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was an error deleting customer.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_acreg')->__('Could not find customer to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete customer - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $customerIds = $this->getRequest()->getParam('customer');
        if (!is_array($customerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_acreg')->__('Please select customers to delete.')
            );
        } else {
            try {
                foreach ($customerIds as $customerId) {
                    $customer = Mage::getModel('bs_acreg/customer');
                    $customer->setId($customerId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_acreg')->__('Total of %d customers were successfully deleted.', count($customerIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was an error deleting customers.')
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
        $customerIds = $this->getRequest()->getParam('customer');
        if (!is_array($customerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_acreg')->__('Please select customers.')
            );
        } else {
            try {
                foreach ($customerIds as $customerId) {
                $customer = Mage::getSingleton('bs_acreg/customer')->load($customerId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d customers were successfully updated.', count($customerIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_acreg')->__('There was an error updating customers.')
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
        $fileName   = 'customer.csv';
        $content    = $this->getLayout()->createBlock('bs_acreg/adminhtml_customer_grid')
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
        $fileName   = 'customer.xls';
        $content    = $this->getLayout()->createBlock('bs_acreg/adminhtml_customer_grid')
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
        $fileName   = 'customer.xml';
        $content    = $this->getLayout()->createBlock('bs_acreg/adminhtml_customer_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/customer');
    }
}
