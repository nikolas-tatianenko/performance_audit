<?php
/**
 * @file
 * Class MysqlInfo.
 */
class MysqlInfo {

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

    $result = db_query($query)->fetchAll();

    foreach ($result as $row) {

      $data[$row->Variable_name] = $row->Value;
    }


    return $data;
  }
}
