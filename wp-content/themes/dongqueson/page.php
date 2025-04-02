<?php get_header(); ?>
    <div class="row">
        <div class="col-md-12">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="card mb-4">
                    <div class="card-body">
                        <h1 class="card-title"><?php the_title(); ?></h1>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </div>
    </div>
<?php get_footer(); ?>