<?php
/**
 * @file
 * Basic Sql Class.
 */

namespace src\Collectors\Mysql;


abstract class Basic {
  protected $link = NULL;

  /**
   * Get Class method during class creation.
   *
   * @param string $username
   *   Username.
   * @param string $password
   *   Password.
   * @param string $dbname
   *   Database name.
   * @param string $host
   *   Host.
   */
  function __construct($username, $password, $dbname = NULL, $host = 'localhost') {
    $this->link = mysql_connect($host, $username, $password);
    if (!$this->link) {
      die('Fail: ' . mysql_error());
    }
  }

  /**
   * Destructor.
   */
  function __destruct() {
    mysql_close($this->link);
  }
}
