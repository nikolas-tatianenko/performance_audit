<?php
/**
 * @file
 * Get Mysql Info
 */

namespace src\Collectors\Mysql;

class GetMysqlInfo extends Basic {

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
