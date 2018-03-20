<?php
//chdir(__FILE__);
require_once 'app/Mage.php';

umask(0);
Mage::app();

$storeId = '0';

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);


$query = Mage::app()->getRequest()->getParam('q');

if($query){

	$resource = Mage::getSingleton('core/resource');
	$writeConnection = $resource->getConnection('core_write');
	$readConnection = $resource->getConnection('core_read');

	$sql = "";
	if($query == 'all'){
		$sql = "
				TRUNCATE TABLE `bs_car_car`;
				TRUNCATE TABLE `bs_investigation_investigation`;
				TRUNCATE TABLE `bs_ncr_ncr`;
				TRUNCATE TABLE `bs_qrqn_qrqn`;
				TRUNCATE TABLE `bs_rii_rii`;
				TRUNCATE TABLE `bs_signoff_signoff`;
				TRUNCATE TABLE `bs_surveillance_base`;
				TRUNCATE TABLE `bs_surveillance_line`;
				TRUNCATE TABLE `bs_surveillance_shop`;
				TRUNCATE TABLE `bs_surveillance_cmr`;
				TRUNCATE TABLE `bs_surveillance_cofa`;
				
				";
	}else {
		$queryArr = explode(",", $query);
		foreach ( $queryArr as $item ) {
			if($item == 'car'){
				$sql .= "TRUNCATE TABLE `bs_car_car`;";
			}
			if($item == 'inves'){
				$sql .= "TRUNCATE TABLE `bs_investigation_investigation`;";
			}
			if($item == 'ncr'){
				$sql .= "TRUNCATE TABLE `bs_ncr_ncr`;";
			}
			if($item == 'qrqn'){
				$sql .= "TRUNCATE TABLE `bs_qrqn_qrqn`;";
			}
			if($item == 'rii'){
				$sql .= "TRUNCATE TABLE `bs_rii_rii`;";
			}
			if($item == 'signoff'){
				$sql .= "TRUNCATE TABLE `bs_signoff_signoff`;";
			}
			if($item == 'base'){
				$sql .= "TRUNCATE TABLE `bs_surveillance_base`;";
			}

			if($item == 'line'){
				$sql .= "TRUNCATE TABLE `bs_surveillance_line`;";
			}

			if($item == 'shop'){
				$sql .= "TRUNCATE TABLE `bs_surveillance_shop`;";
			}

			if($item == 'cmr'){
				$sql .= "TRUNCATE TABLE `bs_surveillance_cmr`;";
			}

			if($item == 'cofa'){
				$sql .= "TRUNCATE TABLE `bs_surveillance_cofa`;";
			}

		}
	}

	try {
		$writeConnection->query($sql);

		$show = str_replace("TRUNCATE TABLE", "", $sql);
		$show = str_replace(";", "<br>", $show);
		echo "Done <br> {$show}";

	}catch (Exception $e){
		echo $e->getMessage();
	}
}else {
	echo "Please input query (q)";
}












