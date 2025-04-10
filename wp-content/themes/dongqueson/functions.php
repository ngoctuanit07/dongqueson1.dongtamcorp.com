<?php
// Đăng ký và tải Bootstrap CSS & JS
function dongqueson_enqueue_scripts() {
    // Tải Bootstrap CSS từ CDN
    wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), null );

    // Tải CSS tùy chỉnh của theme
    wp_enqueue_style( 'dongqueson-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    // Thêm Bootstrap Icons
    wp_enqueue_style( 'bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css', array(), null );

    // Tải Bootstrap JS từ CDN
    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'dongqueson_enqueue_scripts' );

// Đăng ký menu
function dongqueson_register_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu', 'dongqueson' ),
        )
    );
}
add_action( 'init', 'dongqueson_register_menus' );

// Hỗ trợ thêm các tính năng theme
function dongqueson_theme_setup() {
    // Hỗ trợ tiêu đề trang
    add_theme_support( 'title-tag' );

    // Hỗ trợ ảnh đại diện
    add_theme_support( 'post-thumbnails' );

    // Hỗ trợ Custom Logo
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 40,
            'width'       => 40,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );
}
add_action( 'after_setup_theme', 'dongqueson_theme_setup' );

// Thêm class Bootstrap vào Custom Logo
function add_bootstrap_class_to_custom_logo( $html ) {
    if ( ! empty( $html ) ) {
        $html = str_replace( 'custom-logo', 'custom-logo img-fluid', $html );
    }
    return $html;
}
add_filter( 'get_custom_logo', 'add_bootstrap_class_to_custom_logo' );

// Tải Codestar Framework
if ( file_exists( get_template_directory() . '/lib/codestar/codestar-framework.php' ) ) {
    require_once get_template_directory() . '/lib/codestar/codestar-framework.php';
}

// Tải WP Bootstrap Navwalker
if ( file_exists( get_template_directory() . '/wp-bootstrap-navwalker.php' ) ) {
    require_once get_template_directory() . '/wp-bootstrap-navwalker.php';
}

