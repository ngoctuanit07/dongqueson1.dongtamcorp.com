<?php get_header(); ?>

<div class="container mt-4">
    <h1 class="mb-4">
        <?php printf( esc_html__( 'Kết quả tìm kiếm cho: %s', 'dongqueson' ), '<span>' . get_search_query() . '</span>' ); ?>
    </h1>

    <?php if ( have_posts() ) : ?>
        <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium', array( 'class' => 'card-img-top' ) ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h5>
                            <p class="card-text">
                                <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                            </p>
                        </div>
                        <div class="card-footer text-muted">
                            <small><?php echo get_the_date(); ?></small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => __( '&laquo; Trước', 'dongqueson' ),
                'next_text' => __( 'Tiếp &raquo;', 'dongqueson' ),
            ) );
            ?>
        </div>
    <?php else : ?>
        <div class="alert alert-warning">
            <?php esc_html_e( 'Không tìm thấy kết quả nào. Vui lòng thử lại với từ khóa khác.', 'dongqueson' ); ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>