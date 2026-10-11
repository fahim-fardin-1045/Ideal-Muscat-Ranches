<?php 
require 'includes/app.php';

$kind = 'service';
$id = $_GET['id'] ?? null;
$all_services = entries($kind);


$item = null;
if ($id && !empty($all_services)) {
    foreach ($all_services as $s_item) {
        if ($s_item['id'] == $id) {
            $item = $s_item;
            break;
        }
    }
}


if (!$item && !empty($all_services)) {
    $item = $all_services[0];
}

$title = !empty($item['title']) ? $item['title'] : 'Service Details';


$service_img = null;
foreach (['image', 'img', 'photo', 'thumbnail', 'cover'] as $key) {
    if (!empty($item[$key])) {
        $img_val = $item[$key];
       
        if (strpos($img_val, '/') !== false) {
            $service_img = $img_val;
        } elseif (file_exists("uploads/" . $img_val)) {
            $service_img = "uploads/" . $img_val;
        } elseif (file_exists("assets/img/" . $img_val)) {
            $service_img = "assets/img/" . $img_val;
        } else {
            $service_img = $img_val;
        }
        break;
    }
}

require 'includes/header.php'; 
?>

<style>
    /* Service Details Banner */
    .service-detail-banner {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 70px 0 80px 0;
        position: relative;
    }

    .service-detail-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d, #f59e0b);
    }

    .banner-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .banner-breadcrumb a {
        color: #f59e0b;
        text-decoration: none;
    }

    .banner-breadcrumb a:hover {
        text-decoration: underline;
    }

    .service-detail-title {
        font-size: 38px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.25;
        margin: 0;
    }

    /* Content Area */
    .detail-content-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 55vh;
    }

    /* Main Service Article Card */
    .service-article-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 42px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 30px;
    }

    /* Featured Service Image Styling */
    .service-featured-img-wrap {
        width: 100%;
        max-height: 420px;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    }

    .service-featured-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .service-article-box h2 {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }

    .service-article-box h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 45px;
        height: 3px;
        background-color: #2a8f5d;
        border-radius: 2px;
    }

    .service-body-copy {
        font-size: 16px;
        line-height: 1.85;
        color: #475569;
        margin-bottom: 28px;
        white-space: pre-line;
    }

    .service-summary-highlight {
        background: #f0fdf4;
        border-left: 4px solid #2a8f5d;
        padding: 18px 22px;
        border-radius: 0 10px 10px 0;
        font-size: 16px;
        color: #1e3a29;
        font-weight: 500;
        margin-bottom: 28px;
        line-height: 1.6;
    }

    /* Sidebar Styling */
    .sidebar-widget {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px 24px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 30px;
    }

    .widget-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 18px;
        position: relative;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    .widget-title::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 32px;
        height: 2px;
        background: #2a8f5d;
    }

    /* Other Services Nav */
    .service-sidebar-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .service-sidebar-list li {
        margin-bottom: 10px;
    }

    .service-sidebar-list li a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #334155;
        font-size: 14.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .service-sidebar-list li a:hover,
    .service-sidebar-list li a.active {
        background: #2a8f5d;
        color: #ffffff;
        border-color: #2a8f5d;
        padding-left: 20px;
    }

    .service-sidebar-list li a i {
        font-size: 12px;
        opacity: 0.7;
    }

    /* Sidebar Contact CTA Box */
    .sidebar-cta-box {
        background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
    }

    .sidebar-cta-box i {
        font-size: 36px;
        color: #f59e0b;
        margin-bottom: 16px;
    }

    .sidebar-cta-box h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .sidebar-cta-box p {
        font-size: 14px;
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 22px;
    }

    .btn-cta-contact {
        display: inline-block;
        background: #2a8f5d;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        padding: 12px 24px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(42, 143, 93, 0.4);
    }

    .btn-cta-contact:hover {
        background: #23764d;
        color: #ffffff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .service-detail-title {
            font-size: 28px;
        }
        .service-article-box {
            padding: 24px;
        }
    }
</style>

<!-- Banner Section -->
<section class="service-detail-banner">
    <div class="container">
        <div class="banner-breadcrumb">
            <a href="index.php">Home</a> <span>/</span> 
            <a href="service.php">Services</a> <span>/</span> 
            <span>Details</span>
        </div>
        <h1 class="service-detail-title"><?= e($item['title'] ?? 'Service Details') ?></h1>
    </div>
</section>

<!-- Main Details & Sidebar Section -->
<section class="detail-content-section">
    <div class="container">
        <div class="row g-4">
            
            <!-- Left: Main Service Content -->
            <div class="col-lg-8">
                <article class="service-article-box">

                    <!-- Featured Service Image -->
                    <?php if (!empty($service_img)): ?>
                        <div class="service-featured-img-wrap">
                            <img src="<?= e($service_img) ?>" alt="<?= e($item['title'] ?? 'Service Image') ?>">
                        </div>
                    <?php endif; ?>

                    <h2><?= e($item['title'] ?? '') ?></h2>

                    <?php if (!empty($item['summary'])): ?>
                        <div class="service-summary-highlight">
                            <?= e($item['summary']) ?>
                        </div>
                    <?php endif; ?>

                    <div class="service-body-copy">
                        <?php if (!empty($item['content'])): ?>
                            <?= e($item['content']) ?>
                        <?php elseif (!empty($item['description'])): ?>
                            <?= e($item['description']) ?>
                        <?php else: ?>
                            <p>We provide comprehensive and top-tier services tailored to meet your unique needs and exceed your expectations. Contact us today to learn more about how we can support your business.</p>
                        <?php endif; ?>
                    </div>

                    <a href="service.php" class="btn btn-outline-secondary" style="border-radius: 50px; padding: 9px 22px; font-weight: 600; font-size: 14px;">
                        ← Back to all services
                    </a>
                </article>
            </div>

            <!-- Right: Sidebar -->
            <div class="col-lg-4">
                
                <!-- Other Services Navigation -->
                <?php if (!empty($all_services)): ?>
                    <div class="sidebar-widget">
                        <h4 class="widget-title">All Services</h4>
                        <ul class="service-sidebar-list">
                            <?php foreach ($all_services as $s_item): ?>
                                <?php $is_current = ($item && $item['id'] == $s_item['id']) ? 'active' : ''; ?>
                                <li>
                                    <a href="single_service.php?id=<?= $s_item['id'] ?>" class="<?= $is_current ?>">
                                        <span><?= e($s_item['title']) ?></span>
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Need Help / Contact Card -->
                <div class="sidebar-cta-box">
                    <i class="fa fa-phone-square"></i>
                    <h4>Need Any Help?</h4>
                    <p>Contact our expert team today to get personalized solutions for your project.</p>
                    <a href="contact.php" class="btn-cta-contact">Get in Touch</a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>