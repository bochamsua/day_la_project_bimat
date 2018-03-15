<?php
/**
 * BS_NCause extension
 * 
 * @category       BS
 * @package        BS_NCause
 * @copyright      Copyright (c) 2016
 */
/**
 * Root Cause Code admin controller
 *
 * @category    BS
 * @package     BS_NCause
 * @author Bui Phong
 */
class BS_NCause_Adminhtml_Ncause_NcausegroupController extends BS_Sur_Controller_Adminhtml_Sur
{
    /**
     * init the cause group
     *
     * @access protected
     * @return BS_NCause_Model_Ncausegroup
     */
    protected function _initNcausegroup()
    {
        $ncausegroupId  = (int) $this->getRequest()->getParam('id');
        $ncausegroup    = Mage::getModel('bs_ncause/ncausegroup');
        if ($ncausegroupId) {
            $ncausegroup->load($ncausegroupId);
        }
        Mage::register('current_ncausegroup', $ncausegroup);
        return $ncausegroup;
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
        $this->_title(Mage::helper('bs_ncause')->__('Root Cause Sub Code'))
             ->_title(Mage::helper('bs_ncause')->__('Root Cause Codes'));
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
     * edit cause group - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function editAction()
    {
        $ncausegroupId    = $this->getRequest()->getParam('id');
        $ncausegroup      = $this->_initNcausegroup();
        if ($ncausegroupId && !$ncausegroup->getId()) {
            $this->_getSession()->addError(
                Mage::helper('bs_ncause')->__('This cause group no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getNcausegroupData(true);
        if (!empty($data)) {
            $ncausegroup->setData($data);
        }
        Mage::register('ncausegroup_data', $ncausegroup);
        $this->loadLayout();
        $this->_title(Mage::helper('bs_ncause')->__('Root Cause Sub Code'))
             ->_title(Mage::helper('bs_ncause')->__('Root Cause Codes'));
        if ($ncausegroup->getId()) {
            $this->_title($ncausegroup->getGroupCode());
        } else {
            $this->_title(Mage::helper('bs_ncause')->__('Add cause group'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new cause group action
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
     * save cause group - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('ncausegroup')) {
            try {
                $ncausegroup = $this->_initNcausegroup();
                $ncausegroup->addData($data);
                $ncausegroup->save();
                $add = '';
                if($this->getRequest()->getParam('popup')){
                    $add = '<script>window.opener.'.$this->getJsObjectName().'.reload(); window.close()</script>';
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncause')->__('Root Cause Code was successfully saved. %s', $add)
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $ncausegroup->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setNcausegroupData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was a problem saving the cause group.')
                );
                Mage::getSingleton('adminhtml/session')->setNcausegroupData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_ncause')->__('Unable to find cause group to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete cause group - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $ncausegroup = Mage::getModel('bs_ncause/ncausegroup');
                $ncausegroup->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncause')->__('Root Cause Code was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was an error deleting cause group.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('bs_ncause')->__('Could not find cause group to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete cause group - action
     *
     * @access public
     * @return void
     * @author Bui Phong
     */
    public function massDeleteAction()
    {
        $ncausegroupIds = $this->getRequest()->getParam('ncausegroup');
        if (!is_array($ncausegroupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncause')->__('Please select cause groups to delete.')
            );
        } else {
            try {
                foreach ($ncausegroupIds as $ncausegroupId) {
                    $ncausegroup = Mage::getModel('bs_ncause/ncausegroup');
                    $ncausegroup->setId($ncausegroupId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('bs_ncause')->__('Total of %d cause groups were successfully deleted.', count($ncausegroupIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was an error deleting cause groups.')
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
        $ncausegroupIds = $this->getRequest()->getParam('ncausegroup');
        if (!is_array($ncausegroupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('bs_ncause')->__('Please select cause groups.')
            );
        } else {
            try {
                foreach ($ncausegroupIds as $ncausegroupId) {
                $ncausegroup = Mage::getSingleton('bs_ncause/ncausegroup')->load($ncausegroupId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d cause groups were successfully updated.', count($ncausegroupIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('bs_ncause')->__('There was an error updating cause groups.')
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
        $fileName   = 'ncausegroup.csv';
        $content    = $this->getLayout()->createBlock('bs_ncause/adminhtml_ncausegroup_grid')
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
        $fileName   = 'ncausegroup.xls';
        $content    = $this->getLayout()->createBlock('bs_ncause/adminhtml_ncausegroup_grid')
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
        $fileName   = 'ncausegroup.xml';
        $content    = $this->getLayout()->createBlock('bs_ncause/adminhtml_ncausegroup_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }


	public function updateCausesAction(){
		$result = array();
		$groupId = $this->getRequest()->getPost('group_id');
		$result['causes'] = '<option value="">There is no subtask found</option>';
		if($groupId){

			$causes = Mage::getModel('bs_ncause/ncause')->getCollection()->addFieldToFilter('ncausegroup_id', $groupId);


			if($causes->count()){
				$text = '';
				foreach ($causes as $s) {

					$text  .= '<option value="'.$s->getId().'">'.$s->getCauseCode().'</option>';
				}
				$result['causes'] = $text;
			}
		}

		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
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
        return Mage::getSingleton('admin/session')->isAllowed('bs_misc/ncausegroup');
    }
}
