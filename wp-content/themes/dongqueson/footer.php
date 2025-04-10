</div><!-- /.container -->

<?php
$options = get_option( 'dongqueson_theme_options' );
$footer_logo = ! empty( $options['footer_logo']['url'] ) ? $options['footer_logo']['url'] : '';
$footer_bg_color = ! empty( $options['footer_bg_color'] ) ? $options['footer_bg_color'] : '#343a40';
$footer_text_color = ! empty( $options['footer_text_color'] ) ? $options['footer_text_color'] : '#ffffff';
$footer_copyright = ! empty( $options['footer_copyright'] ) ? $options['footer_copyright'] : 'Copyright 2025 © Phòng khám Đồng Tâm Sài Gòn';
$social_links = ! empty( $options['social_links'] ) ? $options['social_links'] : array();
$google_maps_url = ! empty( $options['google_maps_url'] ) ? $options['google_maps_url'] : 'https://www.google.com/maps';
?>
<footer class="footer-section" style="background-color: <?php echo esc_attr( $footer_bg_color ); ?>; color: <?php echo esc_attr( $footer_text_color ); ?>;">
    <div class="container">
        <div class="row">
            <!-- Logo Footer -->
            <div class="col-md-4 footer-logo mb-4 mb-md-0">
                <?php if ( $footer_logo ) : ?>
                    <img src="<?php echo esc_url( $footer_logo ); ?>" alt="Footer Logo" class="img-fluid">
                <?php else : ?>
                    <h1 class="text-uppercase fw-bold">PHÒNG KHÁM ĐỒNG TÂM SÀI GÒN</h1>
                <?php endif; ?>
               
            </div>

            <!-- Hoạt động -->
            <div class="col-md-4 footer-activity mb-4 mb-md-0">
                <h5 class="fw-bold">Hoạt động</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Thông tin Phòng Khám</a></li>
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Đội ngũ chuyên môn</a></li>
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Lịch khám bệnh</a></li>
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Hỏi đáp sức khỏe</a></li>
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Thu viện phí</a></li>
                </ul>
            </div>

            <!-- Mạng xã hội -->
            <div class="col-md-4 footer-social">
                <h5 class="fw-bold">Kết nối với chúng tôi</h5>
                <div class="social-icons">
                    <?php foreach ( $social_links as $social ) : ?>
                        <a href="<?php echo esc_url( $social['social_url'] ); ?>" class="text-white me-3" target="_blank">
                            <i class="<?php echo esc_attr( $social['social_icon'] ); ?> fs-4"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Google Maps Section -->
        <div class="col-md-12 text-center mt-4">
            <h5 class="fw-bold">Xem bản đồ</h5>
            <iframe 
                src="<?php echo esc_url( $google_maps_url ); ?>" 
                width="100%" 
                height="250" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="footer-bottom text-center mt-4">
            <p class="mb-0"><?php echo wp_kses_post( $footer_copyright ); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>