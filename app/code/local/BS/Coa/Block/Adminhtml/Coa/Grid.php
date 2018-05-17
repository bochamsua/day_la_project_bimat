<?php
/**
 * BS_Coa extension
 * 
 * @category       BS
 * @package        BS_Coa
 * @copyright      Copyright (c) 2018
 */
/**
 * Corrective Action admin grid block
 *
 * @category    BS
 * @package     BS_Coa
 * @author Bui Phong
 */
class BS_Coa_Block_Adminhtml_Coa_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('coaGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Coa_Block_Adminhtml_Coa_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_coa/coa')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Coa_Block_Adminhtml_Coa_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_coa')->__('Ref No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );

        $this->addColumn(
            'ref_type',
            [
                'header'    => Mage::helper('bs_coa')->__('Source'),
                'align'     => 'left',
                'index'     => 'ref_type',
            ]
        );

        $this->addColumn(
            'ins_id',
            [
                'header' => Mage::helper('bs_misc')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, true, true, true, true, false,false, false),

            ]
        );

        $depts = Mage::getResourceModel('bs_misc/department_collection');
        $depts = $depts->toOptionHash();
        $this->addColumn(
            'dept_id',
            [
                'header'    => Mage::helper('bs_misc')->__('Dept'),
                'index'     => 'dept_id',
                'type'      => 'options',
                'options'   => $depts,

            ]
        );


        $this->addColumn(
            'description',
            [
                'header' => Mage::helper('bs_coa')->__('Description'),
                'index'  => 'description',
                'type'=> 'text',

            ]
        );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_coa')->__('Issue Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_coa')->__('Expire Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'close_date',
            [
                'header' => Mage::helper('bs_coa')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            ]
        );

        $this->addColumn(
            'coa_status',
            [
                'header' => Mage::helper('bs_coa')->__('Status'),
                'index'  => 'coa_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_coa')->convertOptions(
                    Mage::getModel('bs_coa/coa_attribute_source_coastatus')->getAllOptions(false)
                )

            ]
        );

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_coa')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_coa')->__('Enabled'),
                    '0' => Mage::helper('bs_coa')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_coa')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_coa')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_coa')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_coa')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_coa')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Coa_Block_Adminhtml_Coa_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('coa');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_work/coa/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_work/coa/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                [
                    'label'=> Mage::helper('bs_coa')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_coa')->__('Are you sure?')
                ]
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                [
                    'label'      => Mage::helper('bs_coa')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', ['_current'=>true]),
                    'additional' => [
                        'status' => [
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_coa')->__('Status'),
                            'values' => [
                                '1' => Mage::helper('bs_coa')->__('Enabled'),
                                '0' => Mage::helper('bs_coa')->__('Disabled'),
                            ]
                        ]
                    ]
                ]
            );




        $this->getMassactionBlock()->addItem(
            'coa_status',
            [
                'label'      => Mage::helper('bs_coa')->__('Change Status'),
                'url'        => $this->getUrl('*/*/massCoaStatus', ['_current'=>true]),
                'additional' => [
                    'flag_coa_status' => [
                        'name'   => 'flag_coa_status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_coa')->__('Status'),
                        'values' => Mage::getModel('bs_coa/coa_attribute_source_coastatus')
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
     * @param BS_Coa_Model_Coa
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
     * @return BS_Coa_Block_Adminhtml_Coa_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
