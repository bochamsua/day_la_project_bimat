<?php
class BS_Concession_Block_Adminhtml_Concession_Edit_Tab_Qr extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('qrGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout(){
        $this->setChild('add_qr_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('adminhtml')->__('New QR'),
                    'onclick'   => 'window.open(\''.$this->getUrl('*/qr_qr/new', ['_current'=>false, 'taskgroup_id'=>11, 'type'=>'co','task_id'=>0, 'ref_id'=>$this->getConcession()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        $html.= $this->getChildHtml('add_qr_button');
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
        $collection = Mage::getModel('bs_qr/qr')
            ->getCollection()
            //->addFieldToFilter('taskgroup_id', 11)
            ->addFieldToFilter('ref_type', 'concession')
            ->addFieldToFilter('ref_id', $this->getConcession()->getId())
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
                'header'    => Mage::helper('bs_qr')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );


        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_qr')->__('Report Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
	    $this->addColumn(
		    'qr_status',
		    [
			    'header' => Mage::helper('bs_qr')->__('Status'),
			    'index'  => 'qr_status',
			    'type'  => 'options',
			    'options' => Mage::helper('bs_qr')->convertOptions(
				    Mage::getModel('bs_qr/qr_attribute_source_qrstatus')->getAllOptions(false)
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
        return $this->getUrl('*/qr_qr/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/qrsGrid', ['_current'=>true]);
    }

	public function getConcession()
	{
		return Mage::registry('current_concession');
	}

    protected function _afterToHtml($html)
    {

        $html1 = "<script>

                </script>";
        return parent::_afterToHtml($html);
    }
}
