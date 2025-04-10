<?php get_header(); ?>

<?php echo do_shortcode("[custom_slider id='1']"); ?>

<!-- Highlight Section -->
<section class="highlight-section py-5">
    <div class="container">
        <!-- Popup/Call-to-Action Box -->
        <div class="cta-box text-center bg-white p-4 rounded shadow-sm mb-5">
            <h3 class="mb-4">Hãy để chúng tôi giúp bạn</h3>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="/doi-ngu-bac-si/" class="btn btn-orange">Tìm bác sĩ</a>
                <a href="/lien-he/" class="btn btn-green">Đặt lịch khám</a>
                <a href="/dich-vu/" class="btn btn-orange">Gợi dịch vụ</a>
            </div>
        </div>

        <!-- Info Boxes -->
        <div class="row text-center">
            <div class="col-6 col-md-3 mb-4">
                <div class="info-box">
                    <i class="bi bi-award text-orange fs-1 mb-3"></i>
                    <h5>Chất lượng</h5>
                    <p>Quản lý chất lượng bệnh viện tốt</p>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-4">
                <div class="info-box">
                    <i class="bi bi-building text-orange fs-1 mb-3"></i>
                    <h5>Cơ sở</h5>
                    <p>Hiện đại, sạch sẽ, thông mát</p>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-4">
                <div class="info-box">
                    <i class="bi bi-heart-fill text-orange fs-1 mb-3"></i>
                    <h5>Hơn 3.000</h5>
                    <p>Khách hàng đã tới khám chữa bệnh</p>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-4">
                <div class="info-box">
                    <i class="bi bi-hand-thumbs-up text-orange fs-1 mb-3"></i>
                    <h5>>95%</h5>
                    <p>Sẵn phục đánh giá trên 4 sao</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Packages Section -->
<section class="service-packages py-5">
    <div class="container">
        <div class="row">
            <?php echo do_shortcode('[dich_vu_phong_kham]'); ?>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="container py-4 tintuc">
    <h2 class="section-title text-center mb-4">Tin tức</h2>
    <div class="row row-cols-1 row-cols-md-3 g-3">
        <!-- Tin Y Tế -->
        <div class="col">
            <div class="card border-0">
                <div class="card-body p-3">
                    <h5 class="card-title mb-2">Tin Y Tế</h5>
                    <?php echo do_shortcode("[rss_manager category='Tin y tế']"); ?>
                </div>
            </div>
        </div>

        <!-- Văn bản mới cập nhật từ bộ y tế -->
        <div class="col">
            <div class="card border-0">
                <div class="card-body p-3">
                    <h5 class="card-title mb-2">Văn bản mới cập nhật từ bộ y tế</h5>
                    <?php echo do_shortcode("[custom_data_table]"); ?>
                </div>
            </div>
        </div>

        <!-- Văn bản mới cập nhật của bảo hiểm xã hội -->
        <div class="col">
            <div class="card border-0">
                <div class="card-body p-3">
                    <h5 class="card-title mb-2">Văn bản mới cập nhật của bảo hiểm xã hội</h5>
                    <?php echo do_shortcode("[bhxh_documents]"); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>