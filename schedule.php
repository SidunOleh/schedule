<?php

/*
Plugin Name: Schedule
Description: Schedule for WordPress
Author: Sidun Oleh
*/

defined( 'ABSPATH' ) or die;

const SCHEDULE_ROOT = __DIR__;

/*
    Activate Plugin
*/
require_once SCHEDULE_ROOT . '/includes/schedule-activator.php';
register_activation_hook( 
    __FILE__,
    [ Schedule_Activator::class, 'activate' ]
 );

 /*
    Run Plugin
 */
require_once SCHEDULE_ROOT . '/includes/schedule-core.php';
Schedule_Core::run();