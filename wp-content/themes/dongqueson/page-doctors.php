<?php
/*
Template Name: Doctors Page
*/
get_header(); ?>

<!-- Doctors Section -->
<section class="doctors-section py-5">
    <div class="container">
        <!-- Tabs Navigation -->
        <div class="doctors-tabs mb-4">
            <h2 class="section-title text-orange mb-3">Đội ngũ chuyên môn</h2>
            <ul class="nav nav-tabs justify-content-center" id="doctorsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">Tất cả</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="otolaryngology-tab" data-bs-toggle="tab" data-bs-target="#otolaryngology" type="button" role="tab" aria-controls="otolaryngology" aria-selected="false">Nhĩ khoa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="obstetrics-tab" data-bs-toggle="tab" data-bs-target="#obstetrics" type="button" role="tab" aria-controls="obstetrics" aria-selected="false">Sản khoa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="resuscitation-tab" data-bs-toggle="tab" data-bs-target="#resuscitation" type="button" role="tab" aria-controls="resuscitation" aria-selected="false">Hồi sức</button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="doctorsTabContent">
            <!-- All Tab -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <div class="row">
                    <div class="col-md-2 mb-4">
                        <div class="doctor-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/doctor1.jpg" alt="Dr. Nguyen Thi Ngo" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Bác sĩ CKI Nguyễn Thị Ngọ</h5>
                                <p class="card-text">Phụ khoa XN - CDHA<br>Chuyên môn: Nhĩ, Huyết học</p>
                                <div class="contact-icons">
                                    <a href="tel:02353845900"><i class="bi bi-telephone-fill text-success"></i></a>
                                    <a href="https://zalo.me/your-zalo-id"><i class="bi bi-chat-fill text-primary"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-4">
                        <div class="doctor-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/doctor2.jpg" alt="Dr. Tran Thi Tram Nhan" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Bác sĩ CKI Trần Thị Trâm Nhẫn</h5>
                                <p class="card-text">Truyền khoa NH - TN<br>Chuyên môn: Nhĩ khoa</p>
                                <div class="contact-icons">
                                    <a href="tel:02353845900"><i class="bi bi-telephone-fill text-success"></i></a>
                                    <a href="https://zalo.me/your-zalo-id"><i class="bi bi-chat-fill text-primary"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-4">
                        <div class="doctor-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/doctor3.jpg" alt="Dr. Pham Thi Lan" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Bác sĩ CKI Phạm Thị Lành</h5>
                                <p class="card-text">Phụ khoa KSNK - Định dưỡng<br>Chuyên môn: Nhĩ, Định dưỡng</p>
                                <div class="contact-icons">
                                    <a href="tel:02353845900"><i class="bi bi-telephone-fill text-success"></i></a>
                                    <a href="https://zalo.me/your-zalo-id"><i class="bi bi-chat-fill text-primary"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-4">
                        <div class="doctor-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/doctor4.jpg" alt="Dr. Tran Thi Thanh Thao" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Bác sĩ CKI Trần Thị Thanh Thảo</h5>
                                <p class="card-text">Phụ khoa XN - CDHA<br>Chuyên môn: Nhĩ, CDHA</p>
                                <div class="contact-icons">
                                    <a href="tel:02353845900"><i class="bi bi-telephone-fill text-success"></i></a>
                                    <a href="https://zalo.me/your-zalo-id"><i class="bi bi-chat-fill text-primary"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-4">
                        <div class="doctor-card">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/doctor5.jpg" alt="Dr. Nguyen Cao Thinh" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Bác sĩ CKI Nguyễn Cao Thịnh</h5>
                                <p class="card-text">Phụ khoa KBCC<br>Chuyên môn: Da liễu</p>
                                <div class="contact-icons">
                                    <a href="tel:02353845900"><i class="bi bi-telephone-fill text-success"></i></a>
                                    <a href="https://zalo.me/your-zalo-id"><i class="bi bi-chat-fill text-primary"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Other Tabs (Add similar content for Otolaryngology, Obstetrics, Resuscitation if needed) -->
            <div class="tab-pane fade" id="otolaryngology" role="tabpanel" aria-labelledby="otolaryngology-tab">
                <p>Content for Nhĩ khoa...</p>
            </div>
            <div class="tab-pane fade" id="obstetrics" role="tabpanel" aria-labelledby="obstetrics-tab">
                <p>Content for Sản khoa...</p>
            </div>
            <div class="tab-pane fade" id="resuscitation" role="tabpanel" aria-labelledby="resuscitation-tab">
                <p>Content for Hồi sức...</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>