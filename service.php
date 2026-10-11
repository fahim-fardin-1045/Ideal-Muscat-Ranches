<?php 
require 'includes/app.php';

$kind = 'service';
$title = 'Services';
$detail = 'single_service';

require 'includes/header.php'; 
?>

<style>
    /* Services Banner Section */
    .services-banner {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 70px 0 80px 0;
        position: relative;
        text-align: center;
    }

    .services-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d, #f59e0b);
    }

    .services-badge {
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

    .services-title {
        font-size: 40px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 12px;
    }

    .services-subtitle {
        font-size: 16px;
        color: #cbd5e1;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Services Grid Section */
    .services-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 50vh;
    }

    .service-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .service-card-item:hover {
        transform: translateY(-7px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.1);
        border-color: #2a8f5d;
    }

    /* Service Image Thumbnail Container */
    .service-card-thumb {
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: #f1f5f9;
        position: relative;
    }

    .service-card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }

    .service-card-item:hover .service-card-thumb img {
        transform: scale(1.06);
    }

    .service-card-body {
        padding: 24px 24px 28px 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .service-card-item h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 10px;
        line-height: 1.35;
    }

    .service-card-item p {
        font-size: 14.5px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    /* Read More / View Service Button */
    .btn-view-service {
        font-size: 14px;
        font-weight: 700;
        color: #f59e0b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-view-service:hover {
        color: #d97706;
        transform: translateX(4px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .services-title {
            font-size: 30px;
        }
        .services-section {
            padding: 45px 0;
        }
    }
</style>

<!-- Banner Area -->
<section class="services-banner">
    <div class="container">
        <span class="services-badge">What We Offer</span>
        <h1 class="services-title">Our Services</h1>
        <p class="services-subtitle">
            <?= !empty($s['intro']) ? e($s['intro']) : 'Discover the wide range of professional solutions we provide.' ?>
        </p>
    </div>
</section>

<!-- Services Grid -->
<section class="services-section">
    <div class="container">
        <?php 
        $services = entries($kind); 
        if (!empty($services)): 
        ?>
            <div class="row g-4">
                <?php foreach ($services as $item): ?>
                    <?php 
                    
                    $card_img = null;
                    foreach (['image', 'img', 'thumbnail', 'photo', 'cover'] as $field) {
                        if (!empty($item[$field])) {
                            $val = $item[$field];
                            if (strpos($val, '/') !== false) {
                                $card_img = $val;
                            } elseif (file_exists("uploads/" . $val)) {
                                $card_img = "uploads/" . $val;
                            } elseif (file_exists("assets/img/" . $val)) {
                                $card_img = "assets/img/" . $val;
                            } else {
                                $card_img = $val;
                            }
                            break;
                        }
                    }
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card-item">
                           
                            <?php if (!empty($card_img)): ?>
                                <div class="service-card-thumb">
                                    <a href="<?= $detail ?>.php?id=<?= $item['id'] ?>">
                                        <img src="<?= e($card_img) ?>" alt="<?= e($item['title'] ?? 'Service') ?>">
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="service-card-body">
                                <div>
                                    <h3><?= e($item['title'] ?? '') ?></h3>
                                    <p><?= e($item['summary'] ?? '') ?></p>
                                </div>
                                <div>
                                    <a class="btn-view-service" href="<?= $detail ?>.php?id=<?= $item['id'] ?>">
                                        View service <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">No services found at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require 'includes/footer.php'; ?>