<?php
/**
	Plugin Name: Modern Events Calendar Lite
	Plugin URI: http://webnus.net/modern-events-calendar/
	Description: An awesome plugin for events calendar
	Author: Webnus Team
	Version: 4.2.2
    Text Domain: modern-events-calendar-lite
    Domain Path: /languages
	Author URI: http://webnus.net
**/

if(!defined('MECEXEC'))
{
    /** MEC Execution **/
    define('MECEXEC', 1);

    /** Directory Separator **/
    if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

    /** MEC Absolute Path **/
    define('MEC_ABSPATH', dirname(__FILE__).DS);

    /** Plugin Directory Name **/
    define('MEC_DIRNAME', basename(MEC_ABSPATH));

    /** Plugin File Name **/
    define('MEC_FILENAME', basename(__FILE__));

    /** Plugin Base Name **/
    define('MEC_BASENAME', plugin_basename(__FILE__)); // modern-events-calendar/mec.php

    /** Plugin Version **/
    define('MEC_VERSION', '4.2.2');

    /** Include Webnus MEC class if not included before **/
    if(!class_exists('MEC')) require_once MEC_ABSPATH.'mec-init.php';

    /** Initialize Webnus MEC **/
    $MEC = MEC::instance();
    $MEC->init();
}