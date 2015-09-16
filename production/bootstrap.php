<?php
/**
 * ITE Framework 1.1 Bootstrap
 * @author Corey Ray <coreyaray@gmail.com>
 * @package ITE Framework
 * @copyright Copyright (C) 2015 ITE Solutions. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 */

// check for invalid runtime
require_once 'system_check.php';

define('_ITE', 1);
define('APP_ROOT', dirname(__FILE__));
define('DEVELOPMENT_MODE', 1);
define('START_TIME', time());
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

// Include core functions
require_once 'functions.php';
/**
 * @todo Check for unwanted behavior.
 */
if (filter_input(INPUT_POST, 'dev')) {
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}
set_error_handler('error_handler');
spl_autoload_extensions('.php');
spl_autoload_register('autoload');
Framework\Helpers\Config::initialize();
