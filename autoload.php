<?php

/**
 * @file
 * Class Autoloader.
 */
class Autoloader {
  private static $_lastLoadedFilename;

  public static function loadPackages($className) {
    $pathParts = explode('_', $className);
    self::$_lastLoadedFilename = implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
    require_once(self::$_lastLoadedFilename);
  }

  public static function loadPackagesAndLog($className) {
    self::loadPackages($className);
  }
}

spl_autoload_register(array('Autoloader', 'loadPackagesAndLog'), $throw = FALSE, $prepend = TRUE);