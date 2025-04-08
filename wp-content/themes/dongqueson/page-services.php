<?php
/*
Template Name: Services Page
*/
get_header(); ?>

<!-- Services Section -->
<section class="services-section py-5">
    <div class="container">
        <!-- Tiêu đề -->
      

        <!-- Grid hiển thị các gói dịch vụ -->
        <div class="row">
            <!-- Sử dụng shortcode để hiển thị các gói dịch vụ -->
            <?php echo do_shortcode('[dich_vu_phong_kham]'); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>