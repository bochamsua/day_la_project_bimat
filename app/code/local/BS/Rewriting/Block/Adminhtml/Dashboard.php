<?php
/**
 * Default (Template) Project
 * 
 * @category       BS
 * @package        
 * @copyright      Copyright (c) 2017
 * @author Bui Phong
 */ 
class BS_Rewriting_Block_Adminhtml_Dashboard extends Mage_Adminhtml_Block_Dashboard {

	public function __construct()
	{
		parent::__construct();

        $this->setTemplate('dashboard/index.phtml');


	}

	protected function _prepareLayout()
	{


		/*$this->setChild('grids',
			$this->getLayout()->createBlock('adminhtml/dashboard_grids')
		);*/

		//Custom grids
		$this->setChild('ncr',
			$this->getLayout()->createBlock('bs_ncr/adminhtml_ncr_dashboard_grid')
		);

		$this->setChild('ncrSign',
			$this->getLayout()->createBlock('bs_ncr/adminhtml_ncr_dashboard_ncrsign')
		);

		$this->setChild('qr',
			$this->getLayout()->createBlock('bs_qr/adminhtml_qr_dashboard_grid')
		);

		$this->setChild('qrSign',
			$this->getLayout()->createBlock('bs_qr/adminhtml_qr_dashboard_qrsign')
		);

        $this->setChild('qn',
            $this->getLayout()->createBlock('bs_qn/adminhtml_qn_dashboard_grid')
        );

        $this->setChild('qnSign',
            $this->getLayout()->createBlock('bs_qn/adminhtml_qn_dashboard_qnsign')
        );

		$this->setChild('drr',
			$this->getLayout()->createBlock('bs_drr/adminhtml_drr_dashboard_grid')
		);

		$this->setChild('drrSign',
			$this->getLayout()->createBlock('bs_drr/adminhtml_drr_dashboard_drrsign')
		);

        $this->setChild('car',
            $this->getLayout()->createBlock('bs_car/adminhtml_car_dashboard_grid')
        );

        $this->setChild('carSign',
            $this->getLayout()->createBlock('bs_car/adminhtml_car_dashboard_carsign')
        );

		$this->setChild('ir',
			$this->getLayout()->createBlock('bs_ir/adminhtml_ir_dashboard_grid')
		);

		$this->setChild('irSign',
			$this->getLayout()->createBlock('bs_ir/adminhtml_ir_dashboard_irsign')
		);


        $this->setChild('nrw',
            $this->getLayout()->createBlock('bs_nrw/adminhtml_nrw_dashboard_grid')
        );

        $this->setChild('nrwSign',
            $this->getLayout()->createBlock('bs_nrw/adminhtml_nrw_dashboard_nrwsign')
        );

	}

}