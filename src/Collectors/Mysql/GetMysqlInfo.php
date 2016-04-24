<?php
/**
 * @file
 * Get Mysql Info
 */

namespace src\Collectors\Mysql;

class GetMysqlInfo extends Basic {

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
  function __construct($username, $password, $dbname = '', $host = 'localhost') {
    parent::__construct($username, $password, $dbname, $host);

    return $this->getInfo();
  }

  /**
   * Get sql data.
   *
   * @return array
   *   Array with sql variabels.
   */
  function getInfo() {
    $result = mysql_query('SHOW VARIABLES');
    while ($row = mysql_fetch_assoc($result)) {
      $data[$row['Variable_name']] = $row['Value'];
    }

    return $data;
  }
}
