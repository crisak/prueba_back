<?php
/**
 * Created by PhpStorm.
 * User: jhon
 * Date: 9/10/17
 * Time: 03:11 PM
 */

 $config = require __DIR__ . '/../../app/config/config.php';

sleep(15);
file_get_contents($config->application->serverUrl.'/api_devel/employee/VerifyPushOrder/'.$argv[1]);
