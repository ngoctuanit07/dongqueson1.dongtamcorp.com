<?php
/*
Template Name: Services Page
*/
get_header(); ?>

<!-- Services Section -->
<section class="services-section py-5">
    <div class="container">
        <!-- Tabs Navigation -->
        <div class="services-tabs mb-4">
            <ul class="nav nav-tabs justify-content-center" id="servicesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">Tất cả</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="obstetrics-tab" data-bs-toggle="tab" data-bs-target="#obstetrics" type="button" role="tab" aria-controls="obstetrics" aria-selected="false">Sản khoa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="otolaryngology-tab" data-bs-toggle="tab" data-bs-target="#otolaryngology" type="button" role="tab" aria-controls="otolaryngology" aria-selected="false">Nhĩ khoa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gynecology-tab" data-bs-toggle="tab" data-bs-target="#gynecology" type="button" role="tab" aria-controls="gynecology" aria-selected="false">Phụ khoa</button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="servicesTabContent">
            <!-- All Tab -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="service-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/service1.jpg" alt="Service 1" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Điều trị Plasma vét cứng rắn</h5>
                                <p class="card-text">Liên hệ bảo gia. Chết tia Plasma vét cứng rắn làm sạch nồng độ dai vỡ cồn thành phần hoạc chất nhũ oxy, nitro, ion, electron, tia tử ngoại (UV)...</p>
                                <a href="tel:02353845900" class="btn btn-orange">Gọi 02353 845 900</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="service-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/service2.jpg" alt="Service 2" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Điều trị Plasma vét mờ mòn</h5>
                                <p class="card-text">Liên hệ bảo gia. Chết tia Plasma làm sạch nồng độ dai vỡ cồn thành phần hoạc chất nhũ oxy, nitro, ion, electron, tia tử ngoại (UV)...</p>
                                <a href="tel:02353845900" class="btn btn-orange">Gọi 02353 845 900</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="service-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/service3.jpg" alt="Service 3" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Điều trị Plasma vét thô ráp</h5>
                                <p class="card-text">Liên hệ bảo gia. Chết tia Plasma vét thô ráp làm sạch nồng độ dai vỡ cồn thành phần hoạc chất nhũ oxy, nitro, ion, electron, tia tử ngoại (UV)...</p>
                                <a href="tel:02353845900" class="btn btn-orange">Gọi 02353 845 900</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="service-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/service4.jpg" alt="Service 4" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Gói chăm sóc Mẹ và Bé sau sinh</h5>
                                <p class="card-text">Liên hệ bảo gia. Chăm sóc mẹ và bé sau sinh (Gói chăm sóc tại nhà trong 60 ngày).</p>
                                <a href="tel:02353845900" class="btn btn-orange">Gọi 02353 845 900</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Other Tabs (Add similar content for Obstetrics, Otolaryngology, Gynecology if needed) -->
            <div class="tab-pane fade" id="obstetrics" role="tabpanel" aria-labelledby="obstetrics-tab">
                <p>Content for Sản khoa...</p>
            </div>
            <div class="tab-pane fade" id="otolaryngology" role="tabpanel" aria-labelledby="otolaryngology-tab">
                <p>Content for Nhĩ khoa...</p>
            </div>
            <div class="tab-pane fade" id="gynecology" role="tabpanel" aria-labelledby="gynecology-tab">
                <p>Content for Phụ khoa...</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>