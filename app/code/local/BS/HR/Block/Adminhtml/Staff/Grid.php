<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2017
 */
/**
 * Staff admin grid block
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Staff_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Bui Phong
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('staffGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Staff_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_hr/staff')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Staff_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_hr')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            ]
        );

	    $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1])->load();
	    $inspectors = [];
	    foreach ($ins as $in) {
		    $inspectors[$in->getUserId()] = $in->getFirstname().' '.$in->getLastname();
	    }

	    $this->addColumn(
		    'user_id',
		    [
			    'header'    => Mage::helper('bs_hr')->__('Admin User'),
			    'type'     => 'options',
			    'index'     => 'user_id',
			    'options'   => $inspectors,
            ]
	    );




        $this->addColumn(
            'region',
            [
                'header' => Mage::helper('bs_sur')->__('Region'),
                'index'  => 'region',
                'type'  => 'options',
                'options' => Mage::helper('bs_sur')->convertOptions(
                    Mage::getModel('bs_sur/sur_attribute_source_region')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'section',
            [
                'header' => Mage::helper('bs_sur')->__('Section'),
                'index'  => 'section',
                'type'  => 'options',
                'options' => Mage::helper('bs_sur')->convertOptions(
                    Mage::getModel('bs_sur/sur_attribute_source_section')->getAllOptions(false)
                )

            ]
        );
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_hr')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_hr')->__('Enabled'),
                    '0' => Mage::helper('bs_hr')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_hr')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_hr')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_hr')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_hr')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_hr')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Staff_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('staff');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_hr/staff/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_hr/staff/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                [
                    'label'=> Mage::helper('bs_hr')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_hr')->__('Are you sure?')
                ]
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                [
                    'label'      => Mage::helper('bs_hr')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', ['_current'=>true]),
                    'additional' => [
                        'status' => [
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_hr')->__('Status'),
                            'values' => [
                                '1' => Mage::helper('bs_hr')->__('Enabled'),
                                '0' => Mage::helper('bs_hr')->__('Disabled'),
                            ]
                        ]
                    ]
                ]
            );




        $this->getMassactionBlock()->addItem(
            'room',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Room'),
                'url'        => $this->getUrl('*/*/massRoom', ['_current'=>true]),
                'additional' => [
                    'flag_room' => [
                        'name'   => 'flag_room',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Room'),
                        'values' => Mage::getModel('bs_hr/staff_attribute_source_room')
                            ->getAllOptions(true),

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'region',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Region'),
                'url'        => $this->getUrl('*/*/massRegion', ['_current'=>true]),
                'additional' => [
                    'flag_region' => [
                        'name'   => 'flag_region',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Region'),
                        'values' => Mage::getModel('bs_hr/staff_attribute_source_region')
                            ->getAllOptions(true),

                    ]
                ]
            ]
        );
        }
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_HR_Model_Staff
     * @return string
     * @author Bui Phong
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['id' => $row->getId()]);
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Bui Phong
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current'=>true]);
    }

    /**
     * after collection load
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Staff_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
