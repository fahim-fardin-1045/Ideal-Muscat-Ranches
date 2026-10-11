<?php 
require 'includes/app.php';
$title = 'About';
require 'includes/header.php'; 
?>

<style>
    /* About Banner Section */
    .about-banner {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 70px 0 80px 0;
        position: relative;
        text-align: center;
    }

    .about-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d, #f59e0b);
    }

    .about-badge {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #f59e0b;
        text-transform: uppercase;
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.25);
        padding: 5px 16px;
        border-radius: 50px;
        margin-bottom: 15px;
    }

    .about-title {
        font-size: 40px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 12px;
        line-height: 1.25;
    }

    .about-subtitle {
        font-size: 16px;
        color: #cbd5e1;
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Content Section */
    .about-content-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 55vh;
    }

    /* Main Story / About Card */
    .about-card-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 42px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 30px;
    }

    .about-card-box h2 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }

    .about-card-box h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 45px;
        height: 3px;
        background-color: #2a8f5d;
        border-radius: 2px;
    }

    .body-copy-text {
        font-size: 16px;
        line-height: 1.85;
        color: #475569;
        margin-bottom: 0;
        white-space: pre-line;
    }

    /* Company Details Widget */
    .company-details-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 32px 28px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 30px;
    }

    .company-details-card h3 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 24px;
        position: relative;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    .company-details-card h3::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 35px;
        height: 2px;
        background: #2a8f5d;
    }

    .info-list-group {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .info-list-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #f0fdf4;
        border: 1px solid #dcfce7;
        color: #2a8f5d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-text-wrap {
        flex-grow: 1;
    }

    .info-label {
        font-size: 12.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 3px;
        display: block;
    }

    .info-val {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 0;
        line-height: 1.5;
    }

    /* Contact CTA Widget */
    .about-cta-card {
        background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
    }

    .about-cta-card i {
        font-size: 34px;
        color: #f59e0b;
        margin-bottom: 16px;
    }

    .about-cta-card h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .about-cta-card p {
        font-size: 14px;
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 22px;
    }

    .btn-about-contact {
        display: inline-block;
        background: #2a8f5d;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        padding: 12px 26px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(42, 143, 93, 0.4);
    }

    .btn-about-contact:hover {
        background: #23764d;
        color: #ffffff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .about-title {
            font-size: 28px;
        }
        .about-card-box {
            padding: 24px;
        }
    }
</style>

<!-- Banner Header -->
<section class="about-banner">
    <div class="container">
        <span class="about-badge">Who We Are</span>
        <h1 class="about-title">About <?= e($s['company_name']) ?></h1>
        <p class="about-subtitle">
            <?= !empty($s['intro']) ? e($s['intro']) : 'Dedicated to delivering exceptional quality, integrity, and sustainable solutions.' ?>
        </p>
    </div>
</section>

<!-- Main Content Area -->
<section class="about-content-section">
    <div class="container">
        <div class="row g-4">
            
            <!-- Left Column: Story / About Content -->
            <div class="col-lg-8">
                <div class="about-card-box">
                    <h2>Our Mission & Vision</h2>
                    <p class="body-copy-text">
                        <?= e($s['about']) ?>
                    </p>
                </div>
            </div>

            <!-- Right Column: Official Company Details & Contact Box -->
            <div class="col-lg-4">
                
                <!-- Company Details Widget -->
                <div class="company-details-card">
                    <h3>Company Details</h3>
                    <ul class="info-list-group">
                        
                        <!-- Registered Office -->
                        <?php if (!empty($s['address'])): ?>
                            <li class="info-list-item">
                                <div class="info-icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Registered Office</span>
                                    <p class="info-val"><?= e($s['address']) ?></p>
                                </div>
                            </li>
                        <?php endif; ?>

                        <!-- NIPC -->
                        <?php if (!empty($s['nipc'])): ?>
                            <li class="info-list-item">
                                <div class="info-icon">
                                    <i class="fa fa-id-card-o"></i>
                                </div>
                                <div class="info-text-wrap">
                                    <span class="info-label">NIPC Registration</span>
                                    <p class="info-val"><?= e($s['nipc']) ?></p>
                                </div>
                            </li>
                        <?php endif; ?>

                        <!-- Company Name -->
                        <li class="info-list-item">
                            <div class="info-icon">
                                <i class="fa fa-building-o"></i>
                            </div>
                            <div class="info-text-wrap">
                                <span class="info-label">Corporate Entity</span>
                                <p class="info-val"><?= e($s['company_name']) ?></p>
                            </div>
                        </li>

                    </ul>
                </div>

                <!-- Contact CTA Box -->
                <div class="about-cta-card">
                    <i class="fa fa-envelope-o"></i>
                    <h4>Want to Connect?</h4>
                    <p>Have questions or wish to collaborate? Reach out to us directly.</p>
                    <a href="contact.php" class="btn-about-contact">Contact Us</a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>