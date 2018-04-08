<?php
/**
 * BS_Setting extension
 * 
 * @category       BS
 * @package        BS_Setting
 * @copyright      Copyright (c) 2017
 */
/**
 * Field Dependance admin grid block
 *
 * @category    BS
 * @package     BS_Setting
 * @author Bui Phong
 */
class BS_Setting_Block_Adminhtml_Field_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('fieldGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Setting_Block_Adminhtml_Field_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_setting/field')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Setting_Block_Adminhtml_Field_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_setting')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            ]
        );
        $this->addColumn(
            'name',
            [
                'header'    => Mage::helper('bs_setting')->__('Field Name Suffix'),
                'align'     => 'left',
                'index'     => 'name',
            ]
        );
        

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_setting')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_setting')->__('Enabled'),
                    '0' => Mage::helper('bs_setting')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_setting')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_setting')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_setting')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_setting')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_setting')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Setting_Block_Adminhtml_Field_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('field');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("system/field/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("system/field/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                [
                    'label'=> Mage::helper('bs_setting')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_setting')->__('Are you sure?')
                ]
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                [
                    'label'      => Mage::helper('bs_setting')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', ['_current'=>true]),
                    'additional' => [
                        'status' => [
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_setting')->__('Status'),
                            'values' => [
                                '1' => Mage::helper('bs_setting')->__('Enabled'),
                                '0' => Mage::helper('bs_setting')->__('Disabled'),
                            ]
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
     * @param BS_Setting_Model_Field
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
     * @return BS_Setting_Block_Adminhtml_Field_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
