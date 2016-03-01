<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Paris');

// defines the web root
define('WEB_ROOT', substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '/index.php')));
// defindes the path to the files
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
// defines the cms path
define('CMS_PATH', ROOT_PATH . '/lib/base/');

// Make sure instanceof will work in routes.php
require_once('../lib/base/Model.php');
require_once('../app/models/Employe_contact.php');
require_once('../app/models/Membre_labo.php');

// starts the session
session_start();
if (!isset($_SESSION) || !isset($_SESSION['login']) ||($_SESSION['login'] === NULL)) {
  $uri = explode('?',$_SERVER['REQUEST_URI']);
  $uri = $uri[0];
  $uri = substr($uri, strlen(WEB_ROOT));
  if ($uri !== '/login') {
    header('Location: '.WEB_ROOT.'/login');
    exit(0);
  }
}
// includes the system routes. Define your own routes in this file
include(ROOT_PATH . '/config/routes.php');

/**
 * Standard framework autoloader
 * @param string $className
 */
function autoloader($className) {
  // controller autoloading
  if (strlen($className) > 10 && substr($className, -10) == 'Controller' && $className != 'ErrorController') {
    if (file_exists(ROOT_PATH . '/app/controllers/' . $className . '.php') == 1) {
      require_once ROOT_PATH . '/app/controllers/' . $className . '.php';
    }
  }
  else {
    if (file_exists(CMS_PATH . $className . '.php')) {
      require_once CMS_PATH . $className . '.php';
    }
    else if (file_exists(ROOT_PATH . '/app/models/' . $className . '.php')) {
      require_once ROOT_PATH . '/app/models/'.$className.'.php';
    }
    else {
      require_once ROOT_PATH . '/app/views/'.$className.'.php';
    }
  }
}

// activates the autoloader
spl_autoload_register('autoloader');

$router = new Router();
$router->execute($routes);
