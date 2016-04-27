<?php

namespace PhpRobotRemoteServer;

require './vendor/autoload.php';

use \PhpRobotRemoteServer\RobotRemoteServer;

$argvCount = count($argv);
if ($argvCount < 2) {
	die("Missing parameter: path to the keywords implementation in PHP\n");
} else if ($argvCount > 2) {
	die("Too many parameters: only one parameter required\n");
}

$server = new RobotRemoteServer();
$server->init($argv[1]);
$server->start();
