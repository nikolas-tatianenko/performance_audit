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
   * @param string $database
   *   Database name.
   * @param string $host
   *   Host.
   */
  function __construct($username, $password = NULL, $database = NULL, $host = 'localhost') {
    $this->link = mysql_connect($host, $username, $password);

    if (!$this->link) {
      die('Fail: ' . mysql_error());
    }

    if ($database) {
      $this->dbname = $database;
      mysql_select_db($database, $this->link) or die(mysql_error());
    }
  }

  /**
   * Destructor.
   */
  function __destruct() {
    mysql_close($this->link);
  }
}
