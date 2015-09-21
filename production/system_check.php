<?php

// Minimum version of PHP required
if (!defined('MIN_PHP_VER') {
    define ('MIN_PHP_VER', '5.3');
}

if (version_compare(PHP_VERSION, MIN_PHP_VER, '<'))
{
    die('Your host needs to use PHP " . MIN_PHP_VER . " or higher to run this application');
}

// Refuse non-web requests by default
if (!defined ('WEB_ONLY')) {
    define ('WEB_ONLY', true);
}

if (defined ('WEB_ONLY') && !filter_input (INPUT_SERVER, 'REQUEST_URI')) {
    die ('This script cannot be executed from the command line');
}
