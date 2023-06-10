<?php

defined( 'ABSPATH' ) or die;

class Schedule_Admin
{
    /**
     * Add menu page
     */
    public static function page()
    {
        add_menu_page(
            __( 'Schedule' ),
            __( 'Schedule' ),
            'delete_others_posts',
            'schedule',
            [self::class, 'page_html'],
            'dashicons-schedule',
            21
        );
    }

    /**
     * Menu page template
     */
    public static function page_html()
    {
        $daterange = daterange( 'midnight', 'P1D', '+6 days' );
        $events = Schedule_Event::get_for_next_days( 7 );

        require_once SCHEDULE_ROOT . '/admin/templates/page.php';
    }

    public static function enqueue_styles()
    {
        if ( $_GET[ 'page' ] != 'schedule' ) return;

        wp_enqueue_style( 
            'schedule-admin', 
            plugin_dir_url( SCHEDULE_ROOT . '/schedule.php' ) . '/admin/css/style.css' 
        );
    }

    public static function enqueue_scripts()
    {
        if ( $_GET[ 'page' ] != 'schedule' ) return;

        wp_deregister_script( 'jquery' );
        wp_enqueue_script( 
            'jquery', 
            'https://code.jquery.com/jquery-3.6.4.min.js' 
        );

        wp_enqueue_script( 
            'schedule-admin', 
            plugin_dir_url( SCHEDULE_ROOT . '/schedule.php' ) . '/admin/js/script.js',
            [ 'jquery', ], 
            false, 
            true 
        );

        add_thickbox();
    }
}