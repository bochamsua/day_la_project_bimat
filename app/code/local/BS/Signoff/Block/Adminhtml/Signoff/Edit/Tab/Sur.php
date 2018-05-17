<?php
class BS_Signoff_Block_Adminhtml_Signoff_Edit_Tab_Sur extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('surGrid');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
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
        $currentSignOff = $this->getSignoff();
        $acReg = $currentSignOff->getAcReg();
        $fromDate = $currentSignOff->getStartDate();
        $toDate = $currentSignOff->getCloseDate();

        if(is_null($fromDate)){
            $fromDate = '2018-05-01';
        }
        $collection = Mage::getModel('bs_sur/sur')
            ->getCollection()
            //->addFieldToFilter('taskgroup_id', 1)
            ->addFieldToFilter('report_date', ['from' => $fromDate])
		    ->addFieldToFilter('report_date', ['to' => $toDate])
            ->addFieldToFilter('ac_reg', $acReg)
            //->addFieldToFilter('ref_type', 'signoff')
            //->addFieldToFilter('ref_id', $this->getSignoff()->getId())
        ;
        //$collection->getSelect()->order('subcon_order');

        $sql = $collection->getSelect()->__toString();
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
            'ins_id',
            [
                'header' => Mage::helper('bs_misc')->__('Inspector'),
                'index'  => 'ins_id',
                'type'=> 'options',
                'options'   => Mage::helper('bs_misc/user')->getUsers(false, true, true, true, true, false,false, false),
            ]
        );

        $this->addColumn(
            'remark_text',
            [
                'header'    => Mage::helper('bs_ncr')->__('Remark (Outstanding Note)'),
                'align'     => 'left',
                'index'     => 'remark_text',
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
        return $this->getUrl('*/sur_sur/edit', ['id' => $row->getId()]);
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
        return $this->getUrl('*/*/sursGrid', ['_current'=>true]);
    }

    public function getSignoff()
    {
        return Mage::registry('current_signoff');
    }

}
