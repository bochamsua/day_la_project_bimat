<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Training admin controller
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Adminhtml_Hr_TrainingController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the training
     *
     * @access protected
     * @return BS_HR_Model_Training
     */
    protected function _initTraining()
    {
        $trainingId  = (int) $this->getRequest()->getParam('id');
        $training    = Mage::getModel('bs_hr/training');
        if ($trainingId) {
            $training->load($trainingId);
        }
        Mage::register('current_training', $training);
        return $training;
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
        $this->_title(Mage::helper('bs_hr')->__('HR'))
             ->_title(Mage::helper('bs_hr')->__('Trainings'));
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
     * edit training - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $trainingId    = $this->getRequest()->getParam('id');
        $training      = $this->_initTraining();
        if ($trainingId && !$training->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_hr')->__('This training no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getTrainingData(true);
        if (!empty($data)) {
            $training->setData($data);
        }
        Mage::register('training_data', $training);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_hr')->__('HR'))
             ->_title(Mage::helper('bs_hr')->__('Trainings'));
        if ($training->getId()) {
            $this->_title($training->getTrainingDesc());
        } else {
            $this->_title(Mage::helper('bs_hr')->__('Add training'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new training action
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
     * save training - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('training')) {
            try {
                $training = $this->_initTraining();
                $currentUserId = Mage::getSingleton('admin/session')->getUser()->getId();
                $data['ins_id'] = $currentUserId;

                $training->addData($data);
                $training->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hr')->__('Training was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $training->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setTrainingData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was a problem saving the training.')
                );
                Mage::getSingleton('adminhtml/session')->setTrainingData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_hr')->__('Unable to find training to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete training - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $training = Mage::getModel('bs_hr/training');
                $training->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hr')->__('Training was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error deleting training.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_hr')->__('Could not find training to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete training - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings to delete.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                    $training = Mage::getModel('bs_hr/training');
                    $training->setId($trainingId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_hr')->__('Total of %d trainings were successfully deleted.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error deleting trainings.')
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
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Completed Type training course for at least 2 months? change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massTypeTrainingAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setTypeTraining($this->getRequest()->getParam('flag_type_training'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Line maintenance experience for at least 6 months?  change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massLineSixAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setLineSix($this->getRequest()->getParam('flag_line_six'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Base maintenance experience for at least 6 months  change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massBaseSixAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setBaseSix($this->getRequest()->getParam('flag_base_six'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Holding CRS A certificate for at least 14 months? change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massCrsAAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setCrsA($this->getRequest()->getParam('flag_crs_a'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Line maintenance experience for at least 12 months? change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massLineTwelveAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setLineTwelve($this->getRequest()->getParam('flag_line_twelve'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Base maintenance experience for at least 12 months? change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massBaseTwelveAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setBaseTwelve($this->getRequest()->getParam('flag_base_twelve'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Hoding CRS B certificate for at least 38 months? change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massCrsBAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setCrsB($this->getRequest()->getParam('flag_crs_b'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Line maintenance experience for at least 24 months? change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massLineTwentyfourAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setLineTwentyfour($this->getRequest()->getParam('flag_line_twentyfour'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Base maintenance experience for at least 24 months? change - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massBaseTwentyfourAction()
    {
        $trainingIds = $this->getRequest()->getParam('training');
        if (!is_array($trainingIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_hr')->__('Please select trainings.')
            );
        } else {
            try {
                foreach ($trainingIds as $trainingId) {
                $training = Mage::getSingleton('bs_hr/training')->load($trainingId)
                    ->setBaseTwentyfour($this->getRequest()->getParam('flag_base_twentyfour'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d trainings were successfully updated.', count($trainingIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_hr')->__('There was an error updating trainings.')
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
        $fileName   = 'training.csv';
        $content    = $this->getLayout()->createBlock('bs_hr/adminhtml_training_grid')
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
        $fileName   = 'training.xls';
        $content    = $this->getLayout()->createBlock('bs_hr/adminhtml_training_grid')
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
        $fileName   = 'training.xml';
        $content    = $this->getLayout()->createBlock('bs_hr/adminhtml_training_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_hr/training');
    }
}
