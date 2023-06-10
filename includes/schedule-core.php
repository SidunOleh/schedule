<?php

defined( 'ABSPATH' ) or die;

class Schedule_Core
{
    public static function run()
    {
        self::load_dependecies();
        self::admin_hooks();
        self::public_hooks();
        self::ajax_hooks();
    }

    private static function load_dependecies()
    {
        require_once SCHEDULE_ROOT . '/includes/schedule-event.php';
        require_once SCHEDULE_ROOT . '/includes/functions.php';
        require_once SCHEDULE_ROOT . '/admin/schedule-admin.php';
        require_once SCHEDULE_ROOT . '/public/schedule-public.php';
        require_once SCHEDULE_ROOT . '/includes/schedule-ajax.php';
    }

    private static function admin_hooks()
    {
        add_action( 'admin_enqueue_scripts', [ Schedule_Admin::class, 'enqueue_styles' ] );
        add_action( 'admin_enqueue_scripts', [ Schedule_Admin::class, 'enqueue_scripts' ] );
        add_action( 'admin_menu', [ Schedule_Admin::class, 'page' ] );
    }
 
    private static function ajax_hooks()
    {
        add_action( 'wp_ajax_get_schedule', [ Schedule_Ajax::class, 'get_schedule' ] );
        add_action( 'wp_ajax_nopriv_get_schedule', [ Schedule_Ajax::class, 'get_schedule' ] );
        add_action( 'wp_ajax_create_event', [ Schedule_Ajax::class, 'create_event' ] );
        add_action( 'wp_ajax_delete_event', [ Schedule_Ajax::class, 'delete_event' ] );
    }

    private static function public_hooks()
    {
        add_action( 'wp_enqueue_scripts', [ Schedule_Public::class, 'enqueue_styles' ] );
        add_action( 'wp_enqueue_scripts', [ Schedule_Public::class, 'enqueue_scripts' ] );
        add_action( 'init', [ Schedule_Public::class, 'add_shortcode' ] );
    }
}