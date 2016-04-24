<?php
/**
 * @file
 * Basic Sql Class.
 */

namespace src\Collectors\Mysql;


abstract class Basic {
  protected $link = NULL;

  function __construct($username, $password, $dbname = NULL, $host = 'localhost') {
    $this->link = mysql_connect($host, $username, $password);
    if (!$this->link) {
      die('Fail: ' . mysql_error());
    }
  }

  function __destruct() {
    mysql_close($this->link);
  }
}
