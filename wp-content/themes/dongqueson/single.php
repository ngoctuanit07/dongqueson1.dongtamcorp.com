<?php get_header(); ?>
<div class="container py-4">
    <div class="row">
        <!-- Nội dung chính -->
        <div class="col-12 col-md-8 mb-4">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="card h-100 mb-4">
                    <div class="card-body">
                        <h1 class="card-title h4 mb-3"><?php the_title(); ?></h1>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </div>
        <!-- Sidebar -->
        <div class="col-12 col-md-4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
