<?php
/*
Plugin Name: BHXH Document Manager
Description: Quản lý văn bản BHXH với REST API, Shortcode và Admin Grid
Version: 1.0.0
Author: Tuan Nguyen
Author URI: https://nguyenngoctuan07.com
License: GPLv2 or later
Text Domain: bhxh-document-manager
*/

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Tạo bảng database khi kích hoạt plugin
function bhxh_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bhxh_documents';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        so_hieu varchar(50) NOT NULL,
        link_van_ban text NOT NULL,
        noi_dung text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'bhxh_activate');

// Load các class
require_once plugin_dir_path(__FILE__) . 'includes/class-bhxh-rest-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-bhxh-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-bhxh-admin-grid.php';

// Khởi tạo các class
new BHXH_REST_API();
new BHXH_Shortcode();
new BHXH_Admin_Grid();