<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (version_compare(PHP_VERSION, '5.3', '<'))
{
    die('Your host needs to use PHP 5.3 or higher to run this application');
}
if (defined('WEB_ONLY') && !filter_input(INPUT_SERVER, 'REQUEST_URI')) {
    die('This script cannot be executed from the command line');
}
