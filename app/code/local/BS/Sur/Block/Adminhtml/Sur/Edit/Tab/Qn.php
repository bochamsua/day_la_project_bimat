<?php
class BS_Sur_Block_Adminhtml_Sur_Edit_Tab_Qn extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('qnGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareLayout(){
        $this->setChild('add_qn_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('adminhtml')->__('New QN'),
                    'onclick'   => 'window.open(\''.$this->getUrl('*/qn_qn/new', ['_current'=>false, 'ref_type'=>'sur', 'task_id'=>$this->getSur()->getTaskId(), 'ref_id'=>$this->getSur()->getId(),'popup'=>true]).'\',\'\',\'width=1000,height=700,resizable=1,scrollbars=1\')'
                ])
        );


        parent::_prepareLayout();
    }


    public function getMainButtonsHtml()
    {
        $html = '';
        if($this->getSur()->getId()){
            $html.= $this->getChildHtml('add_qn_button');
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
        $collection = Mage::getModel('bs_qn/qn')
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
                'header' => Mage::helper('bs_qn')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number', 'filter' => false
            )
        );*/
        $this->addColumn(
            'ref_no',
            [
                'header'    => Mage::helper('bs_qn')->__('Reference No'),
                'align'     => 'left',
                'index'     => 'ref_no',
            ]
        );


        $this->addColumn(
            'ins_id',
            [
                'header' => Mage::helper('bs_qn')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'number',

            ]
        );
        $this->addColumn(
            'report_date',
            [
                'header' => Mage::helper('bs_qn')->__('Report Date'),
                'index'  => 'report_date',
                'type'=> 'date',

            ]
        );
        $this->addColumn(
            'ref_doc',
            [
                'header' => Mage::helper('bs_qn')->__('Ref Doc'),
                'index'  => 'ref_doc',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'ac',
            [
                'header' => Mage::helper('bs_qn')->__('A/C'),
                'index'  => 'ac',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'qn_type',
            [
                'header' => Mage::helper('bs_qn')->__('Type'),
                'index'  => 'qn_type',
                'type'  => 'options',
                'options' => Mage::helper('bs_qn')->convertOptions(
                    Mage::getModel('bs_qn/qn_attribute_source_qntype')->getAllOptions(false)
                )

            ]
        );
        $this->addColumn(
            'due_date',
            [
                'header' => Mage::helper('bs_qn')->__('Due Date'),
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
        return $this->getUrl('*/qn_qn/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/qnsGrid', ['_current'=>true]);
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
