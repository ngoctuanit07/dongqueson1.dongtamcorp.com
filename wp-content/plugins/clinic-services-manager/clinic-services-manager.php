<?php
/**
 * Plugin Name: Clinic Services Manager
 * Description: Plugin quản lý phòng khám và các dịch vụ khám chữa bệnh.
 * Version: 1.0.0
 * Author: Tuan Nguyen
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

// Define constants
define('CSM_VERSION', '1.0.0');
define('CSM_PLUGIN_DIR', plugin_dir_path(__FILE__));

data_create_clinic_services_table();

// Load plugin
add_action('init', 'csm_register_post_types');
add_action('plugins_loaded', 'csm_load_acf_fields');
add_shortcode('clinic_list', 'csm_shortcode_clinic_list');

// Activation hook
register_activation_hook(__FILE__, 'csm_activate_plugin');

function csm_activate_plugin() {
    data_create_clinic_services_table();
    flush_rewrite_rules();
}

function csm_register_post_types() {
    register_post_type('clinic', [
        'labels' => [
            'name' => 'Phòng khám',
            'singular_name' => 'Phòng khám'
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-hospital',
    ]);

    register_post_type('service', [
        'labels' => [
            'name' => 'Dịch vụ',
            'singular_name' => 'Dịch vụ'
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-plus-alt',
    ]);
}

function csm_load_acf_fields() {
    if( function_exists('acf_add_local_field_group') ) {

        acf_add_local_field_group([
            'key' => 'group_clinic_fields',
            'title' => 'Thông tin phòng khám',
            'fields' => [
                [
                    'key' => 'field_dia_chi',
                    'label' => 'Địa chỉ',
                    'name' => 'dia_chi',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_sdt',
                    'label' => 'Số điện thoại',
                    'name' => 'so_dien_thoai',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_phuong_cham',
                    'label' => 'Phương châm hoạt động',
                    'name' => 'phuong_cham',
                    'type' => 'textarea',
                ],
                [
                    'key' => 'field_dich_vu',
                    'label' => 'Danh sách dịch vụ',
                    'name' => 'danh_sach_dich_vu',
                    'type' => 'relationship',
                    'post_type' => ['service'],
                    'return_format' => 'id',
                    'multiple' => true
                ]
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'clinic',
                    ]
                ]
            ]
        ]);
    }
}

function csm_shortcode_clinic_list($atts) {
    $clinics = new WP_Query([
        'post_type' => 'clinic',
        'posts_per_page' => -1
    ]);

    ob_start();
    if ($clinics->have_posts()) {
        echo '<div class="clinic-list">';
        while ($clinics->have_posts()) {
            $clinics->the_post();
            $sdt = get_field('so_dien_thoai');
            $dc = get_field('dia_chi');
            echo '<div class="clinic-item">';
            echo '<h3>' . get_the_title() . '</h3>';
            echo '<p><strong>Địa chỉ:</strong> ' . esc_html($dc) . '</p>';
            echo '<p><strong>SĐT:</strong> ' . esc_html($sdt) . '</p>';
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>Không có phòng khám nào.</p>';
    }
    return ob_get_clean();
}

function data_create_clinic_services_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'clinic_logs';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        clinic_id BIGINT UNSIGNED NOT NULL,
        action VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
