<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Certificate admin grid block
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Certificate_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('certificateGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Certificate_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $currentUserId = Mage::getSingleton('admin/session')->getUser()->getId();
        $collection = Mage::getModel('bs_hr/certificate')
            ->getCollection()->addFieldToFilter('ins_id', $currentUserId);
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Certificate_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_hr')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );
        $this->addColumn(
            'cert_desc',
            array(
                'header'    => Mage::helper('bs_hr')->__('Description'),
                'align'     => 'left',
                'index'     => 'cert_desc',
            )
        );


        /*$ins = Mage::getResourceModel('admin/user_collection')->addFieldToFilter('user_id', array('gt' => 1));
        $insHash = array();
        foreach ($ins as $in) {
            $insHash[$in->getUserId()] = $in->getFirstname().' '. $in->getLastname();
        }
        $this->addColumn(
            'ins_id',
            array(
                'header'    => Mage::helper('bs_hr')->__('Inspector'),
                'index'     => 'ins_id',
                'type'      => 'options',
                'options'   => $insHash,
                'renderer'  => 'bs_hr/adminhtml_helper_column_renderer_parent',
                'params'    => array(
                    'user_id'    => 'getInsId'
                ),
                'base_link' => 'adminhtml/permissions_user/edit'
            )
        );*/
        $this->addColumn(
            'crs_approved',
            array(
                'header' => Mage::helper('bs_hr')->__('CRS Approved Date'),
                'index'  => 'crs_approved',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'crs_expire',
            array(
                'header' => Mage::helper('bs_hr')->__('CRS Expire Date'),
                'index'  => 'crs_expire',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'caav_approved',
            array(
                'header' => Mage::helper('bs_hr')->__('CAAV Approved Date'),
                'index'  => 'caav_approved',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'caav_expire',
            array(
                'header' => Mage::helper('bs_hr')->__('CAAV Expire Date'),
                'index'  => 'caav_expire',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'ac_id',
            array(
                'header' => Mage::helper('bs_hr')->__('Aircraft'),
                'index'  => 'ac_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'certtype_id',
            array(
                'header' => Mage::helper('bs_hr')->__('Cert Type'),
                'index'  => 'certtype_id',
                'type'=> 'number',

            )
        );

//        $this->addColumn(
//            'action',
//            array(
//                'header'  =>  Mage::helper('bs_hr')->__('Action'),
//                'width'   => '100',
//                'type'    => 'action',
//                'getter'  => 'getId',
//                'actions' => array(
//                    array(
//                        'caption' => Mage::helper('bs_hr')->__('Edit'),
//                        'url'     => array('base'=> '*/*/edit'),
//                        'field'   => 'id'
//                    )
//                ),
//                'filter'    => false,
//                'is_system' => true,
//                'sortable'  => false,
//            )
//        );
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_hr')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('bs_hr')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_hr')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Certificate_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('certificate');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_hr/certificate/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_hr/certificate/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                array(
                    'label'=> Mage::helper('bs_hr')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_hr')->__('Are you sure?')
                )
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                array(
                    'label'      => Mage::helper('bs_hr')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                    'additional' => array(
                        'status' => array(
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_hr')->__('Status'),
                            'values' => array(
                                '1' => Mage::helper('bs_hr')->__('Enabled'),
                                '0' => Mage::helper('bs_hr')->__('Disabled'),
                            )
                        )
                    )
                )
            );




        }
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_HR_Model_Certificate
     * @return string
     * @author Bui Phong
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
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
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Certificate_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
