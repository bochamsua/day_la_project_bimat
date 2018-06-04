<?php
class BS_Sur_Block_Adminhtml_Sur_Edit_Tab_Ncr extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('ncrGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout(){
        $this->setChild('add_ncr_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('adminhtml')->__('New NCR'),
                    'onclick'   => 'window.open(\''.$this->getUrl('*/ncr_ncr/new', ['_current'=>false, 'ref_type'=>'sur', 'task_id'=>$this->getSur()->getTaskId(), 'ref_id'=>$this->getSur()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        if($this->getSur()->getId()){
            $html .= $this->getChildHtml('add_ncr_button');
        }else {
            $html .= 'Please save Sur first';
        }

        return $html;

    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Subject_Block_Adminhtml_Subjectcontent_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_ncr/ncr')
            ->getCollection()
            //->addFieldToFilter('taskgroup_id', 1)
            ->addFieldToFilter('ref_type', 'sur')
            ->addFieldToFilter('ref_id', $this->getSur()->getId())
        ;
        //$collection->getSelect()->order('subcon_order');
        $this->setCollection($collection);
        //$this->_prepareTotals('subcon_hour');
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Subject_Block_Adminhtml_Subjectcontent_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_ncr')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );*/

        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_ncr')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );

        $this->addColumn(
            'task_id',
            [
                'header' => Mage::helper('bs_ncr')->__('Code'),
                'index'  => 'task_id',
                'type'  => 'text',
                'renderer' => 'bs_misc/adminhtml_helper_column_renderer_task',

            ]
        );

        $this->addColumn(
            'subtask_id',
            [
                'header' => Mage::helper('bs_ncr')->__('Sub Code'),
                'index'  => 'subtask_id',
                'type'  => 'text',
                'renderer' => 'bs_misc/adminhtml_helper_column_renderer_subtask',

            ]
        );

        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_ncr')->__('Report Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );

        $acTypes = Mage::getModel('bs_misc/aircraft')->getCollection()->toOptionHash();
        $this->addColumn(
            'ac_type',
            [
                'header' => Mage::helper('bs_ncr')->__('A/C Type'),
                'index'     => 'ac_type',
                'type'      => 'options',
                'options'   => $acTypes,

            ]
        );

        $this->addColumn(
            'ac_reg',
            [
                'header' => Mage::helper('bs_ncr')->__('A/C Reg'),
                'index'  => 'ac_reg',
                'type'  => 'text',
                'renderer' => 'bs_acreg/adminhtml_helper_column_renderer_acreg',

            ]
        );

        $this->addColumn(
        'ncr_type',
        [
            'header' => Mage::helper('bs_ncr')->__('Type'),
            'index'  => 'ncr_type',
            'type'  => 'options',
            'options' => Mage::helper('bs_ncr')->convertOptions(
                Mage::getModel('bs_ncr/ncr_attribute_source_ncrtype')->getAllOptions(false)
            )

        ]
    );
        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_ncr')->__('Due Date'),
                'index'  => 'due_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'approval_id',
            [
                'header' => Mage::helper('bs_ncr')->__('Approved By'),
                'index'  => 'approval_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(true, true, true, true, true, false, false, false),
            ]
        );
        $this->addColumn(
            'ncr_status',
            [
                'header' => Mage::helper('bs_ncr')->__('Status'),
                'index'  => 'ncr_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_ncr')->convertOptions(
                    Mage::getModel('bs_ncr/ncr_attribute_source_ncrstatus')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'close_date',
            [
                'header' => Mage::helper('bs_ncr')->__('Close Date'),
                'index'  => 'close_date',
                'type'=> 'date',

            ]
        );

        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);


        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Subject_Block_Adminhtml_Subjectcontent_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {

        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Subject_Model_Subjectcontent
     * @return string
     * @author Bui Phong
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/ncr_ncr/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/ncrsGrid', ['_current'=>true]);
    }

    public function getSur()
    {
        return Mage::registry('current_sur');
    }


    protected function _afterToHtml($html)
    {

        $html1 = "<script>

                </script>";
        return parent::_afterToHtml($html);
    }
}
