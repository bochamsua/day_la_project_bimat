<?php
/**
 * BS_Hira extension
 * 
 * @category       BS
 * @package        BS_Hira
 * @copyright      Copyright (c) 2018
 */
/**
 * HIRA admin grid block
 *
 * @category    BS
 * @package     BS_Hira
 * @author Bui Phong
 */
class BS_Hira_Block_Adminhtml_Hira_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('hiraGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Hira_Block_Adminhtml_Hira_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_hira/hira')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Hira_Block_Adminhtml_Hira_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
       /* $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_hira')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );*/
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_hira')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );


        $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1])->load();
        $inspectors = [];
        foreach ($ins as $in) {
            $inspectors[$in->getUserId()] = strtoupper($in->getUsername());
        }
        $this->addColumn(
            'ins_id',
            [
                'header'    => Mage::helper('bs_misc')->__('Inspector'),
                'index'     => 'ins_id',
                'type'      => 'options',
                'options'   => $inspectors,

            ]
        );

        /*$this->addColumn(
            'report_date',
            array(
                'header' => Mage::helper('bs_hira')->__('Date of Report'),
                'index'  => 'report_date',
                'type'=> 'date',

            )
        );*/

        $this->addColumn(
            'probability_after',
            [
                'header' => Mage::helper('bs_hira')->__('Probability after mitigation'),
                'index'  => 'probability_after',
                'type'  => 'options',
                'options' => Mage::helper('bs_hira')->convertOptions(
                    Mage::getModel('bs_hira/hira_attribute_source_probabilityafter')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'severity_after',
            [
                'header' => Mage::helper('bs_hira')->__('Severity after mitigation'),
                'index'  => 'severity_after',
                'type'  => 'options',
                'options' => Mage::helper('bs_hira')->convertOptions(
                    Mage::getModel('bs_hira/hira_attribute_source_severityafter')->getAllOptions(false)
                )

            ]
        );
        /*$this->addColumn(
            'hira_type',
            array(
                'header' => Mage::helper('bs_hira')->__('Type'),
                'index'  => 'hira_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_hira')->convertOptions(
                    Mage::getModel('bs_hira/hira_attribute_source_hiratype')->getAllOptions(false)
                )

            )
        );*/
        /*$this->addColumn(
            'due_date',
            array(
                'header' => Mage::helper('bs_hira')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'approval_id',
            array(
                'header' => Mage::helper('bs_hira')->__('Approved By'),
                'index'  => 'approval_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'hira_status',
            array(
                'header' => Mage::helper('bs_hira')->__('Status'),
                'index'  => 'hira_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_hira')->convertOptions(
                    Mage::getModel('bs_hira/hira_attribute_source_hirastatus')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'close_date',
            array(
                'header' => Mage::helper('bs_hira')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'reject_reason',
            array(
                'header' => Mage::helper('bs_hira')->__('Reject Reason'),
                'index'  => 'reject_reason',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'taskgroup_id',
            array(
                'header' => Mage::helper('bs_hira')->__('Task Group'),
                'index'  => 'taskgroup_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'task_id',
            array(
                'header' => Mage::helper('bs_hira')->__('Task Id'),
                'index'  => 'task_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'subtask_id',
            array(
                'header' => Mage::helper('bs_hira')->__('Subtask'),
                'index'  => 'subtask_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'ref_id',
            array(
                'header' => Mage::helper('bs_hira')->__('Ref Id'),
                'index'  => 'ref_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'dept_id',
            array(
                'header' => Mage::helper('bs_hira')->__('Dept'),
                'index'  => 'dept_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'loc_id',
            array(
                'header' => Mage::helper('bs_hira')->__('Location'),
                'index'  => 'loc_id',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'section',
            array(
                'header' => Mage::helper('bs_hira')->__('Section'),
                'index'  => 'section',
                'type'=> 'number',

            )
        );
        $this->addColumn(
            'region',
            array(
                'header' => Mage::helper('bs_hira')->__('Region'),
                'index'  => 'region',
                'type'=> 'number',

            )
        );*/
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_hira')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_hira')->__('Enabled'),
                    '0' => Mage::helper('bs_hira')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_hira')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_hira')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_hira')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_hira')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_hira')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Hira_Block_Adminhtml_Hira_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('hira');

        $this->getMassactionBlock()->addItem('separator', [
            'label'=> '---Select---',
            'url'  => ''
        ]);

        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Hira_Model_Hira
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
     * @return BS_Hira_Block_Adminhtml_Hira_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
