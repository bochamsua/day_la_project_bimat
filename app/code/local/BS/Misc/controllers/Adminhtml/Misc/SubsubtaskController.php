<?php
/**
 * BS_Misc extension
 * 
 * @category       BS
 * @package        BS_Misc
 * @copyright      Copyright (c) 2016
 */
/**
 * Sub Sub Task admin controller
 *
 * @category    BS
 * @package     BS_Misc
 * @author Bui Phong
 */
class BS_Misc_Adminhtml_Misc_SubsubtaskController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the sub sub task
     *
     * @access protected
     * @return BS_Misc_Model_Subsubtask
     */
    protected function _initSubsubtask()
    {
        $subsubtaskId  = (int) $this->getRequest()->getParam('id');
        $subsubtask    = Mage::getModel('bs_misc/subsubtask');
        if ($subsubtaskId) {
            $subsubtask->load($subsubtaskId);
        }
        Mage::register('current_subsubtask', $subsubtask);
        return $subsubtask;
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
             ->_title(Mage::helper('bs_misc')->__('Survey Sub Sub Codes'));
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
     * edit sub sub task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $subsubtaskId    = $this->getRequest()->getParam('id');
        $subsubtask      = $this->_initSubsubtask();
        if ($subsubtaskId && !$subsubtask->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_misc')->__('This sub sub task no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSubsubtaskData(true);
        if (!empty($data)) {
            $subsubtask->setData($data);
        }
        Mage::register('subsubtask_data', $subsubtask);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_misc')->__('Misc'))
             ->_title(Mage::helper('bs_misc')->__('Survey Sub Sub Codes'));
        if ($subsubtask->getId()) {
            $this->_title($subsubtask->getSubsubCode());
        } else {
            $this->_title(Mage::helper('bs_misc')->__('Add sub sub task'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new sub sub task action
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
     * save sub sub task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('subsubtask')) {
            try {
                $subsubtask = $this->_initSubsubtask();
                $subsubtask->addData($data);
                $subsubtask->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Sub Sub Task was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $subsubtask->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSubsubtaskData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was a problem saving the sub sub task.')
                );
                Mage::getSingleton('adminhtml/session')->setSubsubtaskData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Unable to find sub sub task to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete sub sub task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $subsubtask = Mage::getModel('bs_misc/subsubtask');
                $subsubtask->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Sub Sub Task was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting sub sub task.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_misc')->__('Could not find sub sub task to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete sub sub task - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $subsubtaskIds = $this->getRequest()->getParam('subsubtask');
        if (!is_array($subsubtaskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select sub sub tasks to delete.')
            );
        } else {
            try {
                foreach ($subsubtaskIds as $subsubtaskId) {
                    $subsubtask = Mage::getModel('bs_misc/subsubtask');
                    $subsubtask->setId($subsubtaskId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_misc')->__('Total of %d sub sub tasks were successfully deleted.', count($subsubtaskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error deleting sub sub tasks.')
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
        $subsubtaskIds = $this->getRequest()->getParam('subsubtask');
        if (!is_array($subsubtaskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select sub sub tasks.')
            );
        } else {
            try {
                foreach ($subsubtaskIds as $subsubtaskId) {
                $subsubtask = Mage::getSingleton('bs_misc/subsubtask')->load($subsubtaskId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sub sub tasks were successfully updated.', count($subsubtaskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating sub sub tasks.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass sub task change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massSubtaskIdAction()
    {
        $subsubtaskIds = $this->getRequest()->getParam('subsubtask');
        if (!is_array($subsubtaskIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_misc')->__('Please select sub sub tasks.')
            );
        } else {
            try {
                foreach ($subsubtaskIds as $subsubtaskId) {
                $subsubtask = Mage::getSingleton('bs_misc/subsubtask')->load($subsubtaskId)
                    ->setSubtaskId($this->getRequest()->getParam('flag_subtask_id'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sub sub tasks were successfully updated.', count($subsubtaskIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_misc')->__('There was an error updating sub sub tasks.')
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
        $fileName   = 'subsubtask.csv';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_subsubtask_grid')
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
        $fileName   = 'subsubtask.xls';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_subsubtask_grid')
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
        $fileName   = 'subsubtask.xml';
        $content    = $this->getLayout()->createBlock('bs_misc/adminhtml_subsubtask_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/subsubtask');
    }
}
