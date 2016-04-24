<?php
/**
 * @file Bacis file for tests.
 */
include_once('autoload.php');

use src\Collectors\Mysql\GetMysqlInfo;

$test = new GetMysqlInfo('root', '');
$data = $test->getInfo();
var_dump($data);
