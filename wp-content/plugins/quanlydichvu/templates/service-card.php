<?php
$gia = get_post_meta(get_the_ID(), '_gia', true);
$lien_he = get_post_meta(get_the_ID(), '_lien_he', true);
$image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
?>

<div class="qldv-card">
    <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>" class="qldv-image">
    <div class="qldv-content">
        <h3 class="qldv-title"><?php the_title(); ?></h3>
        <p class="qldv-description"><?php echo get_the_content(); ?></p>
        <p class="qldv-price"><strong>Liên hệ báo giá:</strong> <?php echo esc_html($gia); ?></p>
        <a class="qldv-button" href="tel:<?php echo esc_attr($lien_he); ?>">📞 Gọi <?php echo esc_html($lien_he); ?></a>
    </div>
</div>
