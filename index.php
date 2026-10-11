<?php 
require 'includes/app.php';
require 'includes/header.php'; 
?>

<style>
    /* Hero Section Styling */
    .hero-custom {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 90px 0 100px 0;
        position: relative;
        overflow: hidden;
    }

    .hero-custom::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d, #f59e0b);
    }

    .hero-badge {
        display: inline-block;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 2.5px;
        color: #f59e0b;
        text-transform: uppercase;
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.25);
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 20px;
    }

    .hero-title {
        font-size: 44px;
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
        margin-bottom: 20px;
        max-width: 850px;
    }

    .hero-intro {
        font-size: 18px;
        line-height: 1.7;
        color: #cbd5e1;
        max-width: 750px;
        margin-bottom: 35px;
    }

    /* Primary CTA Button */
    .btn-company-styled {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #2a8f5d;
        color: #ffffff;
        font-size: 15px;
        font-weight: 600;
        padding: 13px 28px;
        border-radius: 50px;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(42, 143, 93, 0.35);
        transition: all 0.3s ease;
    }

    .btn-company-styled:hover {
        background-color: #23764d;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(42, 143, 93, 0.45);
        text-decoration: none;
    }

    /* Content & About Section */
    .section-main {
        padding: 70px 0;
        background-color: #f8fafc;
    }

    .about-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 50px;
    }

    .section-heading {
        font-size: 30px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .section-heading::after {
        content: '';
        display: block;
        width: 45px;
        height: 3px;
        background-color: #2a8f5d;
        margin-top: 8px;
        border-radius: 2px;
    }

    .body-copy-styled {
        font-size: 16px;
        line-height: 1.8;
        color: #475569;
        margin-bottom: 24px;
    }

    .btn-link-learn {
        display: inline-flex;
        align-items: center;
        font-size: 15px;
        font-weight: 700;
        color: #2a8f5d;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-link-learn:hover {
        color: #1e6642;
        transform: translateX(4px);
        text-decoration: none;
    }

    /* Services Grid & Cards */
    .company-card-styled {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 30px 26px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        transition: all 0.3s ease;
        position: relative;
    }

    .company-card-styled:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.1);
        border-color: #2a8f5d;
    }

    .company-card-styled h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 14px;
    }

    .company-card-styled p {
        font-size: 14.5px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .btn-service-view {
        font-size: 14px;
        font-weight: 700;
        color: #f59e0b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }

    .btn-service-view:hover {
        color: #d97706;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 32px;
        }
        .hero-intro {
            font-size: 16px;
        }
        .about-box {
            padding: 24px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero hero-custom">
    <div class="container">
        <span class="hero-badge">AMADORA · PORTUGAL</span>
        <h1 class="hero-title"><?= e($s['headline']) ?></h1>
        <p class="hero-intro"><?= e($s['intro']) ?></p>
        <a class="btn-company-styled" href="contact.php">
            Contact our company <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- Content & Services Section -->
<section class="section section-main">
    <div class="container">
        <!-- About Box -->
        <div class="about-box">
            <h2 class="section-heading">About our company</h2>
            <p class="body-copy body-copy-styled"><?= e($s['about']) ?></p>
            <a class="btn-link-learn" href="about.php">
                Learn more &nbsp;→
            </a>
        </div>

        <!-- Services Section -->
        <?php 
        $items = array_slice(entries('service'), 0, 3);
        if ($items): 
        ?>
            <div class="mb-4">
                <h2 class="section-heading">Our services</h2>
            </div>
            
            <div class="row g-4 entry-grid">
                <?php foreach ($items as $item): ?>
                    <div class="col-md-4">
                        <div class="company-card company-card-styled">
                            <div>
                                <h3><?= e($item['title']) ?></h3>
                                <p><?= e($item['summary']) ?></p>
                            </div>
                            <a class="btn-service-view" href="single_service.php?id=<?= $item['id'] ?>">
                                View service <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require 'includes/footer.php'; ?>