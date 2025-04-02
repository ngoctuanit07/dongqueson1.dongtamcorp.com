<?php
/**
 * Plugin Name: RSS Manager
 * Description: Plugin quản lý RSS với REST API và shortcode hiển thị dữ liệu.
 * Version: 1.1
 * Author: Tuan Nguyen
 */

if (!defined('ABSPATH')) {
    exit; // Ngăn truy cập trực tiếp
}

// Tạo bảng trong database khi kích hoạt plugin
function rss_manager_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'rss_manager';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        link TEXT NOT NULL,
        category VARCHAR(50) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'rss_manager_create_table');

// Đăng ký REST API
add_action('rest_api_init', function () {
    register_rest_route('rss-manager/v1', '/add', array(
        'methods' => 'POST',
        'callback' => 'rss_manager_add_rss',
        'permission_callback' => '__return_true',
    ));
    register_rest_route('rss-manager/v1', '/get', array(
        'methods' => 'GET',
        'callback' => 'rss_manager_get_rss',
        'permission_callback' => '__return_true',
    ));
});

// Thêm RSS vào database qua API
function rss_manager_add_rss(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'rss_manager';

    $title = sanitize_text_field($request->get_param('title'));
    $link = esc_url_raw($request->get_param('link'));
    $category = sanitize_text_field($request->get_param('category'));

    if (empty($title) || empty($link) || empty($category)) {
        return new WP_Error('missing_data', 'Thiếu dữ liệu', array('status' => 400));
    }

    $wpdb->insert($table_name, [
        'title' => $title,
        'link' => $link,
        'category' => $category
    ]);

    return rest_ensure_response(['message' => 'RSS đã được thêm']);
}

// Lấy danh sách RSS qua API
function rss_manager_get_rss(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'rss_manager';
    $category = $request->get_param('category');
    
    $query = "SELECT * FROM $table_name";
    if (!empty($category)) {
        $query .= $wpdb->prepare(" WHERE category = %s", $category);
    }
    
    $results = $wpdb->get_results($query);
    return rest_ensure_response($results);
}

// Định nghĩa shortcode để hiển thị danh sách RSS
function rss_manager_shortcode($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'rss_manager';
    
    $atts = shortcode_atts(array(
        'category' => ''
    ), $atts);
    
    $query = "SELECT * FROM $table_name";
    if (!empty($atts['category'])) {
        $query .= $wpdb->prepare(" WHERE category = %s", $atts['category']);
    }
    
    $results = $wpdb->get_results($query);
    if (!$results) return '<p>Không có RSS nào.</p>';

    $output = '<ul>';
    foreach ($results as $rss) {
        $output .= "<li><a href='{$rss->link}' target='_blank'>{$rss->title} ({$rss->category})</a></li>";
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('rss_manager', 'rss_manager_shortcode');
