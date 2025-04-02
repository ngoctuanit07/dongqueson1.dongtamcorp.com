<?php get_header(); ?>
<?php echo do_shortcode("[custom_slider id='1']"); ?>
<!-- Highlight Section -->
<section class="highlight-section py-5">
    <div class="container">
        <!-- Popup/Call-to-Action Box -->
        <div class="cta-box text-center bg-white p-4 rounded shadow-sm mb-5">
            <h3 class="mb-4">Hãy để chúng tôi giúp bạn</h3>
            <div class="d-flex justify-content-center gap-3">
                <a href="#" class="btn btn-orange">Tìm bác sĩ</a>
                <a href="#" class="btn btn-green">Đặt lịch khám</a>
                <a href="#" class="btn btn-orange">Gợi dịch vụ</a>
            </div>
        </div>

        <!-- Info Boxes -->
        <div class="row text-center">
            <div class="col-md-3">
                <div class="info-box">
                    <i class="bi bi-award text-orange fs-1 mb-3"></i>
                    <h5>Chất lượng</h5>
                    <p>Quản lý chất lượng bệnh viện tốt</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <i class="bi bi-building text-orange fs-1 mb-3"></i>
                    <h5>Cơ sở</h5>
                    <p>Hiện đại, sạch sẽ, thông mát</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <i class="bi bi-heart-fill text-orange fs-1 mb-3"></i>
                    <h5>Hơn 3.000</h5>
                    <p>Khách hàng đã tới khám chữa bệnh</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <i class="bi bi-hand-thumbs-up text-orange fs-1 mb-3"></i>
                    <h5>>95%</h5>
                    <p>Sẵn phục đánh giá trên 4 sao</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="service-packages py-5">
    <div class="container">
        <!-- Tiêu đề -->
        <h2 class="section-title text-start mb-4">Gói dịch vụ</h2>

        <!-- Grid hiển thị các gói dịch vụ -->
        <div class="row">
            <!-- Sử dụng shortcode để hiển thị các gói dịch vụ -->
            <?php echo do_shortcode('[dichvu_list]'); ?>
        </div>
    </div>
</section>



<section class="container py-4 tintuc">
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <div class="col">
                <div class="card border-0">
                    <div class="card-body p-3">
                        <h5 class="card-title mb-2">Tin Y Tế</h5>
                        <!-- <ul class="list-unstyled mb-0">
                            <li>VĂN BẢN 4487/SYT - NVD</li>
                            <li>VĂN BẢN 4789/SYT - NVY</li>
                            <li>CHIẾN DỊCH TƯ VẤN SỨC KHỎE MIỀN PHÍA MỸ</li>
                            <li>DỊCH SANG LỌC NGẠY 10-6-2021</li>
                            <li>BỘ SƯNG PHẠM VI HÀNH NGHỀ CHUYÊN MÔN VÀO CHỨNG CHỈ HÀNH NGHỀ ĐÃ CẤP</li>
                        </ul> -->
                        <?php echo do_shortcode(" [rss_manager category='Tin y tế']"); ?>
                       
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0">
                    <div class="card-body p-3">
                        <h5 class="card-title mb-2">Văn bản mới cập nhật từ bộ y tế</h5>
                        <!-- <ul class="list-unstyled mb-0">
                            <li>Đề Tài Được Đăng Tải Trên Tạp Chí Năm 2017</li>
                            <li>https://www.facebook.com/vha.org</li>
                            <li>1. Medic - Konica Minolta (Japan)</li>
                            <li>2. Medic - Shiga University (Japan)</li>
                            <li>3. Medic - VUHA (Southwest University - USA)</li>
                        </ul> -->
                        <?php echo do_shortcode("[custom_data_table]"); ?>
                      
                       
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0">
                    <div class="card-body p-3">
                        <h5 class="card-title mb-2">Văn bản mới cập nhật của bảo hiểm xã hội</h5>
                        <!-- <ul class="list-unstyled mb-0">
                            <li>LỊCH BÁO CÁO MEDiC 7 NĂM 2025</li>
                            <li>LỊCH BÁO CÁO MEDiC 5 X-RAY - MRI - DS3 NĂM 2025</li>
                            <li>LỊCH BÁO CÁO MEDiC 5 SỐI SỐI NAM 2025</li>
                            <li>DANH SÁCH BÁC SĨ BÁO CÁO MEDiC 5 2024</li>
                            <li>LỊCH BÁO CÁO MEDiC 5 SIÊU ÂM NĂM 2024</li>
                        </ul> -->
                        <?php echo do_shortcode("[bhxh_documents]"); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>




<?php get_footer(); ?>