// Cài đặt Codestar Framework
if ( class_exists( 'CSF' ) ) {
    // Tạo trang cài đặt theme
    CSF::createOptions(
        'dongqueson_theme_options',
        array(
            'menu_title'      => 'Cài Đặt Theme',
            'menu_slug'       => 'dongqueson-theme-settings',
            'framework_title' => 'Cài Đặt Theme <small>by Dongqueson</small>',
        )
    );

    // Cài đặt Header
    CSF::createSection(
        'dongqueson_theme_options',
        array(
            'title'  => 'Header',
            'fields' => array(
                array(
                    'id'      => 'show_top_bar',
                    'type'    => 'switcher',
                    'title'   => 'Hiển thị Top Bar',
                    'default' => true,
                ),
                array(
                    'id'      => 'top_bar_content',
                    'type'    => 'textarea',
                    'title'   => 'Nội dung Top Bar',
                    'default' => '<i class="bi bi-clock"></i> Khám bệnh: T2-CN [07:00 - 19:00] - Cấp cứu 24/24',
                ),
                array(
                    'id'      => 'top_bar_bg_color',
                    'type'    => 'color',
                    'title'   => 'Màu nền Top Bar',
                    'default' => '#f8f9fa',
                ),
                array(
                    'id'      => 'top_bar_text_color',
                    'type'    => 'color',
                    'title'   => 'Màu chữ Top Bar',
                    'default' => '#333333',
                ),
                array(
                    'id'      => 'header_logo',
                    'type'    => 'media',
                    'title'   => 'Logo Header',
                    'desc'    => 'Tải lên logo hiển thị trong header.',
                ),
                array(
                    'id'      => 'logo_width',
                    'type'    => 'number',
                    'title'   => 'Chiều rộng Logo (px)',
                    'default' => 150,
                ),
                array(
                    'id'      => 'logo_alignment',
                    'type'    => 'select',
                    'title'   => 'Căn chỉnh Logo',
                    'options' => array(
                        'left'   => 'Trái',
                        'center' => 'Giữa',
                        'right'  => 'Phải',
                    ),
                    'default' => 'left',
                ),
                array(
                    'id'      => 'header_bg_color',
                    'type'    => 'color',
                    'title'   => 'Màu nền Header',
                    'default' => '#ffffff',
                ),
            ),
        )
    );

    // Cài đặt Footer
    CSF::createSection(
        'dongqueson_theme_options',
        array(
            'title'  => 'Footer',
            'fields' => array(
                array(
                    'id'    => 'footer_logo',
                    'type'  => 'media',
                    'title' => 'Logo Footer',
                    'desc'  => 'Tải lên logo hiển thị trong footer.',
                ),
                array(
                    'id'      => 'footer_bg_color',
                    'type'    => 'color',
                    'title'   => 'Màu nền Footer',
                    'default' => '#343a40',
                ),
                array(
                    'id'      => 'footer_text_color',
                    'type'    => 'color',
                    'title'   => 'Màu chữ Footer',
                    'default' => '#ffffff',
                ),
                array(
                    'id'      => 'footer_copyright',
                    'type'    => 'textarea',
                    'title'   => 'Nội dung bản quyền',
                    'default' => 'Copyright 2025 © Phòng khám Đồng Tâm Sài Gòn',
                ),
                array(
                    'id'    => 'social_links',
                    'type'  => 'group',
                    'title' => 'Liên kết mạng xã hội',
                    'fields' => array(
                        array(
                            'id'    => 'social_icon',
                            'type'  => 'icon',
                            'title' => 'Biểu tượng',
                        ),
                        array(
                            'id'    => 'social_url',
                            'type'  => 'text',
                            'title' => 'URL',
                        ),
                    ),
                ),
            ),
        )
    );

    // Cài đặt Google Maps
    CSF::createSection(
        'dongqueson_theme_options',
        array(
            'title'  => 'Google Maps',
            'fields' => array(
                array(
                    'id'      => 'google_maps_url',
                    'type'    => 'text',
                    'title'   => 'Google Maps URL',
                    'desc'    => 'Nhập URL Google Maps để hiển thị trong footer.',
                    'default' => 'https://www.google.com/maps',
                ),
            ),
        )
    );

    // Cài đặt Typography
    CSF::createSection(
        'dongqueson_theme_options',
        array(
            'title'  => 'Typography',
            'fields' => array(
                array(
                    'id'      => 'body_font_family',
                    'type'    => 'typography',
                    'title'   => 'Font chữ chính',
                    'default' => array(
                        'family'  => 'Arial, sans-serif',
                        'variant' => 'regular',
                    ),
                ),
                array(
                    'id'      => 'body_font_size',
                    'type'    => 'number',
                    'title'   => 'Kích thước chữ chính (px)',
                    'default' => 16,
                ),
                array(
                    'id'      => 'heading_font_family',
                    'type'    => 'typography',
                    'title'   => 'Font chữ tiêu đề',
                    'default' => array(
                        'family'  => 'Georgia, serif',
                        'variant' => '700',
                    ),
                ),
            ),
        )
    );

    // Cài đặt Màu Sắc
    CSF::createSection(
        'dongqueson_theme_options',
        array(
            'title'  => 'Màu Sắc',
            'fields' => array(
                array(
                    'id'      => 'body_bg_color',
                    'type'    => 'color',
                    'title'   => 'Màu nền trang',
                    'default' => '#ffffff',
                ),
                array(
                    'id'      => 'text_color',
                    'type'    => 'color',
                    'title'   => 'Màu văn bản',
                    'default' => '#333333',
                ),
                array(
                    'id'      => 'link_color',
                    'type'    => 'color',
                    'title'   => 'Màu liên kết',
                    'default' => '#007bff',
                ),
                array(
                    'id'      => 'link_hover_color',
                    'type'    => 'color',
                    'title'   => 'Màu liên kết khi hover',
                    'default' => '#0056b3',
                ),
            ),
        )
    );
}