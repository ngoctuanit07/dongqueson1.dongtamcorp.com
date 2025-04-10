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
<footer class="footer-section text-white" style="background-color: <?php echo esc_attr( $footer_bg_color ); ?>;">
    <div class="container py-5">
        <div class="row">
            <!-- Logo Footer -->
            <div class="col-md-5 footer-logo mb-4 mb-md-0 text-center text-md-start">
                <?php if ( $footer_logo ) : ?>
                    <img src="<?php echo esc_url( $footer_logo ); ?>" alt="Footer Logo" class="img-fluid mb-3">
                <?php else : ?>
                    <h1 class="text-uppercase fw-bold">PHÒNG KHÁM ĐỒNG TÂM SÀI GÒN</h1>
                <?php endif; ?>
                <p class="small">
                    <?php esc_html_e( 'Chúng tôi luôn sẵn sàng phục vụ bạn với đội ngũ chuyên môn tận tâm và chuyên nghiệp.', 'dongqueson' ); ?>
                </p>
            </div>

            <!-- Hoạt động -->
            <div class="col-md-3 footer-activity mb-4 mb-md-0">
                <h5 class="fw-bold text-uppercase mb-4">Hoạt động</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Thông tin Phòng Khám</a></li>
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Đội ngũ chuyên môn</a></li>
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Lịch khám bệnh</a></li>
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Hỏi đáp sức khỏe</a></li>
                    <li><a href="#" class="text-decoration-none text-white"><i class="bi bi-chevron-right me-2"></i>Thu viện phí</a></li>
                </ul>
            </div>

            <!-- Mạng xã hội và Google Maps -->
            <div class="col-md-4 footer-social text-center text-md-start">
                <h5 class="fw-bold text-uppercase mb-4">Kết nối với chúng tôi</h5>
                <div class="social-icons mb-4">
                    <?php foreach ( $social_links as $social ) : ?>
                        <a href="<?php echo esc_url( $social['social_url'] ); ?>" class="text-white me-3" target="_blank">
                            <i class="<?php echo esc_attr( $social['social_icon'] ); ?> fs-4"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
                <h5 class="fw-bold text-uppercase mb-4">Xem bản đồ</h5>
                <iframe 
                    src="<?php echo esc_url( $google_maps_url ); ?>" 
                    width="100%" 
                    height="200" 
                    style="border:0; border-radius: 8px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <div class="footer-bottom text-center mt-5">
            <p class="mb-0 small"><?php echo wp_kses_post( $footer_copyright ); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>