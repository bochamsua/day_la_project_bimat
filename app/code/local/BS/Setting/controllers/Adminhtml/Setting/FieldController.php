<?php
/**
 * BS_Setting extension
 * 
 * @category       BS
 * @package        BS_Setting
 * @copyright      Copyright (c) 2017
 */
/**
 * Field Dependance admin controller
 *
 * @category    BS
 * @package     BS_Setting
 * @author Bui Phong
 */
class BS_Setting_Adminhtml_Setting_FieldController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the field dependance
     *
     * @access protected
     * @return BS_Setting_Model_Field
     */
    protected function _initField()
    {
        $fieldId  = (int) $this->getRequest()->getParam('id');
        $field    = Mage::getModel('bs_setting/field');
        if ($fieldId) {
            $field->load($fieldId);
        }
        Mage::register('current_field', $field);
        return $field;
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
        $this->_title(Mage::helper('bs_setting')->__('Setting'))
             ->_title(Mage::helper('bs_setting')->__('Field Dependance'));
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
     * edit field dependance - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $fieldId    = $this->getRequest()->getParam('id');
        $field      = $this->_initField();
        if ($fieldId && !$field->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_setting')->__('This field dependance no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getFieldData(true);
        if (!empty($data)) {
            $field->setData($data);
        }
        Mage::register('field_data', $field);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_setting')->__('Setting'))
             ->_title(Mage::helper('bs_setting')->__('Field Dependance'));
        if ($field->getId()) {
            $this->_title($field->getName());
        } else {
            $this->_title(Mage::helper('bs_setting')->__('Add field dependance'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new field dependance action
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
     * save field dependance - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('field')) {
            try {
                $field = $this->_initField();
                $field->addData($data);
                $field->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_setting')->__('Field Dependance was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $field->getId()]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFieldData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_setting')->__('There was a problem saving the field dependance.')
                );
                Mage::getSingleton('adminhtml/session')->setFieldData($data);
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_setting')->__('Unable to find field dependance to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete field dependance - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $field = Mage::getModel('bs_setting/field');
                $field->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_setting')->__('Field Dependance was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_setting')->__('There was an error deleting field dependance.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_setting')->__('Could not find field dependance to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete field dependance - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $fieldIds = $this->getRequest()->getParam('field');
        if (!is_array($fieldIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_setting')->__('Please select field dependance to delete.')
            );
        } else {
            try {
                foreach ($fieldIds as $fieldId) {
                    $field = Mage::getModel('bs_setting/field');
                    $field->setId($fieldId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_setting')->__('Total of %d field dependance were successfully deleted.', count($fieldIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_setting')->__('There was an error deleting field dependance.')
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
        $fieldIds = $this->getRequest()->getParam('field');
        if (!is_array($fieldIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_setting')->__('Please select field dependance.')
            );
        } else {
            try {
                foreach ($fieldIds as $fieldId) {
                $field = Mage::getSingleton('bs_setting/field')->load($fieldId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d field dependance were successfully updated.', count($fieldIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_setting')->__('There was an error updating field dependance.')
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
        $fileName   = 'field.csv';
        $content    = $this->getLayout()->createBlock('bs_setting/adminhtml_field_grid')
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
        $fileName   = 'field.xls';
        $content    = $this->getLayout()->createBlock('bs_setting/adminhtml_field_grid')
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
        $fileName   = 'field.xml';
        $content    = $this->getLayout()->createBlock('bs_setting/adminhtml_field_grid')
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
        return true;//Mage::getSingleton('admin/session')->isAllowed('system/field');
    }
}
