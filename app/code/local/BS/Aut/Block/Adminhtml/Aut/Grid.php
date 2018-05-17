<?php
/**
 * BS_Aut extension
 * 
 * @category       BS
 * @package        BS_Aut
 * @copyright      Copyright (c) 2018
 */
/**
 * Authority admin grid block
 *
 * @category    BS
 * @package     BS_Aut
 * @author Bui Phong
 */
class BS_Aut_Block_Adminhtml_Aut_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('autGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Aut_Block_Adminhtml_Aut_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_aut/aut')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Aut_Block_Adminhtml_Aut_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'name',
            [
                'header'    => Mage::helper('bs_aut')->__('Authority'),
                'align'     => 'left',
                'index'     => 'name',
            ]
        );
        

        $this->addColumn(
            'aut_id',
            [
                'header' => Mage::helper('bs_aut')->__('ID'),
                'index'  => 'aut_id',
                'type'=> 'text',

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

        $this->addColumn(
            'approved_scope',
            [
                'header' => Mage::helper('bs_aut')->__('Approved Scope'),
                'index'  => 'approved_scope',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'station',
            [
                'header' => Mage::helper('bs_aut')->__('Station'),
                'index'  => 'station',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'approval_no',
            [
                'header' => Mage::helper('bs_aut')->__('Approval Number'),
                'index'  => 'approval_no',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'issue_date',
            [
                'header' => Mage::helper('bs_aut')->__('Issue Date'),
                'index'  => 'issue_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'expire_date',
            [
                'header' => Mage::helper('bs_aut')->__('Expire Date'),
                'index'  => 'expire_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'remaining',
            [
                'header' => Mage::helper('bs_aut')->__('Remaining'),
                'index'  => 'remaining',
                'type'=> 'number',

            ]
        );

        /*$this->addColumn(
            'aut_status',
            [
                'header' => Mage::helper('bs_aut')->__('Status'),
                'index'  => 'aut_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_aut')->convertOptions(
                    Mage::getModel('bs_aut/aut_attribute_source_autstatus')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'section',
            [
                'header' => Mage::helper('bs_aut')->__('Section'),
                'index'  => 'section',
                'type'=> 'number',

            ]
        );
        $this->addColumn(
            'region',
            [
                'header' => Mage::helper('bs_aut')->__('Region'),
                'index'  => 'region',
                'type'=> 'number',

            ]
        );*/
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_aut')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_aut')->__('Enabled'),
                    '0' => Mage::helper('bs_aut')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_aut')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_aut')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_aut')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_aut')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_aut')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Aut_Block_Adminhtml_Aut_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('aut');

        $this->getMassactionBlock()->addItem('separator', [
            'label'=> '---Select---',
            'url'  => ''
        ]);

        $misc = Mage::helper('bs_misc');
        if($misc->canChangeInspector()){



            $this->getMassactionBlock()->addItem('change_inspector',  [
                'label'      => Mage::helper('bs_aut')->__('Change Ins/Aud'),
                'url'        => $this->getUrl('*/misc_misc/massInspector',
                    [
                        'type' => 'aut'
                    ]
                ),
                'additional' => [
                    'inspector' => [
                        'name'   => 'inspector',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_aut')->__('Ins/Aud'),
                        'values' => Mage::helper('bs_misc/user')->getUsersByManager(true, true)
                    ]
                ]
            ]);



        }
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Aut_Model_Aut
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
     * @return BS_Aut_Block_Adminhtml_Aut_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
