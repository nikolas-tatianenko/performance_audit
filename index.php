<?php
/**
 * @file Bacis file for tests.
 */
include_once('autoload.php');

use src\Collectors\Mysql\MysqlInfo;

$test = new MysqlInfo('root', '');
$data = $test->getInfo();
var_dump($data);
