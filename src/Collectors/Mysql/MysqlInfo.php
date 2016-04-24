<?php
/**
 * @file
 * Get Mysql Info
 */

namespace src\Collectors\Mysql;

class MysqlInfo extends Basic {

  /**
   * Get sql data.
   *
   * @param string $variable
   *   Variable for query.
   *
   * @return array
   *   Array with sql variabels.
   */
  function getInfo($variable = '') {
    $query = 'SHOW VARIABLES';
    if ($variable) {
      $query .= " LIKE '%$variable%'";
    }
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
      $data[$row['Variable_name']] = $row['Value'];
    }

    return $data;
  }
}
