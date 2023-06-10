<?php

defined( 'ABSPATH' ) or die;

class Schedule_Activator
{
    public static function activate()
    {
        self::create_events_table();
    }

    /**
     * Create events table
    */
    private static function create_events_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $base_prefix = $wpdb->base_prefix;

        $sql = "CREATE TABLE {$base_prefix}events (
            id              BIGINT(20)   UNSIGNED NOT NULL AUTO_INCREMENT,
            event_type      VARCHAR(100)          NOT NULL,
            event_title     VARCHAR(100)          NOT NULL,
            event_timestamp BIGINT(20)            NOT NULL,
            PRIMARY KEY(id)
        ) {$charset_collate}";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );

        if ( $wpdb->last_error ) die( $wpdb->last_error );
    }
}