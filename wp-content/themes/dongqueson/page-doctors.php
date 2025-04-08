<?php
/*
Template Name: Doctors Page
*/
get_header(); ?>

<!-- Doctors Section -->
<section class="doctors-section py-5">
    <div class="container">
      
        <div class="row">
            <!-- Sử dụng shortcode để hiển thị danh sách bác sĩ -->
            <?php echo do_shortcode('[doctor_list]'); ?>
        </div>
    </div>
<?php get_footer(); ?>