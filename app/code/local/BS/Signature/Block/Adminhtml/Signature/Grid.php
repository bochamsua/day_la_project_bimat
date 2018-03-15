<?php
/**
 * BS_Signature extension
 * 
 * @category       BS
 * @package        BS_Signature
 * @copyright      Copyright (c) 2016
 */
/**
 * Signature admin grid block
 *
 * @category    BS
 * @package     BS_Signature
 * @author Bui Phong
 */
class BS_Signature_Block_Adminhtml_Signature_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('signatureGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Signature_Block_Adminhtml_Signature_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bs_signature/signature')
            ->getCollection();


        $misc = $this->helper('bs_misc');

	    if(!$misc->isAdmin()){
		    $collection->addFieldToFilter('user_id', Mage::getSingleton('admin/session')->getUser()->getUserId());
	    }


        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Signature_Block_Adminhtml_Signature_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_signature')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );*/
        /*$this->addColumn(
            'name',
            array(
                'header'    => Mage::helper('bs_signature')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
            )
        );*/

	    $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', array('gt' => 1))->load();
	    $inspectors = array();
	    foreach ($ins as $in) {
		    $inspectors[$in->getUserId()] = $in->getFirstname().' '.$in->getLastname();
	    }
	    $this->addColumn(
		    'user_id',
		    array(
			    'header'    => Mage::helper('bs_signature')->__('User'),
			    'index'     => 'user_id',
			    'type'      => 'options',
			    'options'   => $inspectors,

		    )
	    );

	    $this->addColumn(
		    'template_file',
		    array(
			    'header' => Mage::helper('bs_signature')->__('Signature'),
			    'type'=> 'text',
			    'renderer'  => 'bs_signature/adminhtml_helper_column_renderer_file'

		    )
	    );


        /*$this->addColumn(
            'update_date',
            array(
                'header' => Mage::helper('bs_signature')->__('Date'),
                'index'  => 'update_date',
                'type'=> 'date',

            )
        );*/
        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_signature')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_signature')->__('Enabled'),
                    '0' => Mage::helper('bs_signature')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_signature')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_signature')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_signature')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_signature')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_signature')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Signature_Block_Adminhtml_Signature_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('signature');

        $this->getMassactionBlock()->addItem('separator', array(
            'label'=> '---Select---',
            'url'  => ''
        ));

        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Signature_Model_Signature
     * @return string
     * @author Bui Phong
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
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
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return BS_Signature_Block_Adminhtml_Signature_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
