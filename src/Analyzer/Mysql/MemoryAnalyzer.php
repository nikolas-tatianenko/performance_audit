<?php

/**
 * @file
 * Class MemoryAnalyzer.
 */
class MemoryAnalyzer {
  const STATUS_OK = 'status';
  const STATUS_WARNING = 'warning';
  const STATUS_ERROR = 'error';
  private $login;
  private $password;

  /**
   * @var string
   *   Type of the configuration options.
   */
  private $type;
  /**
   * @var array
   *   Array of all configuration options of the provided type.
   */
  private $data;
  /**
   * @var array
   * Array of supported options of the provided type.
   */
  private $options;

  function __construct($login, $password, $type) {
    $this->login = $login;
    $this->password = $password;
    $this->type = $type;

    $collector = new MysqlInfo($this->login, $this->password);
    $this->data = $collector->getInfo();
    $this->options = $this->getOptions();
  }

  function getOptions() {
    $options = array();
    $supported_options = array_intersect(array_keys($this->data), $this->getSupportedOptions());

    foreach ($supported_options as $option) {
      $options[$option] = $this->data[$option];
    }

    return $options;
  }

  function getSupportedOptions() {

    switch ($this->type) {
      // https://www.prestashop.com/blog/en/php-ini-file/

      case PERFORMANCE_AUDIT_MYSQL_INI:
        // @see @todo https://www.drupal.org/requirements/php.
        // @see @todo http://2bits.com/articles/mysql-my-cnf-configuration-for-a-large-drupal-site.html.
        return array(
          'version',
          'key_buffer_size',
          'max_allowed_packet',
          'thread_stack',
          'thread_cache_size',
          'query_cache_limit',
          'query_cache_size',
          'join_buffer_size',
          'max_connections',
        );
        break;

      // @todo define constants inside the class.
    }
  }

  function analyze() {
    $data = array();
    $type_method = 'analyze_configuration_' . $this->type;

    if (method_exists($this, $type_method)) {
      $data['type'] = $this->$type_method();
    }

    foreach ($this->options as $option_name => $option_value) {
      $option_method = 'analyze_' . $option_name;

      if (method_exists($this, $option_method)) {

        $data['options'][] = $this->$option_method($option_name, $option_value);
      }
    }

    return $data;
  }


  function analyze_version($name, $value) {

    $recommendations = array();
    $notes = array();
    $description = t('Version of MYSQL.');

    // 32 MB for Drupal 7 is required.
    $required_value = '5.0.15';
    $integer_value = intval($value['local_value']);
    $recommendations[] = t('Drupal 7 core requires MySQL version  to be at least !limit MB.',
      array('!limit' => $required_value));

    if (version_compare(PHP_VERSION, $required_value) >= 0) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }

    return array(
      'name' => $name,
      'actual' => $value,
      'description' => $description,
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );
  }

  function analyze_key_buffer_size($name, $value) {
    $required_value = 32;
    if ($value > $required_value) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }
    $notes = array();
    $recommendations = array(t('Drupal core requires at least !value MB size', array('!value' => $required_value)));

    return array(
      'name' => $name,
      'actual' => $value,
      'description' => t('Key buffer size'),
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );
  }

  function analyze_max_allowed_packet($name, $value) {
    $required_value = 30;
    if ($value > $required_value) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }
    $notes = array();
    $recommendations = array(t('Drupal core requires at least !value MB size', array('!value' => $required_value)));
    return array(
      'name' => $name,
      'actual' => $value,
      'description' => t('Max allowed connections'),
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );
  }

  function analyze_thread_stack($name, $value) {
    $required_value = 32;
    if ($value > $required_value) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }
    $notes = array();
    $recommendations = array(t('Drupal core requires at least !value MB size', array('!value' => $required_value)));
    return array(
      'name' => $name,
      'actual' => $value,
      'description' => t('Thread stack'),
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );
  }

  function analyze_thread_cache_size($name, $value) {
    $required_value = 32;
    if ($value > $required_value) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }
    $notes = array();
    $recommendations = array(t('Drupal core requires at least !value MB size', array('!value' => $required_value)));
    return array(
      'name' => $name,
      'actual' => $value,
      'description' => t('Thread cache size'),
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );
  }

  function analyze_query_cache_limit($name, $value) {
    $required_value = 8;
    if ($value > $required_value) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }
    $notes = array();
    $recommendations = array(t('Drupal core requires at least !value MB size', array('!value' => $required_value)));
    return array(
      'name' => $name,
      'actual' => $value,
      'description' => t('Query cache limit'),
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );
  }

  function analyze_query_cache_size($name, $value) {
    $required_value = 32;
    if ($value > $required_value) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }

    $notes = array();
    $recommendations = array(t('Drupal core requires at least !value MB size', array('!value' => $required_value)));

    return array(
      'name' => $name,
      'actual' => $value,
      'description' => t('Max amount of connections'),
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );

  }

  function analyze_join_buffer_size($name, $value) {
    $required_value = 512;
    if ($value > $required_value) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }
    $notes = array();
    $recommendations = array(t('Drupal core requires at least !value MB size', array('!value' => $required_value)));
    return array(
      'name' => $name,
      'actual' => $value,
      'description' => t('Join buffer size'),
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );
  }

  function analyze_max_connections($name, $value) {
    $required_value = 150;
    if ($value > $required_value) {
      $status = self::STATUS_OK;
    }
    else {
      $status = self::STATUS_ERROR;
    }
    $notes = array();
    $recommendations = array(t('Drupal core requires at least !value amount of connections', array('!value' => $required_value)));
    return array(
      'name' => $name,
      'actual' => $value,
      'description' => t('Max amount of connections'),
      'recommendation' => implode(' ', $recommendations),
      'note' => implode(' ', $notes),
      'status' => $status,
    );
  }
}
