<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/../vendor/autoload.php';

$app = new \Controller\App();

$app->initRooting();

$app->run();

$app->commit();

?>