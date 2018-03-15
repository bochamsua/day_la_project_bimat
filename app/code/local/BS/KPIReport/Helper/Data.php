<?php
/**
 * BS_KPIReport extension
 * 
 * @category       BS
 * @package        BS_KPIReport
 * @copyright      Copyright (c) 2017
 */
/**
 * KPIReport default helper
 *
 * @category    BS
 * @package     BS_KPIReport
 * @author Bui Phong
 */
class BS_KPIReport_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getIndexes(){
        $indexes = [
            'qsr' => Mage::helper('adminhtml')->__('Quality Surveillance Rate'),
            'ncr' => Mage::helper('adminhtml')->__('Non-Conformity Rate'),
            'mncr' => Mage::helper('adminhtml')->__('Mass Non-Conformity Rate'),
            'mer' => Mage::helper('adminhtml')->__('Maintenance Error Rate'),
            'ser' => Mage::helper('adminhtml')->__('System Error Rate'),
            'rer' => Mage::helper('adminhtml')->__('Repetitive Error Rate'),
            'camt' => Mage::helper('adminhtml')->__('Corrective Action Mean Time'),
            'sdr' => Mage::helper('adminhtml')->__('Self-Detected Rate'),
            'csr' => Mage::helper('adminhtml')->__('Customer Satisfaction Rate'),
            'cir' => Mage::helper('adminhtml')->__('Continuous Improvement Rate'),
            'mir' => Mage::helper('adminhtml')->__('Man-power Improvement Rate'),
            'ppe' => Mage::helper('adminhtml')->__('Production Planning Efficiency'),
        ];
        return $indexes;
    }
    public function updateData($reportKinds, $deptId, $month, $year)
    {
        //first make sure we get the exising value if exists
        $kpiCollection = Mage::getModel('bs_kpireport/kpireport')->getCollection();
        $kpiCollection->addFieldToFilter('dept_id', $deptId);
        $kpiCollection->addFieldToFilter('month', $month);
        $kpiCollection->addFieldToFilter('year', $year);

        if($kpiCollection->getFirstItem()->getId()){
            $kpi = Mage::getModel('bs_kpireport/kpireport')->load($kpiCollection->getFirstItem()->getId());
        }else {
            $kpi = Mage::getModel('bs_kpireport/kpireport');
        }

        $data = [];
        $data['dept_id'] = $deptId;
        $data['month'] = $month;
        $data['year']  = $year;
        foreach ($reportKinds as $reportKind) {
            $function = 'get'.strtoupper($reportKind);
            $value = $this->{$function}($deptId, $month, $year);
            $data[$reportKind] = $value;
        }

        $kpi->addData($data);
        $kpi->save();


    }
    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return float|int
     */
	public function getQSR($deptId, $month, $year ) {
        $massProduction = $this->getKpiData('mass_production', $deptId, $month, $year);
        $surveillances = $this->getSur($deptId, $month, $year);

        if($massProduction > 0){
            return round($surveillances * 1000 / $massProduction, 2);
        }

        return 0;
    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return float|int
     */
    public function getNCR($deptId, $month, $year ) {
        $mandatoryItems = $this->getMandatorySurveillances( $deptId, $month, $year);
        $ncrs = $this->getNCRate($deptId, $month, $year);

        if($mandatoryItems > 0){
            return round($ncrs / $mandatoryItems, 2);
        }

        return 0;
    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return float|int
     */
    public function getMNCR($deptId, $month, $year ) {
        $massNcr = $this->getMassNCR($deptId, $month, $year);
        $massProduction = $this->getKpiData('mass_production', $deptId, $month, $year);

        if($massProduction > 0){
            return round($massNcr  * 1000/ $massProduction, 2);
        }

        return 0;
    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return float|int
     */
    public function getMER($deptId, $month, $year ) {
        $massErrors = $this->getMassError($deptId, $month, $year);
        $massProduction = $this->getKpiData('mass_production', $deptId, $month, $year);

        if($massProduction > 0){
            return round($massErrors * 1000 / $massProduction, 2);
        }

        return 0;
    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return float|int
     */
    public function getSER($deptId, $month, $year ) {
        $massSystemErrors = $this->getMassError($deptId, $month, $year, 2);
        $massErrors = $this->getMassError($deptId, $month, $year);

        if($massErrors > 0){
            return round($massSystemErrors / $massErrors, 2);
        }

        return 0;
    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return float|int
     */
    public function getRER($deptId, $month, $year ) {
        $repetitiveErrors = $this->getNCRate($deptId, $month, $year, null, false, true);
        $ncrs = $this->getNCRate($deptId, $month, $year, null, false);

        if($ncrs > 0){
            return round($repetitiveErrors / $ncrs, 2);
        }

        return 0;
    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return bool|float|int
     */
    public function getCAMT($deptId, $month, $year){
        $period = Mage::helper('bs_report')->getFromTo($month, $year);
        $correctiveTime = 0;
        $requireTime = 0;

        $ncr = Mage::getModel('bs_ncr/ncr')->getCollection();
        $ncr->addFieldToFilter('report_date', array('from' => $period[0]));
        $ncr->addFieldToFilter('report_date', array('to' => $period[1]));
        $ncr->addFieldToFilter('dept_id', $deptId);

        if($ncr->count()){
            foreach ($ncr as $item) {
                $correctiveTime += $this->getDaysBetweenDates($item->getCloseDate(), $item->getReportDate());
                $requireTime += $this->getDaysBetweenDates($item->getDueDate(), $item->getReportDate());
            }
        }

        if($requireTime > 0){
            return round($correctiveTime/$requireTime, 2);
        }

        return 0;


    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return bool|float
     */
    public function getSDR($deptId, $month, $year){

        $selfNCR = $this->getKpiData('self_ncr', $deptId, $month, $year);

        $massProduction = $this->getKpiData('mass_production', $deptId, $month, $year);

        if($massProduction > 0){
            return round($selfNCR * 1000 / $massProduction, 2);
        }

        return 0;


    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return bool|float
     */
    public function getCSR($deptId, $month, $year){

        $complaint = $this->getKpiData('interrelationship_complaint', $deptId, $month, $year);

        $massProduction = $this->getKpiData('mass_production', $deptId, $month, $year);

        if($massProduction > 0){
            return round($complaint * 1000 / $massProduction, 2);
        }

        return 0;


    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return bool|float|int
     */
    public function getCIR($deptId, $month, $year){

        $overDue = $this->getNCRate($deptId, $month, $year, true, false);

        $ncr = $this->getNCRate($deptId, $month, $year, false, false);

        if($ncr > 0){
            return round($overDue / $ncr, 2);
        }

        return 0;


    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return bool|float
     */
    public function getMIR($deptId, $month, $year){

        $humanErrors = $this->getMassError($deptId, $month, $year, 1);

        $manHours = $this->getKpiData('man_hours', $deptId, $month, $year);

        if($manHours > 0){
            return round($humanErrors * 1000 / $manHours, 2);
        }

        return 0;


    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @return bool|float
     */
    public function getPPE($deptId, $month, $year){

        $schedule = $this->getKpiData('schedule_workflow', $deptId, $month, $year);

        $actual = $this->getKpiData('actual_workflow', $deptId, $month, $year);

        if($actual > 0){
            return round(abs($schedule - $actual) * 100/ $actual, 2);
        }

        return 0;


    }

    /**
     * @param $type mass_production, self_ncr, man_hours, schedule_workflow, actual_workflow, interrelationship_complaint,
     * @param $deptId
     * @param $month
     * @param $year
     * @param bool $acType
     * @return float|int
     */
    public function getKpiData($type, $deptId, $month, $year, $acType = false){
        $collection = Mage::getModel('bs_kpi/kpi')->getCollection();
        $collection->addFieldToFilter('dept_id', $deptId);
        $collection->addFieldToFilter('month', $month);
        $collection->addFieldToFilter('year', $year);

        if($acType){
            $collection->addFieldToFilter('ac_type', $acType);
        }

        $result = 0;
        $function = $this->createFunctionFromString($type);
        if($collection->count()){
            foreach ($collection as $item) {
                $result += floatval($item->{$function}());
            }
        }

        return $result;


    }

    public function getSur($deptId, $month, $year) {
        $period = Mage::helper('bs_report')->getFromTo($month, $year);

        $collection = Mage::getModel('bs_sur/sur')->getCollection();
        $collection->addFieldToFilter('report_date', array('from' => $period[0]));
        $collection->addFieldToFilter('report_date', array('to' => $period[1]));
        $collection->addFieldToFilter('dept_id', $deptId);

        return $collection->count();

    }

	public function getNCRate($deptId, $month, $year, $overdue = false, $exclude= true, $repetitive = false) {
        //exclude cmr, cofa

    	$period = Mage::helper('bs_report')->getFromTo($month, $year);

    	//NCR
        $result = 0;
		$ncr = Mage::getModel('bs_ncr/ncr')->getCollection();
        $ncr->addFieldToFilter('report_date', array('from' => $period[0]));
        $ncr->addFieldToFilter('report_date', array('to' => $period[1]));
        $ncr->addFieldToFilter('dept_id', $deptId);

        if($exclude){
            $ncr->addFieldToFilter('ref_type', ['nin' => ['cmr','cofa']]);
        }

		if($overdue){
            $ncr->addFieldToFilter('ncr_status', ['in' => [4,6]]);
        }

        if($repetitive){
            $ncr->addFieldToFilter('repetitive', true);
        }

		if($ncr->count()){
		    $result += $ncr->count();
        }

        //CAR
        $car = Mage::getModel('bs_car/car')->getCollection();
        $car->addFieldToFilter('report_date', array('from' => $period[0]));
        $car->addFieldToFilter('report_date', array('to' => $period[1]));
        $car->addFieldToFilter('dept_id', $deptId);

        if($exclude){
            $car->addFieldToFilter('ref_type', ['nin' => ['cmr','cofa']]);
        }

        if($overdue){
            $car->addFieldToFilter('car_status', ['in' => [3,4]]);
        }

        if($repetitive){
            $car->addFieldToFilter('repetitive', true);
        }

        if($car->count()){
            $result += $car->count();
        }


        return $result;

    }

    public function getMassNCR($deptId, $month, $year) {

        $period = Mage::helper('bs_report')->getFromTo($month, $year);

        //HAN
        $result = 0;
        $collection = Mage::getModel('bs_ncr/ncr')->getCollection();
        $collection->addFieldToFilter('report_date', array('from' => $period[0]));
        $collection->addFieldToFilter('report_date', array('to' => $period[1]));
        $collection->addFieldToFilter('dept_id', $deptId);

        if($collection->count()){
            foreach ($collection as $item) {
                $result += floatval($item->getPoint());
            }
        }


        return $result;

    }

    public function getMandatorySurveillances($deptId, $month, $year){

        $period = Mage::helper('bs_report')->getFromTo($month, $year);

        $collection = Mage::getModel('bs_sur/sur')->getCollection();
        $collection->addFieldToFilter('report_date', array('from' => $period[0]));
        $collection->addFieldToFilter('report_date', array('to' => $period[1]));
        $collection->addFieldToFilter('dept_id', $deptId);

        $result = 0;
        foreach ($collection as $item) {
            if($taskId = $item->getTaskId()){
                //$mandatory = $this->getMandatorySubtaskFromTaskId($taskId);
                $mandatory = $item->getMandatoryItems();
                $result += $mandatory;
            }

        }

        return $result;

    }

    /**
     * @param $deptId
     * @param $month
     * @param $year
     * @param int $errorType 0 - none, 1 - human, 2 - system
     * @param bool $repetitive
     * @return int
     */
    public function getMassError($deptId, $month, $year, $errorType = null, $repetitive = false){
        $period = Mage::helper('bs_report')->getFromTo($month, $year);
        $result = 0;

        //Get IR first
        $ir = Mage::getModel('bs_ir/ir')->getCollection();
        $ir->addFieldToFilter('report_date', array('from' => $period[0]));
        $ir->addFieldToFilter('report_date', array('to' => $period[1]));
        $ir->addFieldToFilter('dept_id', $deptId);
        if($repetitive){
            $ir->addFieldToFilter('repetitive', $repetitive);
        }
        if($errorType == 0){
            $ir->addFieldToFilter('error_type', [['eq' => 0], ['null' => true]]);
        }elseif($errorType > 0) {
            $ir->addFieldToFilter('error_type', $errorType);
        }



        if($ir->count()){
            $result += $ir->count();
        }


        return $result;



    }

    public function getMandatorySubtaskFromTaskId($taskId){
        $subtasks = Mage::getModel('bs_misc/subtask')->getCollection();
        $subtasks->addFieldToFilter('task_id', $taskId);
        $subtasks->addFieldToFilter('is_mandatory', true);

        if($subtasks->count()){
            return $subtasks->count();
        }

        return 0;
    }

    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author Bui Phong
     */
    public function convertOptions($options)
    {
        $converted = array();
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }


    public function createFunctionFromString($string){
        $string = trim($string);
        $string = explode("_", $string);
        $function = 'get';
        foreach ($string as $item) {
            $function .= ucfirst($item);
        }

        return $function;
    }

    public function getDaysBetweenDates($date1, $date2){
        $d1 = date_create($date1);
        $d2 = date_create($date2);

        $diff = date_diff($d2, $d1);


        return abs(floatval($diff->format("%a")));
    }
}
