<?php
class BS_Safety_Block_Adminhtml_Safety_Edit_Tab_Meda extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('medaGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout(){
        $this->setChild('add_meda_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('adminhtml')->__('New MEDA'),
                    'onclick'   => 'window.open(\''.$this->getUrl('*/meda_meda/new', ['_current'=>false, 'ref_type'=>'safety', 'ref_id'=>$this->getSafety()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        if($this->getSafety()->getId()){
            $html.= $this->getChildHtml('add_meda_button');
        }else {
            $html .= 'Please save SAFETY first';
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
        $collection = Mage::getModel('bs_meda/meda')
            ->getCollection()
            //->addFieldToFilter('taskgroup_id', 1)
            ->addFieldToFilter('ref_type', 'safety')
            ->addFieldToFilter('ref_id', $this->getSafety()->getId())
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
                'header'    => Mage::helper('bs_meda')->__('Ref No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );




        $this->addColumn(
            'meda_status',
            [
                'header' => Mage::helper('bs_meda')->__('Status'),
                'index'  => 'meda_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_meda')->convertOptions(
                    Mage::getModel('bs_meda/meda_attribute_source_medastatus')->getAllOptions(false)
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
        return $this->getUrl('*/meda_meda/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/medasGrid', ['_current'=>true]);
    }

    public function getSafety()
    {
        return Mage::registry('current_safety');
    }


    protected function _afterToHtml($html)
    {

        $html1 = "<script>

                </script>";
        return parent::_afterToHtml($html);
    }
}
