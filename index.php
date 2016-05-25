<?php
/**
 * @file
 * Basic file for tests.
 */
include_once('autoload.php');

use src\Collectors\Mysql\MysqlInfo;
use src\Analyzer\Mysql\MemoryAnalyzer;
use src\Collectors\Mysql\AnalyseDBAndTable;

// Set config variables.
define('SQLuser', 'root');
define('SQLpass', '');

// =================
// MySQL get ini.
// ==================
$test = new MysqlInfo(SQLuser, SQLpass);
$data = $test->getInfo();
$analyzer = new MemoryAnalyzer(SQLuser, SQLpass, 'basic');
var_dump($analyzer);

//$test = new AnalyseDBAndTable(SQLuser, SQLpass);
//$data = $test->getInfoColumns('d8_dev', 'config');
//$data = $test->showTables();