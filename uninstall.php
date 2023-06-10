<?php

defined( 'WP_UNINSTALL_PLUGIN' ) or die;

// delete events table
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->base_prefix}events" );