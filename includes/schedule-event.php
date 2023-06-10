<?php

defined( 'ABSPATH' ) or die;

class Schedule_Event
{
    /**
     * Get event by id
    */
    public static function get_by_id( $id )
    {
        global $wpdb;

        $event = $wpdb->get_row(
            "SELECT * FROM `{$wpdb->base_prefix}events` 
                WHERE `id` = {$id}" 
        );

        return $event;
    }

    /**
     * Get events in date range
    */
    public static function get_by_range( $start, $end )
    {
        global $wpdb;

        $events = $wpdb->get_results( 
            "SELECT * FROM `{$wpdb->base_prefix}events` 
                WHERE `event_timestamp` 
                BETWEEN '{$start}'
                AND '{$end}'" 
        );

        return $events;
    }

    /**
     * Get latest events
     */
    public static function get_for_next_days( int $days = 4 )
    {
        global $wpdb;

        $start = datetime( 'midnight' )->getTimestamp();
        $end = $start + ( DAY_IN_SECONDS * $days );

        $events = $wpdb->get_results( 
            "SELECT * FROM `{$wpdb->base_prefix}events` 
                WHERE `event_timestamp` 
                BETWEEN {$start}
                AND {$end}"
        );

        return $events;
    }

    /**
     * Insert event in DB
     */
    public static function insert( $type, $title, $timestamp )
    {
        global $wpdb;

        $result = $wpdb->insert(
            "{$wpdb->base_prefix}events",
            [
                'event_type' => $type,
                'event_title' => $title,
                'event_timestamp' => $timestamp,
            ]
        );

        return $result ? 
            self::get_by_id( $wpdb->insert_id ) : 
            false;
    }

    /**
     * Delete event from DB
     */
    public static function delete( $id )
    {
        global $wpdb;

        $result = $wpdb->delete(
            "{$wpdb->base_prefix}events",
            [
                'id' => $id,
            ]
        );

        return $result;
    }
}
