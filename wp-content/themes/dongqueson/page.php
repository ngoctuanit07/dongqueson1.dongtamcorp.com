<?php get_header(); ?>

<div class="container py-4">
    <div class="row justify-content-center gy-4">
        <div class="col-12 col-md-11 col-lg-10 mb-3 mb-md-0">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="mb-5">
                    <!-- Tiêu đề bài viết -->
                    <h1 class="text-center mb-4 fw-bold h3 h1-md"><?php the_title(); ?></h1>
                    
                    <!-- Nội dung bài viết -->
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; else : ?>
                <!-- Thông báo khi không có nội dung -->
                <div class="alert alert-warning text-center">
                    <?php esc_html_e( 'Không tìm thấy nội dung.', 'dongqueson' ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
