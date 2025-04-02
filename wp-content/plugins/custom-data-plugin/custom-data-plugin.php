<?php
/*
Plugin Name: Custom Data Plugin
Description: A plugin to store and display data from a table with REST API, shortcode, search, filter, grid, and CRUD support.
Version: 1.1
Author: Tuan Nguyen
*/

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Activation hook
register_activation_hook(__FILE__, 'custom_data_plugin_activate');

function custom_data_plugin_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        so_hieu varchar(50) NOT NULL,
        trich_yeu_noi_dung text NOT NULL,
        co_quan varchar(100) NOT NULL,
        ngay_ban date NOT NULL,
        link_van_ban varchar(255) DEFAULT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'custom_data_plugin_deactivate');

function custom_data_plugin_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_data';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/rest-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-grid.php';

// Admin menu
add_action('admin_menu', 'custom_data_plugin_menu');

function custom_data_plugin_menu() {
    add_menu_page(
        'Custom Data',
        'Custom Data',
        'manage_options',
        'custom-data-plugin',
        'custom_data_plugin_grid_page', // Sử dụng grid page mới
        'dashicons-list-view'
    );
}

// Function to enqueue admin scripts and styles
add_action('admin_enqueue_scripts', 'custom_data_admin_enqueue_scripts');

function custom_data_admin_enqueue_scripts($hook) {
    if ('toplevel_page_custom-data-plugin' != $hook) {
        return;
    }
    wp_enqueue_style('custom-data-grid-css', plugins_url('assets/css/grid.css', __FILE__));
    wp_enqueue_script('custom-data-grid-js', plugins_url('assets/js/grid.js', __FILE__), array('jquery'), '1.0', true);
}