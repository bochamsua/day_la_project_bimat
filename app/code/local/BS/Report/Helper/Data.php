<?php
/**
 * BS_Report extension
 * 
 * @category       BS
 * @package        BS_Report
 * @copyright      Copyright (c) 2017
 */
/**
 * Report default helper
 *
 * @category    BS
 * @package     BS_Report
 * @author Bui Phong
 */
class BS_Report_Helper_Data extends Mage_Core_Helper_Abstract
{
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
        $converted = [];
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }

    public function getMonthYearBetween($fromMonth, $fromYear, $toMonth, $toYear){
        if(!isset($fromMonth) || !isset($fromYear) || !isset($toMonth) || !isset($toYear)){
            return false;
        }

        if($fromMonth <= 12) {
            if ($toMonth > 12) {
                $toMonth = 12;
            }
            $result = [];
            if($fromYear == $toYear){//same year

                if($fromMonth <= $toMonth){
                    for($i = $fromMonth; $i <= $toMonth; $i++){
                        $result[] = [$i, $fromYear];
                    }

                    return $result;

                }

                return false;
            }elseif ($fromYear < $toYear){
                $diff = $toYear - $fromYear;
                for($i = $fromYear; $i <= $toYear; $i++){
                    if($i == $fromYear){
                        for($j = $fromMonth; $j <= 12; $j++){
                            $result[] = [$j,$fromYear];
                        }
                    }elseif ($i == $toYear){
                        for($j = 1; $j <= $toMonth; $j++){
                            $result[] = [$j, $toYear];
                        }
                    }else {
                        for($j = 1; $j <= 12; $j++){
                            $result[] = [$j, $i];
                        }
                    }

                }

                return $result;
            }

        }





        return false;
    }

    public function getPreviousMonthYear($currentMonth, $currentYear, $period = 6){

        if(!$currentMonth){
            $currentMonth = Mage::getModel('core/date')->date('m', now());
        }
        if(!$currentYear){
            $currentYear = Mage::getModel('core/date')->date('Y', now());
        }


        $currentDate = new DateTime( $currentYear."-".$currentMonth);

        $currentDate->sub(new DateInterval("P".$period."M"));

        $previousMonth = $currentDate->format("m");
        $previousYear = $currentDate->format("Y");

        $result = $this->getMonthYearBetween($previousMonth, $previousYear, $currentMonth, $currentYear);

        //remove last element
        //unset($result[count($result)-1]);

        return $result;
    }

    public function getFromTo($month = null, $year = null, $full = false){

        if(!$month){
            $month = Mage::helper('bs_misc/date')->getNowUtcDate(null, "MM");
        }

        if(!$year){
            $year = Mage::helper('bs_misc/date')->getNowUtcDate(null, "y");
        }

        $fullDate = Mage::helper('bs_misc/date')->getNowUtcDate(null, "ddMMy");

        $days = $this->getDaysInMonth($month, $year);
        $from = $year.'-'.$month.'-01';
        $to = $year.'-'.$month.'-'.$days;

        $fromDate = Mage::helper('bs_misc/date')->getUtcDate($from);
        $toDate = Mage::helper('bs_misc/date')->getUtcDate($to);

        //$fromDate = Mage::getModel('core/date')->date('Y-m-d', $from);
        //$toDate = Mage::getModel('core/date')->date('Y-m-d', $to);

        if($full){
            return [$fromDate, $toDate, $fullDate];
        }

        return [$fromDate, $toDate];
    }


    public function buildMonthYearQuery($fromMonth, $fromYear, $toMonth, $toYear){
        $between = $this->getMonthYearBetween($fromMonth, $fromYear, $toMonth, $toYear);
        if($between){
            $result = [];
            foreach ($between as $item) {
                $result[] = "(month = {$item[0]} AND year = {$item[1]})";
            }

            return implode(" OR ", $result);
        }

        return false;
    }


    public function checkReport($month, $year){
    	$collection = Mage::getModel('bs_report/qchaneff')->getCollection()
		    ->addFieldToFilter('month', $month)
		    ->addFieldToFilter('year', $year)
		    ;

    	if($collection->count()){
    		return true;
	    }

	    return false;
    }

	public function checkWorkday($year){
		$collection = Mage::getModel('bs_report/workday')->getCollection()
		                  ->addFieldToFilter('year', $year)
		;

		if($collection->count()){
			return true;
		}

		return false;
	}

	public function initReport($month, $year){
        $inspectors = Mage::getModel('admin/user')->getCollection();
        $inspectors->addFieldToFilter('region', 1);
        $inspectors->addFieldToFilter('section', 1);

        $inspectors->getSelect()->where("user_id IN(SELECT user_id FROM admin_role WHERE parent_id IN(6,7,12))");

		foreach ( $inspectors as $item ) {
			//we get info for each staff
			$isActive = $item->getIsActive();
			if($isActive){
				$this->createReport($item->getUserId(), $month, $year);
			}


		}
	}

	public function refreshReport($month, $year){
		$collection = Mage::getModel('bs_report/qchaneff')->getCollection()
		                  ->addFieldToFilter('month', $month)
		                  ->addFieldToFilter('year', $year)
		;

		if($collection->count()){
			foreach ( $collection as $item ) {

				$insId = $item->getInsId();
				$data = $this->calculateData($insId, $month, $year, $item);
				$data['entity_id'] = $item->getId();

				$this->insertData($data);
			}
		}

		

	}

	public function calculateData($insId, $month, $year, $item = false) {//if parse item, it means we refresh data, so we'll keep d2,d3
		if($month < 10){
			$month = '0'.$month;
		}
		$days = $this->getDaysInMonth($month, $year);
		$from = $year.'-'.$month.'-01';
		$to = $year.'-'.$month.'-'.$days;

		$fromDate = Mage::getModel('core/date')->date('Y-m-d', $from);
		$toDate = Mage::getModel('core/date')->date('Y-m-d', $to);


		//work days
		$workdays = 22;
		$workday = Mage::getModel('bs_report/workday')->getCollection()
		               ->addFieldToFilter('month', $month)
		               ->addFieldToFilter('year', $year)
		;
		if($workday->getFirstItem()->getId()){
			$workdays = $workday->getFirstItem()->getDays();
		}

		$d1 = $this->getD1($insId, $fromDate, $toDate, $workdays);

		$data = $d1;

		//d2 & d3
		$d2 = $this->getSetting('d2');
		$d3 = $this->getSetting('d3');

		if($item){//refresh data instead of reset
		    $d2 = floatval($item->getD2());
		    $d3 = floatval($item->getD3());
        }

		$data['d2'] = $d2;
		$data['d3'] = $d3;

		$dAll = 0.5 * $data['d1'] + 0.3 * $d2 + 0.2 * $d3;

		$dAll = round($dAll, 2);

		$data['dall'] = $dAll;

		$level = $this->getLevel($dAll);

		$data['level'] = $level;

		$data['month'] = $month;
		$data['year']   = $year;

		return $data;
	}

	public function createReport($insId, $month, $year){

		$data = $this->calculateData($insId, $month, $year);

	    $this->insertData($data);

    }

    public function getD1($insId, $fromDate, $toDate, $workdays){
		//get Routine Points
	    $routinePoints = 0;
        $routinePoints += $this->getRoutinePoints($insId, $fromDate, $toDate);


	    //get products points
	    $irPoints = $this->getProductPoints('ir', $insId, $fromDate, $toDate);
	    $ncrPoints = $this->getProductPoints('ncr', $insId, $fromDate, $toDate, [4,5]);
	    $drrPoints = $this->getProductPoints('drr', $insId, $fromDate, $toDate, [4,5]);//drr
	    $qrPoints = $this->getProductPoints('qr', $insId, $fromDate, $toDate);

	    //rii point
	    $riiPoints = $this->getProductPoints('rii', $insId, $fromDate, $toDate, null, 'report_date', 'report_date');
	    $signoffPoints = $this->getProductPoints('signoff', $insId, $fromDate, $toDate, null, 'close_date');

	    //Mage::log('ins: '.$insId.', rii: '.$riiPoints.', signoff: '.$signoffPoints);

	    //get other points
	    $otherPoints = $this->getOtherPoints($insId, $fromDate, $toDate);
	    //$otherPoints += $qrPoints;

	    //Total QC work points
	    $qcWorkPoints = $routinePoints + $otherPoints + $riiPoints + $signoffPoints;

	    //Calculate D1
	    $d1 = ($irPoints + $ncrPoints + $drrPoints + $qrPoints + $qcWorkPoints)/$workdays;
	    $d1 = round($d1, 2);

	    return [
	    	'ins_id'    => $insId,
	    	'ir'       => $irPoints,
		    'ncr'       => $ncrPoints,
		    'drr'       => $drrPoints,
		    'qr'        => $qrPoints,
		    'qcwork'    => $qcWorkPoints,
		    'd1'        => $d1
        ];
    }

	public function getDaysInMonth($month, $year)
	{
		// calculate number of days in a month
		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	}

	public function getMonths($toArray = false) {
		$months = [];

		for($i=1; $i <= 12; $i++){
			$label = $i;
			if($label < 10){
				$label = '0'.$label;
			}
			if($toArray){
				$months[] = [
					'label' => $label,
					'value' => $i
                ];
			}else {
				$months[$i] = $label;
			}

		}

		return $months;
	}

	public function getYears($hash = false){
		$years = [];
		for($i=2016; $i < 2050; $i++){
			if($hash){
				$years[] = [
					'label' => $i,
					'value' => $i
                ];
			}else {
				$years[$i] = $i;
			}

		}

		return $years;
	}

	public function getWorkingDays($startDate, $endDate, $holidays){
		// do strtotime calculations just once
		$endDate = strtotime($endDate);
		$startDate = strtotime($startDate);


		//The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
		//We add one to inlude both dates in the interval.
		$days = ($endDate - $startDate) / 86400 + 1;

		$no_full_weeks = floor($days / 7);
		$no_remaining_days = fmod($days, 7);

		//It will return 1 if it's Monday,.. ,7 for Sunday
		$the_first_day_of_week = date("N", $startDate);
		$the_last_day_of_week = date("N", $endDate);

		//---->The two can be equal in leap years when february has 29 days, the equal sign is added here
		//In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
		if ($the_first_day_of_week <= $the_last_day_of_week) {
			if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
			if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
		}
		else {
			// (edit by Tokes to fix an edge case where the start day was a Sunday
			// and the end day was NOT a Saturday)

			// the day of the week for start is later than the day of the week for end
			if ($the_first_day_of_week == 7) {
				// if the start date is a Sunday, then we definitely subtract 1 day
				$no_remaining_days--;

				if ($the_last_day_of_week == 6) {
					// if the end date is a Saturday, then we subtract another day
					$no_remaining_days--;
				}
			}
			else {
				// the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
				// so we skip an entire weekend and subtract 2 days
				$no_remaining_days -= 2;
			}
		}

		//The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
		//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
		$workingDays = $no_full_weeks * 5;
		if ($no_remaining_days > 0 )
		{
			$workingDays += $no_remaining_days;
		}

		//We subtract the holidays
		foreach($holidays as $holiday){
			$time_stamp=strtotime($holiday);
			//If the holiday doesn't fall in weekend
			if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
				$workingDays--;
		}

		return $workingDays;
	}

	public function getPointsFromTaskId($taskId){
		$task = Mage::getSingleton('bs_misc/task')->load($taskId);

		return (float)$task->getPoints();
	}

	public function getSetting($code, $default = 3.5, $format = 'floatval'){
		$setting = Mage::getModel('bs_report/setting')->getCollection()->addFieldToFilter('code', $code)->getFirstItem();
		if($setting->getId()){
			return $format($setting->getValue());
		}
		return $default;//default?
	}

	public function getRoutinePoints($insId, $fromDate, $toDate){
		$model = Mage::getModel('bs_sur/sur')->getCollection();
		$model->addFieldToFilter('report_date', ['from' => $fromDate]);
		$model->addFieldToFilter('report_date', ['to' => $toDate]);
		$model->addFieldToFilter('ins_id', $insId);

		$points = 0;
		if($model->count()){
			foreach ( $model as $item ) {
				if($item->getTaskId()){
					$points += $this->getPointsFromTaskId($item->getTaskId());
				}

			}
		}

		return $points;
	}

	public function getProductPoints($modelName, $insId, $fromDate, $toDate, $exclude = [], $dateCode = 'report_date', $groupBy = ''){
		$model = Mage::getModel('bs_'.$modelName.'/'.$modelName)->getCollection();
		$model->addFieldToFilter($dateCode, ['from' => $fromDate]);
		$model->addFieldToFilter($dateCode, ['to' => $toDate]);
		$model->addFieldToFilter('ins_id', $insId);

		//dont count cmr
        $model->addFieldToFilter('ref_type', [
            ['null' => true],
            ['neq'=>'cmr']
        ]);

        //$str = $model->getSelect()->__toString();

		$exclStatuses = [];

		switch ($modelName){
            case 'drr':
                $exclStatuses = [0];
                break;
            case 'ncr':
                $exclStatuses = [0,1,5];
                break;
            case 'ir':
                $exclStatuses = [0,1,5];
                break;
            case 'qr':
                $exclStatuses = [0,1];
                break;
        }

		if(count($exclStatuses)){
            $model->addFieldToFilter($modelName.'_status', ['nin'=>$exclStatuses]);
        }




		if(count($exclude)){
			$model->getSelect()->where("task_id NOT IN (SELECT entity_id FROM bs_misc_task WHERE taskgroup_id IN (".implode(",", $exclude)."))");
			//$model->addFieldToFilter('taskgroup_id', array('nin' => $exclude));
		}

		if($groupBy != ''){
            $model->getSelect()->group($groupBy);
        }


		$count = 0;
		if($model->count()){
			$count = $model->count();
		}

		$settingPoint = $this->getSetting($modelName, 1);


		return $count * $settingPoint;

	}

	public function getOtherPoints($insId, $fromDate, $toDate){
		$model = Mage::getModel('bs_other/other')->getCollection();
		$model->addFieldToFilter('report_date', ['from' => $fromDate]);
		$model->addFieldToFilter('report_date', ['to' => $toDate]);
		$model->addFieldToFilter('ins_id', $insId);


		$points = 0;
		if($model->count()){
			foreach ( $model as $item ) {
				if($item->getTaskId()){
					$points += $this->getPointsFromTaskId($item->getTaskId());
				}

			}
		}

		return $points;

	}

	public function getLevel($d){
		$match = [
			[0,1.75,1],
			[1.75,2,2],
			[2,2.25,3],
			[2.25,2.5,4],
			[2.5,2.75,5],
			[2.75,3,6],
			[3,3.5,7],
			[3.5,4,8],
			[4,4.5,9],
			[5,100,10],
        ];

		foreach ( $match as $item ) {
			if($d < $item[1] && $d >= $item[0]){
				return $item[2];
			}
		}
		return false;
	}

	public function insertData($data) {

		$model = Mage::getModel('bs_report/qchaneff');
		if($data['entity_id']){
			$model->load($data['entity_id']);
		}

		try {
			$model->addData($data);
			return $model->save();
		}catch (Exception $e){
			return false;
		}



	}


//$holidays=array("2008-12-25","2008-12-26","2009-01-01");

//echo getWorkingDays("2008-12-22","2009-01-02",$holidays)
}
