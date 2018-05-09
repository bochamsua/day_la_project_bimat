<?php
class BS_Ir_Block_Adminhtml_Ir_Edit_Tab_Coa extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout(){
        $this->setChild('add_coa_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('adminhtml')->__('New COA'),
                    'onclick'   => 'window.open(\''.$this->getUrl('*/coa_coa/new', ['_current'=>false, 'ref_type'=>'ir', 'ref_id'=>$this->getIr()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        if($this->getIr()->getId()){
            $html.= $this->getChildHtml('add_coa_button');
        }else {
            $html .= 'Please save IR first';
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
        $collection = Mage::getModel('bs_coa/coa')
            ->getCollection()
            //->addFieldToFilter('taskgroup_id', 1)
            ->addFieldToFilter('ref_type', 'ir')
            ->addFieldToFilter('ref_id', $this->getIr()->getId())
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
                'header' => Mage::helper('bs_qr')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );*/
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_coa')->__('Ref No'),
                'align'     => 'left',
                'index'     => 'ref_no',
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
        return $this->getUrl('*/coa_coa/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/coasGrid', ['_current'=>true]);
    }

    public function getIr()
    {
        return Mage::registry('current_ir');
    }


    protected function _afterToHtml($html)
    {

        $html1 = "<script>

                </script>";
        return parent::_afterToHtml($html);
    }
}
