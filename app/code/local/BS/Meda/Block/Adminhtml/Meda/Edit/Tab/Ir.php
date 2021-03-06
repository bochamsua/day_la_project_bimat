<?php
class BS_Meda_Block_Adminhtml_Meda_Edit_Tab_Ir extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('irGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout(){
        $this->setChild('add_ir_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('adminhtml')->__('New IR'),
                    'onclick'   => 'window.open(\''.$this->getUrl('*/ir_ir/new', ['_current'=>false, 'ref_type'=>'meda', 'task_id'=>$this->getMeda()->getTaskId(), 'ref_id'=>$this->getMeda()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        if($this->getMeda()->getId()){
            $html.= $this->getChildHtml('add_ir_button');
        }else {
            $html .= 'Please save Meda first';
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
        $collection = Mage::getModel('bs_ir/ir')
            ->getCollection()
            //->addFieldToFilter('taskgroup_id', 1)
            ->addFieldToFilter('ref_type', 'meda')
            ->addFieldToFilter('ref_id', $this->getMeda()->getId())
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
                'header'    => Mage::helper('bs_ir')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );


        $this->addColumn(
            'dept_id',
            [
                'header' => Mage::helper('bs_ir')->__('Maint. Center'),
                'index'  => 'dept_id',
                'type'=> 'number',

            ]
        );
        $this->addColumn(
            'loc_id',
            [
                'header' => Mage::helper('bs_ir')->__('Location'),
                'index'  => 'loc_id',
                'type'=> 'number',

            ]
        );
        $this->addColumn(
            'ac_reg',
            [
                'header' => Mage::helper('bs_ir')->__('A/C Reg'),
                'index'  => 'ac_reg',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'inspection_date',
            [
                'header' => Mage::helper('bs_ir')->__('Date of Inspection'),
                'index'  => 'inspection_date',
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
        return $this->getUrl('*/ir_ir/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/irsGrid', ['_current'=>true]);
    }

    public function getMeda()
    {
        return Mage::registry('current_meda');
    }


    protected function _afterToHtml($html)
    {

        $html1 = "<script>

                </script>";
        return parent::_afterToHtml($html);
    }
}
