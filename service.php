<?php 
require 'includes/app.php';

$kind = 'service';
$title = 'Services';
$detail = 'single_service';

require 'includes/header.php'; 
?>

<style>
    /* Services Banner Section with Background Slider */
    .services-banner {
        position: relative;
        color: #ffffff;
        padding: 95px 0 105px 0;
        text-align: center;
        overflow: hidden;
    }

    /* Slider Container */
    .services-slider-wrap {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .services-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 1.2s ease-in-out, transform 6s ease-out;
        transform: scale(1.05);
    }

    .services-slide.active {
        opacity: 1;
        transform: scale(1);
    }

    /* Dark Overlay for Text Readability */
    .services-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(17, 24, 39, 0.88) 0%, rgba(30, 41, 59, 0.78) 60%, rgba(15, 23, 42, 0.92) 100%);
        z-index: 2;
    }

    .services-banner .container {
        position: relative;
        z-index: 3;
    }

    .services-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d, #f59e0b);
        z-index: 4;
    }

    /* Slider Dots Indicators */
    .services-slider-dots {
        position: absolute;
        bottom: 20px;
        right: 30px;
        display: flex;
        gap: 8px;
        z-index: 4;
    }

    .services-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .services-dot.active {
        background: #f59e0b;
        transform: scale(1.25);
    }

    .services-badge {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #f59e0b;
        text-transform: uppercase;
        background: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 16px;
        backdrop-filter: blur(4px);
    }

    .services-title {
        font-size: 40px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 14px;
        line-height: 1.25;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
    }

    .services-subtitle {
        font-size: 16px;
        color: #e2e8f0;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.35);
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
        .services-slider-dots {
            bottom: 12px;
            right: 15px;
        }
    }
</style>

<!-- Banner Area with Background Slider -->
<section class="services-banner">
    <!-- 5 Images Background Slider -->
    <div class="services-slider-wrap">
        <div class="services-slide active" style="background-image: url('assets/img/bg/index1.jpeg');"></div>
        <div class="services-slide" style="background-image: url('assets/img/bg/index2.jpeg');"></div>
        <div class="services-slide" style="background-image: url('assets/img/bg/index3.jpeg');"></div>
        <div class="services-slide" style="background-image: url('assets/img/bg/index4.jpeg');"></div>
        <div class="services-slide" style="background-image: url('assets/img/bg/index5.jpeg');"></div>
    </div>

    <!-- Indicator Dots (5 Dots) -->
    <div class="services-slider-dots">
        <span class="services-dot active" onclick="goToServiceSlide(0)"></span>
        <span class="services-dot" onclick="goToServiceSlide(1)"></span>
        <span class="services-dot" onclick="goToServiceSlide(2)"></span>
        <span class="services-dot" onclick="goToServiceSlide(3)"></span>
        <span class="services-dot" onclick="goToServiceSlide(4)"></span>
    </div>

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

<!-- Services Banner Slider JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var slides = document.querySelectorAll('.services-slide');
        var dots = document.querySelectorAll('.services-dot');
        var currentSlide = 0;
        var slideInterval;

        function showSlide(index) {
            slides.forEach(function (slide) {
                slide.classList.remove('active');
            });
            dots.forEach(function (dot) {
                dot.classList.remove('active');
            });

            currentSlide = (index + slides.length) % slides.length;
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        window.goToServiceSlide = function (index) {
            showSlide(index);
            resetTimer();
        };

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function startTimer() {
            slideInterval = setInterval(nextSlide, 4500); // 4.5 seconds per slide
        }

        function resetTimer() {
            clearInterval(slideInterval);
            startTimer();
        }

        startTimer();
    });
</script>

<?php require 'includes/footer.php'; ?>