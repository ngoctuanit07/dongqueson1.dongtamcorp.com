<?php get_header(); ?>

<?php echo do_shortcode("[custom_slider id='1']"); ?>

<!-- Highlight Section -->
<section class="highlight-section py-4 py-md-5">
    <div class="container">
        <!-- Popup/Call-to-Action Box -->
        <div class="cta-box text-center bg-white p-3 p-md-4 rounded shadow-sm mb-4 mb-md-5">
            <h3 class="mb-3 mb-md-4">Hãy để chúng tôi giúp bạn</h3>
            <div class="d-flex flex-column flex-sm-row flex-wrap justify-content-center gap-2 gap-md-3">
                <a href="/doi-ngu-bac-si/" class="btn btn-green">Tìm bác sĩ</a>
                <a href="/lien-he/" class="btn btn-green">Đặt lịch khám</a>
                <a href="/dich-vu/" class="btn btn-green">Gợi dịch vụ</a>
            </div>
        </div>

        <!-- Info Boxes -->
        <div class="row row-cols-2 row-cols-md-4 text-center gy-3 gy-md-4">
            <div class="col mb-4">
                <div class="info-box">
                    <i class="bi bi-award text-orange fs-1 mb-2 mb-md-3"></i>
                    <h5>Chất lượng</h5>
                    <p class="mb-0">Quản lý chất lượng bệnh viện tốt</p>
                </div>
            </div>
            <div class="col mb-4">
                <div class="info-box">
                    <i class="bi bi-building text-orange fs-1 mb-2 mb-md-3"></i>
                    <h5>Cơ sở</h5>
                    <p class="mb-0">Hiện đại, sạch sẽ, thông mát</p>
                </div>
            </div>
            <div class="col mb-4">
                <div class="info-box">
                    <i class="bi bi-heart-fill text-orange fs-1 mb-2 mb-md-3"></i>
                    <h5>Hơn 3.000</h5>
                    <p class="mb-0">Khách hàng đã tới khám chữa bệnh</p>
                </div>
            </div>
            <div class="col mb-4">
                <div class="info-box">
                    <i class="bi bi-hand-thumbs-up text-orange fs-1 mb-2 mb-md-3"></i>
                    <h5>&gt;95%</h5>
                    <p class="mb-0">Sẵn phục đánh giá trên 4 sao</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Packages Section -->
<section class="service-packages py-4 py-md-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Các gói dịch vụ</h2>
        <div class="row gy-4">
            <?php echo do_shortcode('[dich_vu_phong_kham]'); ?>
        </div>
    </div>
</section>

<!-- Doctors Section -->
<section class="service-packages py-4 py-md-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Đội ngũ bác sĩ</h2>
        <div class="row gy-4">
            <?php echo do_shortcode('[doctor_list]'); ?>
        </div>
    </div>
</section>

<!-- Medical Knowledge Section -->
<section class="service-packages py-4 py-md-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Kiến thức y khoa</h2>
        <div class="row gy-4">
            <?php echo do_shortcode('[kien_thuc_y_khoa]'); ?>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="container py-4 tintuc">
    <h2 class="section-title text-center mb-4">Tin tức</h2>
    <div class="row row-cols-1 row-cols-md-3 gy-3 gx-3">
        <!-- Tin Y Tế -->
        <div class="col">
            <div class="card border-0 h-100">
                <div class="card-body p-3">
                    <h5 class="card-title mb-2">Tin Y Tế</h5>
                    <?php echo do_shortcode("[rss_manager category='Tin y tế']"); ?>
                </div>
            </div>
        </div>

        <!-- Văn bản mới cập nhật từ bộ y tế -->
        <div class="col">
            <div class="card border-0 h-100">
                <div class="card-body p-3">
                    <h5 class="card-title mb-2">Văn bản mới cập nhật từ bộ y tế</h5>
                    <?php echo do_shortcode("[custom_data_table]"); ?>
                </div>
            </div>
        </div>

        <!-- Văn bản mới cập nhật của bảo hiểm xã hội -->
        <div class="col">
            <div class="card border-0 h-100">
                <div class="card-body p-3">
                    <h5 class="card-title mb-2">Văn bản mới cập nhật của bảo hiểm xã hội</h5>
                    <?php echo do_shortcode("[bhxh_documents]"); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
