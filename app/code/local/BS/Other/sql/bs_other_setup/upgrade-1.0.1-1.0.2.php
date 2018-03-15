<?php
/**
 * BS_Other extension
 * 
 * @category       BS
 * @package        BS_Other
 * @copyright      Copyright (c) 2016
 */
/**
 * Other module install script
 *
 * @category    BS
 * @package     BS_Other
 * @author Bui Phong
 */
$this->startSetup();
$this->getConnection()->changeColumn($this->getTable('bs_other/other'), 'date_report','report_date', 'DATE NULL DEFAULT NULL');

$this->endSetup();
