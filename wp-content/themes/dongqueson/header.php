<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Top Bar -->
    <div class="top-bar py-2 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <ul class="top-bar-links list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="/hoi-dap-bac-si/"><i class="bi bi-people"></i> Hỏi đáp bác sĩ</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="/lich-kham-benh"><i class="bi bi-calendar"></i> Lịch khám bệnh</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="/chinh-sach-bao-hiem-y-te"><i class="bi bi-book"></i> Hướng dẫn bảo hiểm</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 text-end">
                    <span class="me-3"><i class="bi bi-clock"></i> Khám bệnh: T2-CN [07:00 - 19:00] - Cấp cứu 24/24</span>
                    <a href="tel:02353845900" class="btn btn-outline-primary btn-sm"><i class="bi bi-telephone"></i> 02353 845 900</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo home_url(); ?>">
                    <?php
                    // Hiển thị logo của WordPress
                    if (function_exists('the_custom_logo') && has_custom_logo()) {
                        the_custom_logo();
                    }
                    ?>
                    <span class="ms-2 text-uppercase fw-bold">PHÒNG KHÁM ĐỒNG TÂM SÀI GÒN</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'container' => false,
                        'menu_class' => 'navbar-nav ms-auto',
                        'walker' => new WP_Bootstrap_Navwalker(),
                    ));
                    ?>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-4">