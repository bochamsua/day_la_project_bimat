<?php
    require_once(dirname(__FILE__).'/../boot.php');
    require_once(SG_BACKUP_PATH.'SGBackup.php');

	if (count($ids)) {
		foreach ($ids as $id) {
			$b = new SGBackup();
			$options = $b->getScheduleParamsById($id);

			if ($options) {
				$b->backup(json_decode($options['backup_options'], true));
			}
		}
	}
