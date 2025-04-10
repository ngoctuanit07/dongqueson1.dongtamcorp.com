<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <?php wp_head(); ?>
    <?php
    $options = get_option( 'dongqueson_theme_options' );
    $body_font_family = ! empty( $options['body_font_family']['family'] ) ? $options['body_font_family']['family'] : 'Arial, sans-serif';
    $body_font_size = ! empty( $options['body_font_size'] ) ? $options['body_font_size'] : 16;
    $heading_font_family = ! empty( $options['heading_font_family']['family'] ) ? $options['heading_font_family']['family'] : 'Georgia, serif';
    ?>
    <style>
        body {
            font-family: <?php echo esc_attr( $body_font_family ); ?>;
            font-size: <?php echo esc_attr( $body_font_size ); ?>px;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: <?php echo esc_attr( $heading_font_family ); ?>;
        }
    </style>
</head>
<body <?php body_class(); ?>>
    <?php
    $options = get_option( 'dongqueson_theme_options' );
    $show_top_bar = ! empty( $options['show_top_bar'] ) ? $options['show_top_bar'] : true;
    $top_bar_content = ! empty( $options['top_bar_content'] ) ? $options['top_bar_content'] : '';
    $header_menu_position = ! empty( $options['header_menu_position'] ) ? $options['header_menu_position'] : 'center';
    $logo_width = ! empty( $options['logo_width'] ) ? $options['logo_width'] : 150;
    $top_bar_bg_color = ! empty( $options['top_bar_bg_color'] ) ? $options['top_bar_bg_color'] : '#f8f9fa';
    $top_bar_text_color = ! empty( $options['top_bar_text_color'] ) ? $options['top_bar_text_color'] : '#333333';
    ?>

    <?php if ( $show_top_bar ) : ?>
    <div class="top-bar py-2" style="background-color: <?php echo esc_attr( $top_bar_bg_color ); ?>; color: <?php echo esc_attr( $top_bar_text_color ); ?>;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <ul class="top-bar-links list-inline mb-0">
                        <li class="list-inline-item"><?php echo wp_kses_post( $top_bar_content ); ?></li>
                    </ul>
                </div>
                <div class="col-md-6 text-end">
                    <a href="tel:02353845900" class="btn btn-outline-primary btn-sm"><i class="bi bi-telephone"></i> 02353 845 900</a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Header -->
    <?php
    $header_logo = ! empty( $options['header_logo']['url'] ) ? $options['header_logo']['url'] : '';
    $header_bg_color = ! empty( $options['header_bg_color'] ) ? $options['header_bg_color'] : '#ffffff';
    $logo_alignment = ! empty( $options['logo_alignment'] ) ? $options['logo_alignment'] : 'left';
    ?>
    <header style="background-color: <?php echo esc_attr( $header_bg_color ); ?>;">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand text-<?php echo esc_attr( $logo_alignment ); ?>" href="<?php echo home_url(); ?>">
                    <?php if ( $header_logo ) : ?>
                        <img src="<?php echo esc_url( $header_logo ); ?>" alt="Logo" class="img-fluid" style="max-width: <?php echo esc_attr( $logo_width ); ?>px;">
                    <?php else : ?>
                        <span class="text-uppercase fw-bold">PHÒNG KHÁM ĐỒNG TÂM SÀI GÒN</span>
                    <?php endif; ?>
                </a>

                <!-- Toggler for mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Menu -->
                    <div class="<?php echo esc_attr( $header_menu_position === 'center' ? 'mx-auto' : ( $header_menu_position === 'right' ? 'ms-auto' : '' ) ); ?>">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary-menu',
                            'container' => false,
                            'menu_class' => 'navbar-nav',
                            'walker' => new WP_Bootstrap_Navwalker(),
                        ));
                        ?>
                    </div>

                    <!-- Search Form -->
                    <form class="search-form d-flex ms-auto position-relative" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input class="form-control search-input" type="search" name="s" placeholder="Tìm kiếm..." aria-label="Search">
                        <span class="search-icon position-absolute end-0 top-50 translate-middle-y pe-3">
                            <i class="bi bi-search"></i>
                        </span>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-4">