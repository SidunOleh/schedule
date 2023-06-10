<?php

defined( 'ABSPATH' ) or die;

class Schedule_Public
{
    /**
     * Add schedule shortcode
     */
    public static function add_shortcode()
    {
        add_shortcode( 'schedule', [ self::class, 'shortcode_html' ] );
    }

    /**
     * Schedule template
     */
    public static function  shortcode_html()
    {
        $daterange = daterange( 'midnight', 'P1D', '+3 days' );
        $events = Schedule_Event::get_for_next_days();

        require_once SCHEDULE_ROOT . '/public/templates/schedule.php';
    }

    public static function enqueue_styles()
    {
        wp_enqueue_style( 
            'schedule-public', 
            plugin_dir_url( SCHEDULE_ROOT . '/schedule.php' ) . '/public/css/style.css' 
        );
    }

    public static function enqueue_scripts()
    {
        wp_deregister_script( 'jquery' );
        wp_enqueue_script( 
            'jquery', 
            'https://code.jquery.com/jquery-3.6.4.min.js' 
        );
        
        wp_enqueue_script( 
            'schedule-public', 
            plugin_dir_url( SCHEDULE_ROOT . '/schedule.php' ) . '/public/js/script.js',
            [ 'jquery', ], 
            false, 
            true 
        );
    }
}