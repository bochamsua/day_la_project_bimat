<?php
/**
 * BS_Routine extension
 * 
 * @category       BS
 * @package        BS_Routine
 * @copyright      Copyright (c) 2017
 */
/**
 * Routine Report admin controller
 *
 * @category    BS
 * @package     BS_Routine
 * @author Bui Phong
 */
class BS_Routine_Adminhtml_Routine_RoutineController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the routine report
     *
     * @access protected
     * @return BS_Routine_Model_Routine
     */
    protected function _initRoutine()
    {
        $routineId  = (int) $this->getRequest()->getParam('id');
        $routine    = Mage::getModel('bs_routine/routine');
        if ($routineId) {
            $routine->load($routineId);
        }
        Mage::register('current_routine', $routine);
        return $routine;
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
        $this->_title(Mage::helper('bs_routine')->__('Routine Report'))
             ->_title(Mage::helper('bs_routine')->__('Routine Reports'));
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
     * edit routine report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $routineId    = $this->getRequest()->getParam('id');
        $routine      = $this->_initRoutine();
        if ($routineId && !$routine->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_routine')->__('This routine report no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getRoutineData(true);
        if (!empty($data)) {
            $routine->setData($data);
        }
        Mage::register('routine_data', $routine);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_routine')->__('Routine Report'))
             ->_title(Mage::helper('bs_routine')->__('Routine Reports'));
        if ($routine->getId()) {
            $this->_title($routine->getName());
        } else {
            $this->_title(Mage::helper('bs_routine')->__('Add routine report'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new routine report action
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
     * save routine report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('routine')) {
            try {
                $routine = $this->_initRoutine();
                $routine->addData($data);
                $routine->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_routine')->__('Routine Report was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $routine->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setRoutineData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_routine')->__('There was a problem saving the routine report.')
                );
                Mage::getSingleton('adminhtml/session')->setRoutineData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_routine')->__('Unable to find routine report to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete routine report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $routine = Mage::getModel('bs_routine/routine');
                $routine->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_routine')->__('Routine Report was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_routine')->__('There was an error deleting routine report.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_routine')->__('Could not find routine report to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete routine report - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $routineIds = $this->getRequest()->getParam('routine');
        if (!is_array($routineIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_routine')->__('Please select routine reports to delete.')
            );
        } else {
            try {
                foreach ($routineIds as $routineId) {
                    $routine = Mage::getModel('bs_routine/routine');
                    $routine->setId($routineId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_routine')->__('Total of %d routine reports were successfully deleted.', count($routineIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_routine')->__('There was an error deleting routine reports.')
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
        $routineIds = $this->getRequest()->getParam('routine');
        if (!is_array($routineIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_routine')->__('Please select routine reports.')
            );
        } else {
            try {
                foreach ($routineIds as $routineId) {
                $routine = Mage::getSingleton('bs_routine/routine')->load($routineId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d routine reports were successfully updated.', count($routineIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_routine')->__('There was an error updating routine reports.')
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
        $fileName   = 'routine.csv';
        $content    = $this->getLayout()->createBlock('bs_routine/adminhtml_routine_grid')
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
        $fileName   = 'routine.xls';
        $content    = $this->getLayout()->createBlock('bs_routine/adminhtml_routine_grid')
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
        $fileName   = 'routine.xml';
        $content    = $this->getLayout()->createBlock('bs_routine/adminhtml_routine_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_report/routine');
    }
}
