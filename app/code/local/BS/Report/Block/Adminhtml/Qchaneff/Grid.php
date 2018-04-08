<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * QC HAN Evaluation admin grid block
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Block_Adminhtml_Qchaneff_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('qchaneffGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setDefaultLimit(100);
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(false);
        $this->setUseAjax(true);
    }

	protected function _prepareLayout(){
		$this->setChild('update_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
			     ->setData([
				     'label'     => Mage::helper('adminhtml')->__('Update'),
				     'onclick'   => 'updateButtonSubmit()'
                 ])
		);

		parent::_prepareLayout();
	}

	public function getMainButtonsHtml()
	{
		$html = '';
		if($this->getFilterVisibility()){
			//$html.= $this->getResetFilterButtonHtml();
			//$html.= $this->getSearchButtonHtml();


		}
		$isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_evaluation/qchaneff/edit");
		if($isAllowedEdit){
			$html.= $this->getChildHtml('update_button');
		}

		return $html;

	}

    /**
     * prepare collection
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Qchaneff_Grid
     * @author Bui Phong
     */
    protected function _prepareCollection()
    {
	    $month = Mage::getModel('core/date')->date('m', now());
	    $year = Mage::getModel('core/date')->date('Y', now());

	    $requestData = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));

	    if(count($requestData)){
	    	$month = $requestData['month'];
	    	$year = $requestData['year'];
	    }


        $collection = Mage::getModel('bs_report/qchaneff')
            ->getCollection();

	    $collection->addFieldToFilter('month', $month);
	    $collection->addFieldToFilter('year', $year);
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Qchaneff_Grid
     * @author Bui Phong
     */
    protected function _prepareColumns()
    {
        /*$this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('bs_report')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );*/
        /*$this->addColumn(
            'name',
            array(
                'header'    => Mage::helper('bs_report')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
            )
        );
        

        $this->addColumn(
            'from_date',
            array(
                'header' => Mage::helper('bs_report')->__('From Date'),
                'index'  => 'from_date',
                'type'=> 'date',

            )
        );
        $this->addColumn(
            'to_date',
            array(
                'header' => Mage::helper('bs_report')->__('To Date'),
                'index'  => 'to_date',
                'type'=> 'date',

            )
        );*/

	    $ins = Mage::getModel('admin/user')->getCollection()->addFieldToFilter('user_id', ['gt' => 1])->load();
	    $inspectors = [];
	    foreach ($ins as $in) {
		    $inspectors[$in->getUserId()] = $in->getFirstname().' '.$in->getLastname();
	    }
	    $this->addColumn(
		    'ins_id',
		    [
			    'header'    => Mage::helper('bs_report')->__('Inspector'),
			    'index'     => 'ins_id',
			    'type'      => 'options',
			    'options'   => $inspectors,

            ]
	    );


        $this->addColumn(
            'ir',
            [
                'header' => Mage::helper('bs_report')->__('IR'),
                'index'  => 'ir',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'ncr',
            [
                'header' => Mage::helper('bs_report')->__('NCR'),
                'index'  => 'ncr',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'drr',
            [
                'header' => Mage::helper('bs_report')->__('DRR'),
                'index'  => 'drr',
                'type'=> 'text',

            ]
        );

	    $this->addColumn(
		    'qr',
		    [
			    'header' => Mage::helper('bs_report')->__('QR'),
			    'index'  => 'qr',
			    'type'=> 'text',

            ]
	    );
        $this->addColumn(
            'qcwork',
            [
                'header' => Mage::helper('bs_report')->__('QC Work'),
                'index'  => 'qcwork',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'd1',
            [
                'header' => Mage::helper('bs_report')->__('D1'),
                'index'  => 'd1',
                'type'=> 'text',

            ]
        );

        $editable = false;
	    if(Mage::getSingleton('admin/session')->isAllowed('bs_evaluation/qchaneff/edit')){
		    $editable = true;
	    }

	    if($editable){
		    $this->addColumn(
			    'd2',
			    [
				    'header' => Mage::helper('bs_report')->__('D2'),
				    'index'  => 'd2',
				    'editable'       => true,
				    'type'=> 'input',
				    'renderer'      => 'bs_report/adminhtml_helper_column_renderer_input',

                ]
		    );

		    $this->addColumn(
			    'd3',
			    [
				    'header' => Mage::helper('bs_report')->__('D3'),
				    'index'  => 'd3',
				    'editable'       => true,
				    'type'=> 'input',
				    'renderer'      => 'bs_report/adminhtml_helper_column_renderer_input',

                ]
		    );

	    }else {
		    $this->addColumn(
			    'd2',
			    [
				    'header' => Mage::helper('bs_report')->__('D2'),
				    'index'  => 'd2',
				    'type'=> 'text',

                ]
		    );

		    $this->addColumn(
			    'd3',
			    [
				    'header' => Mage::helper('bs_report')->__('D3'),
				    'index'  => 'd3',
				    'type'=> 'text',

                ]
		    );

	    }


        $this->addColumn(
            'dall',
            [
                'header' => Mage::helper('bs_report')->__('D'),
                'index'  => 'dall',
                'type'=> 'text',

            ]
        );
        $this->addColumn(
            'level',
            [
                'header' => Mage::helper('bs_report')->__('Level'),
                'index'  => 'level',
                'type'=> 'text',

            ]
        );

        if($editable){
	        $this->addColumn(
		        'remark',
		        [
			        'header' => Mage::helper('bs_report')->__('Remark'),
			        'index'  => 'remark',
			        'editable'       => true,
			        'type'=> 'input',
			        'renderer'      => 'bs_report/adminhtml_helper_column_renderer_input',
			        'inline_css'    => ' input-text-full'

                ]
	        );
        }else {
	        $this->addColumn(
		        'remark',
		        [
			        'header' => Mage::helper('bs_report')->__('Remark'),
			        'index'  => 'remark',
			        'type'=> 'text',

                ]
	        );
        }

        /*$this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('bs_report')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('bs_report')->__('Enabled'),
                    '0' => Mage::helper('bs_report')->__('Disabled'),
                )
            )
        );*/

        //$this->addColumn(
        //    'action',
        //    array(
        //        'header'  =>  Mage::helper('bs_report')->__('Action'),
        //        'width'   => '100',
        //        'type'    => 'action',
        //        'getter'  => 'getId',
        //        'actions' => array(
        //            array(
        //                'caption' => Mage::helper('bs_report')->__('Edit'),
        //                'url'     => array('base'=> '*/*/edit'),
        //                'field'   => 'id'
        //            )
        //        ),
        //        'filter'    => false,
        //        'is_system' => true,
        //       'sortable'  => false,
        //    )
        //);
        //$this->addExportType('*/*/exportCsv', Mage::helper('bs_report')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('bs_report')->__('Excel'));
        //$this->addExportType('*/*/exportXml', Mage::helper('bs_report')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Qchaneff_Grid
     * @author Bui Phong
     */
    protected function _prepareMassaction()
    {
	    return $this;
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('qchaneff');

	    $this->getMassactionBlock()->addItem(
		    'donothing',
		    [
			    'label'=> Mage::helper('bs_report')->__('Do nothing'),
			    'url'  => $this->getUrl('*/*/'),
            ]
	    );



        $isAllowedEdit = Mage::getSingleton('admin/session')->isAllowed("bs_evaluation/qchaneff/edit");
        $isAllowedDelete = Mage::getSingleton('admin/session')->isAllowed("bs_evaluation/qchaneff/delete");

        if($isAllowedDelete){
            $this->getMassactionBlock()->addItem(
                'delete',
                [
                    'label'=> Mage::helper('bs_report')->__('Delete'),
                    'url'  => $this->getUrl('*/*/massDelete'),
                    'confirm'  => Mage::helper('bs_report')->__('Are you sure?')
                ]
            );
        }

        if($isAllowedEdit){
            $this->getMassactionBlock()->addItem(
                'status',
                [
                    'label'      => Mage::helper('bs_report')->__('Change status'),
                    'url'        => $this->getUrl('*/*/massStatus', ['_current'=>true]),
                    'additional' => [
                        'status' => [
                            'name'   => 'status',
                            'type'   => 'select',
                            'class'  => 'required-entry',
                            'label'  => Mage::helper('bs_report')->__('Status'),
                            'values' => [
                                '1' => Mage::helper('bs_report')->__('Enabled'),
                                '0' => Mage::helper('bs_report')->__('Disabled'),
                            ]
                        ]
                    ]
                ]
            );




        }
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param BS_Report_Model_Qchaneff
     * @return string
     * @author Bui Phong
     */
    public function getRowUrl($row)
    {
        return $this;//->getUrl('*/*/edit', array('id' => $row->getId()));
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
        return $this->getUrl('*/*/grid', ['_current'=>true]);
    }

    /**
     * after collection load
     *
     * @access protected
     * @return BS_Report_Block_Adminhtml_Qchaneff_Grid
     * @author Bui Phong
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
