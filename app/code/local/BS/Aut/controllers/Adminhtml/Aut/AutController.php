<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Authority admin controller
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
class BS_Aut_Adminhtml_Aut_AutController extends BS_Aut_Controller_Adminhtml_Aut
{
    /**
     * init the authority
     *
     * @access protected
     * @return BS_Aut_Model_Aut
     */
    protected function _initAut()
    {
        $autId  = (int) $this->getRequest()->getParam('id');
        $aut    = Mage::getModel('bs_aut/aut');
        if ($autId) {
            $aut->load($autId);
        }
        Mage::register('current_aut', $aut);
        return $aut;
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
        $this->_title(Mage::helper('bs_aut')->__('Authority'))
             ->_title(Mage::helper('bs_aut')->__('Authorities'));
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
     * edit authority - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $autId    = $this->getRequest()->getParam('id');
        $aut      = $this->_initAut();
        if ($autId && !$aut->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_aut')->__('This authority no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getAutData(true);
        if (!empty($data)) {
            $aut->setData($data);
        }
        Mage::register('aut_data', $aut);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_aut')->__('Authority'))
             ->_title(Mage::helper('bs_aut')->__('Authorities'));
        if ($aut->getId()) {
            $this->_title($aut->getName());
        } else {
            $this->_title(Mage::helper('bs_aut')->__('Add authority'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new authority action
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
     * save authority - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('aut')) {
            try {
                $data = $this->_filterDates($data, array('issue_date' ,'expire_date'));
                $aut = $this->_initAut();
                $aut->addData($data);
                $autSourceName = $this->_uploadAndGetName(
                    'aut_source',
                    Mage::helper('bs_aut/aut')->getFileBaseDir(),
                    $data
                );
                $aut->setData('aut_source', $autSourceName);
                $aut->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_aut')->__('Authority was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $aut->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['aut_source']['value'])) {
                    $data['aut_source'] = $data['aut_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setAutData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['aut_source']['value'])) {
                    $data['aut_source'] = $data['aut_source']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_aut')->__('There was a problem saving the authority.')
                );
                Mage::getSingleton('adminhtml/session')->setAutData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_aut')->__('Unable to find authority to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete authority - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $aut = Mage::getModel('bs_aut/aut');
                $aut->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_aut')->__('Authority was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_aut')->__('There was an error deleting authority.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_aut')->__('Could not find authority to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete authority - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $autIds = $this->getRequest()->getParam('aut');
        if (!is_array($autIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_aut')->__('Please select authorities to delete.')
            );
        } else {
            try {
                foreach ($autIds as $autId) {
                    $aut = Mage::getModel('bs_aut/aut');
                    $aut->setId($autId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_aut')->__('Total of %d authorities were successfully deleted.', count($autIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_aut')->__('There was an error deleting authorities.')
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
        $autIds = $this->getRequest()->getParam('aut');
        if (!is_array($autIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_aut')->__('Please select authorities.')
            );
        } else {
            try {
                foreach ($autIds as $autId) {
                $aut = Mage::getSingleton('bs_aut/aut')->load($autId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d authorities were successfully updated.', count($autIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_aut')->__('There was an error updating authorities.')
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
    public function massAutStatusAction()
    {
        $autIds = $this->getRequest()->getParam('aut');
        if (!is_array($autIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_aut')->__('Please select authorities.')
            );
        } else {
            try {
                foreach ($autIds as $autId) {
                $aut = Mage::getSingleton('bs_aut/aut')->load($autId)
                    ->setAutStatus($this->getRequest()->getParam('flag_aut_status'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d authorities were successfully updated.', count($autIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_aut')->__('There was an error updating authorities.')
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
        $fileName   = 'aut.csv';
        $content    = $this->getLayout()->createBlock('bs_aut/adminhtml_aut_grid')
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
        $fileName   = 'aut.xls';
        $content    = $this->getLayout()->createBlock('bs_aut/adminhtml_aut_grid')
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
        $fileName   = 'aut.xml';
        $content    = $this->getLayout()->createBlock('bs_aut/adminhtml_aut_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_data/aut');
    }
}
