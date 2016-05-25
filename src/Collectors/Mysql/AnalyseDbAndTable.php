<?php
/**
 * @file
 * Class 'AnalyseDbAndTable'
 */

namespace src\Collectors\Mysql;


class AnalyseDbAndTable extends Basic {

  /**
   * Analyse table.
   *
   * @param string $database
   *   Database.
   *
   * @return array
   *   Array with sql variabels.
   */
  function getInfo($database = '') {
    if (!$database) {
      $database = $this->database;
    }
    $query = "SELECT * FROM information_schema.tables WHERE table_schema = '$database'";

    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result)) {
      $data[] = $row;
    }

    return $data;
  }

  function getInfoColumns($database = '', $table_name) {

    if (!$database) {
      $database = $this->database;
    }

    $query = "SELECT * FROM information_schema.columns WHERE table_schema = '$database' and table_name ='$table_name'";

    $result = mysql_query($query);

    while ($row = mysql_fetch_assoc($result)) {
      $data[] = $row;
    }

    return $data;
  }
}
