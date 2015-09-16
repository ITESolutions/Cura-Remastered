<?php
/**
 * ITE Framework global functions
 * @author Corey Ray <coreyaray@gmail.com>
 * @package ITE Framework
 * @copyright Copyright (C) 2015 ITE Solutions. All rights reserved.
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 */
/**
 * Function to get the name of the class that called the current method or function
 * @return string Returns a string on success or boolean false on fail
 */
function get_calling_class() {
    $trace = debug_backtrace();
    if (isset($trace[2])) {
        $class = $trace[2]['class'];
        if (stristr($class, '\\')) {
            $array = explode ('\\', $class);
            return end ($array);
        }
        return $class;
    }
    return FALSE;
}
/**
 * Function to get the calling method or function
 * @access public
 * @return array_assoc Returns an associative array with the class as the key and the method or function as the value or false on failure
 */
function get_calling_method() {
    $trace = debug_backtrace();
    if (isset($trace[1])) {
        return array(
            $trace[1]['class'] => $trace[1]['function']
        );
    }
    return FALSE;
}
/**
 * Error handler
 */
function error_handler($code, $string, $file, $line, $context) {
    include 'error.php';
    return TRUE;
}
/**
 * Function to log errors to a log file
 * @access public
 * @param Exception $error The exception thrown or a string with a message to log
 */
function log_error($error) {
    if (is_a($error, 'Exception')) {
        $msg = 'An Exception was thrown';
    } elseif (is_string($error)) {
        $msg = $error;
    } else {
        $msg = "An error occured: unknown";
    }
    
    error_log($msg . PHP_EOL, 3, 'error.log');
}
/**
 * Autoloader function using namespaces
 * 
 * @access public 
 * @param string $class_name The class name and path to the class set with namespaces
 */
function autoload($class_name) {
    $file = str_replace('\\', DS, $class_name);
    require_once $file . '.php';
}
/**
 * Function to safely rewrite a file after securing a file resource lock.
 * 
 * @param string $file Name of file to write
 * @param string $data data to be written to the file
 * @return boolean True on success, false on fail.
 */
function file_rewrite($file, $data) {
    $fp = fopen($file, 'w');
    if (!$fp) {
        trigger_error('Unable to get file handle: ' . $file . '. Check folder permissions.');
    }
    $start = microtime();
    do {
        $canWrite = flock($fp, LOCK_EX);
        if(!$canWrite) {
            usleep(100);
        }
    }
    while ((!$canWrite) && ((microtime() - $start) < 1000));
    if (!$canWrite) {
        return FALSE;
    }
    fwrite($fp, $data);
    flock($fp, LOCK_UN);
    fclose($fp);
    return TRUE;
}
/**
 * Check if an array is associative
 * If there is at least one string key, $array will be regarded as associative array
 * @param array $array Array to be checked
 * @return bool True if the array is associative
 */
function is_assoc($array) {
    if (!is_array($array)) { return FALSE; }
    return (bool)count(array_filter(array_keys($array), 'is_string'));
}
/**
 * Checks if an array is indexed
 * @param array $array The array to be checked
 * @return boolean
 */
function is_indexed($array) {
    if (!is_array($array)) { return FALSE; }
    return (bool) array_values($array) === $array;
}