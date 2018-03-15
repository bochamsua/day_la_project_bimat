<?php
require_once(dirname(__FILE__).'/../public/boot.php');
require_once(SG_DATABASE_PATH.'SGDatabase.php');
require_once(SG_BACKUP_PATH.'SGBackup.php');

class BackupGuard_BackupGuardPlatinum_Model_Cron
{
	public function run()
	{
		$coreResource = Mage::getSingleton('core/resource');
		$cronSchedule = $coreResource->getTableName('cron_schedule');

		$query = "SELECT * FROM $cronSchedule WHERE job_code='backupguard_backup'";
		$sgdb = SGDatabase::getInstance();
		$results = $sgdb->query($query);
		$ids = array();

		foreach ($results as $res) {
			$scheduleTime = strtotime($res['scheduled_at']);
			if($scheduleTime >= (time() - 300) && time() > $scheduleTime){
				$ids[] = (int)$res['messages'];
			}
		}

		require_once(dirname(__FILE__).'/../public/cron/sg_backup.php');
		require_once(SG_SCHEDULE_PATH.'SGScheduleAdapterMagento.php');

		$sgBackup = new SGBackup();

		foreach ($ids as $id) {
			$schedule = $sgBackup->getScheduleParamsById($id);
			$schedule = json_decode($schedule['schedule_options'], true);
			SGScheduleAdapterMagento::create($schedule['cronTab'], $id);
		}

		return $this;
	}
}
