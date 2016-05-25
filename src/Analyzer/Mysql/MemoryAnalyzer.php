<?php
/**
 * @file
 * Memory Analyzer.
 */
namespace src\Analyzer\Mysql;

use src\Collectors\Mysql\MysqlInfo;

class MemoryAnalyzer {
  private $type;
  private $data;
  private $SQLuser;
  private $SQLpassword;

  function __construct($SQLuser, $SQLpassword, $type) {
    $this->type = $type;
    $this->SQLuser = $SQLuser;
    $this->SQLpassword = $SQLpassword;
    $class = new MysqlInfo(SQLuser, SQLpass);
    $this->data = $class->getInfo();
    $this->options = $this->getOptions();
  }

  function getSupportedOptions() {
    switch ($this->type) {
      case 'basic':
        return array(
          'max_allowed_packet',
          'max_connections'
        );
        break;

      case 'all':
        break;
    }
  }

  function getOptions() {
    $options = array();
    $supported_options = array_intersect(array_keys($this->data), $this->getSupportedOptions());
    foreach ($supported_options as $option) {
      $options[$option] = $this->data[$option];
    }

    return $options;
  }
}
