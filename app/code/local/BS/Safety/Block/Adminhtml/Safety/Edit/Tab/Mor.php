<?php
class BS_Safety_Block_Adminhtml_Safety_Edit_Tab_Mor extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('morGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout(){
        $this->setChild('add_mor_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('adminhtml')->__('New MOR'),
                    'onclick'   => 'window.open(\''.$this->getUrl('*/mor_mor/new', ['_current'=>false, 'ref_type'=>'safety', 'ref_id'=>$this->getSafety()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        if($this->getSafety()->getId()){
            $html.= $this->getChildHtml('add_mor_button');
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
        $collection = Mage::getModel('bs_mor/mor')
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
                'header'    => Mage::helper('bs_mor')->__('Ref No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );




        $this->addColumn(
            'mor_status',
            [
                'header' => Mage::helper('bs_mor')->__('Status'),
                'index'  => 'mor_status',
                'type'  => 'options',
                'options' => Mage::helper('bs_mor')->convertOptions(
                    Mage::getModel('bs_mor/mor_attribute_source_morstatus')->getAllOptions(false)
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
        return $this->getUrl('*/mor_mor/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/morsGrid', ['_current'=>true]);
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
