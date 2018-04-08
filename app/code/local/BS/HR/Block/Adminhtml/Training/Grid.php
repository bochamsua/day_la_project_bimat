<?php
/**
 * BS_HR extension
 * 
 * @category       BS
 * @package        BS_HR
 * @copyright      Copyright (c) 2016
 */
/**
 * Training admin grid block
 *
 * @category    BS
 * @package     BS_HR
 * @author Bui Phong
 */
class BS_HR_Block_Adminhtml_Training_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('trainingGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Training_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $currentUserId = Mage::getSingleton('admin/session')->getUser()->getId();
        $collection = Mage::getModel('bs_hr/training')
            ->getCollection()->addFieldToFilter('ins_id', $currentUserId);
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_HR_Block_Adminhtml_Training_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('bs_hr')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            ]
        );
        $this->addColumn(
            'training_desc',
            [
                'header'    => Mage::helper('bs_hr')->__('Description'),
                'align'     => 'left',
                'index'     => 'training_desc',
            ]
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
            'type_training',
            [
                'header' => Mage::helper('bs_hr')->__('Completed Type training course for at least 2 months?'),
                'index'  => 'type_training',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'line_six',
            [
                'header' => Mage::helper('bs_hr')->__('Line maintenance experience for at least 6 months? '),
                'index'  => 'line_six',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'base_six',
            [
                'header' => Mage::helper('bs_hr')->__('Base maintenance experience for at least 6 months '),
                'index'  => 'base_six',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'crs_a',
            [
                'header' => Mage::helper('bs_hr')->__('Holding CRS A certificate for at least 14 months?'),
                'index'  => 'crs_a',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'line_twelve',
            [
                'header' => Mage::helper('bs_hr')->__('Line maintenance experience for at least 12 months?'),
                'index'  => 'line_twelve',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'base_twelve',
            [
                'header' => Mage::helper('bs_hr')->__('Base maintenance experience for at least 12 months?'),
                'index'  => 'base_twelve',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'crs_b',
            [
                'header' => Mage::helper('bs_hr')->__('Hoding CRS B certificate for at least 38 months?'),
                'index'  => 'crs_b',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'line_twentyfour',
            [
                'header' => Mage::helper('bs_hr')->__('Line maintenance experience for at least 24 months?'),
                'index'  => 'line_twentyfour',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
        );
        $this->addColumn(
            'base_twentyfour',
            [
                'header' => Mage::helper('bs_hr')->__('Base maintenance experience for at least 24 months?'),
                'index'  => 'base_twentyfour',
                'type'    => 'options',
                    'options'    => [
                    '1' => Mage::helper('bs_hr')->__('Yes'),
                    '0' => Mage::helper('bs_hr')->__('No'),
                    ]

            ]
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
     * @return BS_HR_Block_Adminhtml_Training_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('training');

        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_hr/training/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_hr/training/delete");

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
            'type_training',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Completed Type training course for at least 2 months?'),
                'url'        => $this->getUrl('*/*/massTypeTraining', ['_current'=>true]),
                'additional' => [
                    'flag_type_training' => [
                        'name'   => 'flag_type_training',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Completed Type training course for at least 2 months?'),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
                        ]

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'line_six',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Line maintenance experience for at least 6 months? '),
                'url'        => $this->getUrl('*/*/massLineSix', ['_current'=>true]),
                'additional' => [
                    'flag_line_six' => [
                        'name'   => 'flag_line_six',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Line maintenance experience for at least 6 months? '),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
                        ]

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'base_six',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Base maintenance experience for at least 6 months '),
                'url'        => $this->getUrl('*/*/massBaseSix', ['_current'=>true]),
                'additional' => [
                    'flag_base_six' => [
                        'name'   => 'flag_base_six',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Base maintenance experience for at least 6 months '),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
                        ]

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'crs_a',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Holding CRS A certificate for at least 14 months?'),
                'url'        => $this->getUrl('*/*/massCrsA', ['_current'=>true]),
                'additional' => [
                    'flag_crs_a' => [
                        'name'   => 'flag_crs_a',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Holding CRS A certificate for at least 14 months?'),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
                        ]

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'line_twelve',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Line maintenance experience for at least 12 months?'),
                'url'        => $this->getUrl('*/*/massLineTwelve', ['_current'=>true]),
                'additional' => [
                    'flag_line_twelve' => [
                        'name'   => 'flag_line_twelve',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Line maintenance experience for at least 12 months?'),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
                        ]

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'base_twelve',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Base maintenance experience for at least 12 months?'),
                'url'        => $this->getUrl('*/*/massBaseTwelve', ['_current'=>true]),
                'additional' => [
                    'flag_base_twelve' => [
                        'name'   => 'flag_base_twelve',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Base maintenance experience for at least 12 months?'),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
                        ]

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'crs_b',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Hoding CRS B certificate for at least 38 months?'),
                'url'        => $this->getUrl('*/*/massCrsB', ['_current'=>true]),
                'additional' => [
                    'flag_crs_b' => [
                        'name'   => 'flag_crs_b',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Hoding CRS B certificate for at least 38 months?'),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
                        ]

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'line_twentyfour',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Line maintenance experience for at least 24 months?'),
                'url'        => $this->getUrl('*/*/massLineTwentyfour', ['_current'=>true]),
                'additional' => [
                    'flag_line_twentyfour' => [
                        'name'   => 'flag_line_twentyfour',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Line maintenance experience for at least 24 months?'),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
                        ]

                    ]
                ]
            ]
        );
        $this->getMassactionBlock()->addItem(
            'base_twentyfour',
            [
                'label'      => Mage::helper('bs_hr')->__('Change Base maintenance experience for at least 24 months?'),
                'url'        => $this->getUrl('*/*/massBaseTwentyfour', ['_current'=>true]),
                'additional' => [
                    'flag_base_twentyfour' => [
                        'name'   => 'flag_base_twentyfour',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('bs_hr')->__('Base maintenance experience for at least 24 months?'),
                        'values' => [
                                '1' => Mage::helper('bs_hr')->__('Yes'),
                                '0' => Mage::helper('bs_hr')->__('No'),
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
     * @param BS_HR_Model_Training
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
     * @return BS_HR_Block_Adminhtml_Training_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
