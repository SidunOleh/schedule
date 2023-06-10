<?php

defined( 'ABSPATH' ) or die;

class Schedule_Ajax
{
    /**
     * Offset schedule
    */
    public static function get_schedule()
    {
        $start = $_GET[ 'start' ];
        $end = $_GET[ 'end' ];
        
        $daterange = daterange( 
            $start, 
            'P1D', 
            $end + DAY_IN_SECONDS, // to include end day
        );
        $events = Schedule_Event::get_by_range( 
            $start, 
            $end + DAY_IN_SECONDS // to include end day events
        );

        ob_start();
        if ( preg_match( '/\/wp-admin\/admin\.php/' , $_SERVER[ 'HTTP_REFERER' ] ) ) {
            require_once SCHEDULE_ROOT . '/admin/templates/schedule.php';
        } else {
            require_once SCHEDULE_ROOT . '/public/templates/schedule.php';
        }

        wp_send_json( [
            'schedule_html' => ob_get_clean(),
        ] );
    }

    /**
     * Create event
    */
    public static function create_event()
    {
        $type = empty( $_POST[ 'type' ] ) 
            ? null 
            : $_POST[ 'type' ];
        $title = empty( $_POST[ 'title' ] ) 
            ? null 
            : $_POST[ 'title' ];
        $timestamp = $_POST[ 'timestamp' ];
        
        $event = Schedule_Event::insert( $type, $title, $timestamp );
        if ( $event ) {
            ob_start();
            require_once SCHEDULE_ROOT . '/admin/templates/event.php';
            $event_html = ob_get_clean();
    
            wp_send_json( [
                'event_html' => $event_html,
            ] );
        } else {
            wp_send_json_error( [
                'message' => 'Something goes wrong'
            ], 400 );
        }
    } 

    /**
     * Delete event
    */
    public static function delete_event()
    {
        $id = $_POST[ 'id' ];

        $result = Schedule_Event::delete( $id );

        return wp_send_json( [
            'status' => ( bool ) $result,
        ] );
    }
}