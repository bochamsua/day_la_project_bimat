<?php
class BS_Other_Block_Adminhtml_Other_Edit_Tab_Drr extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('drrGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout(){
        $this->setChild('add_drr_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('adminhtml')->__('New DRR'),
                    'onclick'   => 'window.open(\''.$this->getUrl('*/drr_drr/new', ['_current'=>false, 'ref_type'=>'other', 'task_id'=>$this->getOther()->getTaskId(), 'ref_id'=>$this->getOther()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        if($this->getOther()->getId()){
            $html.= $this->getChildHtml('add_drr_button');
        }else {
            $html .= 'Please save Other first';
        }

        //$html.= $this->getResetFilterButtonHtml();
        //$html.= $this->getSearchButtonHtml();
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
        $collection = Mage::getModel('bs_drr/drr')
            ->getCollection()
            //->addFieldToFilter('taskgroup_id', 1)
            ->addFieldToFilter('ref_type', 'other')
            ->addFieldToFilter('ref_id', $this->getOther()->getId())
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
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_drr')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );


        $this->addColumn(
            'ins_id',
            [
                'header' => Mage::helper('bs_drr')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, true, true, true, true, false,false, false),

            ]
        );
        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_drr')->__('Report Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'ref_doc',
            [
                'header' => Mage::helper('bs_drr')->__('Ref Doc'),
                'index'  => 'ref_doc',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'ac',
            [
                'header' => Mage::helper('bs_drr')->__('A/C'),
                'index'  => 'ac',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'qr_type',
            [
                'header' => Mage::helper('bs_drr')->__('Type'),
                'index'  => 'qr_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_drr')->convertOptions(
                    Mage::getModel('bs_drr/drr_attribute_source_qrtype')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_drr')->__('Due Date'),
                'index'  => 'due_date',
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
        return $this->getUrl('*/drr_drr/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/drrsGrid', ['_current'=>true]);
    }

    public function getOther()
    {
        return Mage::registry('current_other');
    }


    protected function _afterToHtml($html)
    {

        $html1 = "<script>

                </script>";
        return parent::_afterToHtml($html);
    }
}
