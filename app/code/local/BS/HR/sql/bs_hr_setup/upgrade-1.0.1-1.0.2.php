<?php

$this->startSetup();
$this->run("insert into `bs_hr_staff` (`user_id`) (select `user_id` from `admin_user`)");
$this->run("update `bs_hr_staff` set room = 1, region = 1");


$this->endSetup();
