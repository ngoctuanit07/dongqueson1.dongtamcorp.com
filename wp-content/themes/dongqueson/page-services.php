<?php
/*
Template Name: Services Page
*/
get_header(); ?>

<!-- Services Section -->
<section class="services-section py-4 py-md-5">
    <div class="container">
        <!-- Tiêu đề -->
        <h1 class="text-center mb-4 fw-bold h3 h1-md">
            <?php the_title(); ?>
        </h1>

        <!-- Grid hiển thị các gói dịch vụ -->
        <div class="row">
            <?php echo do_shortcode('[dich_vu_phong_kham]'); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
