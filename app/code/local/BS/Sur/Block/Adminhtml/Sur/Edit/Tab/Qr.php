<?php
class BS_Sur_Block_Adminhtml_Sur_Edit_Tab_Qr extends Mage_Adminhtml_Block_Widget_Grid
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
                    'onclick'   => 'window.open(\''.$this->getUrl('*/qr_qr/new', ['_current'=>false, 'ref_type'=>'sur', 'task_id'=>$this->getSur()->getTaskId(), 'ref_id'=>$this->getSur()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        if($this->getSur()->getId()){
            $html.= $this->getChildHtml('add_qr_button');
        }else {
            $html .= 'Please save Sur first';
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
        $collection = Mage::getModel('bs_qr/qr')
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
            'ins_id',
            [
                'header' => Mage::helper('bs_qr')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'number',

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
            'ref_doc',
            [
                'header' => Mage::helper('bs_qr')->__('Ref Doc'),
                'index'  => 'ref_doc',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'ac',
            [
                'header' => Mage::helper('bs_qr')->__('A/C'),
                'index'  => 'ac',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'qr_type',
            [
                'header' => Mage::helper('bs_qr')->__('Type'),
                'index'  => 'qr_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_qr')->convertOptions(
                    Mage::getModel('bs_qr/qr_attribute_source_qrtype')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_qr')->__('Due Date'),
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
