<?php
/*
Template Name: Doctors Page
*/
get_header(); ?>

<!-- Doctors Section -->
<section class="doctors-section py-4 py-md-5">
    <div class="container">
        <h1 class="text-center mb-4 fw-bold h3 h1-md">
            <?php the_title(); ?>
        </h1>
        <div class="row gy-4">
            <!-- Sử dụng shortcode để hiển thị danh sách bác sĩ -->
            <?php echo do_shortcode('[doctor_list]'); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
