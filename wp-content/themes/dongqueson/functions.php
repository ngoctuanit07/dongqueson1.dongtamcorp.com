<?php
// Đăng ký và tải Bootstrap CSS & JS
function dongqueson_enqueue_scripts() {
    // Tải Bootstrap CSS từ CDN
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    
    // Tải CSS tùy chỉnh của theme
    wp_enqueue_style('dongqueson-style', get_stylesheet_uri());
    // Thêm Bootstrap Icons
wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css');
    
    // Tải Bootstrap JS từ CDN
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'dongqueson_enqueue_scripts');

// Đăng ký menu
function dongqueson_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'dongqueson'),
    ));
}
add_action('init', 'dongqueson_register_menus');

// Hỗ trợ thêm các tính năng theme
function dongqueson_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    // Hỗ trợ Custom Logo
    add_theme_support('custom-logo', array(
        'height'      => 40,
        'width'       => 40,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'dongqueson_theme_setup');

require_once get_template_directory() . '/wp-bootstrap-navwalker.php';