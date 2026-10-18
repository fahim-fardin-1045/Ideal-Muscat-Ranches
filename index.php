<?php 
require 'includes/app.php';
require 'includes/header.php'; 
?>

<style>
    /* Hero Section Styling with Slider */
    .hero-custom {
        position: relative;
        color: #ffffff;
        padding: 120px 0 130px 0;
        overflow: hidden;
    }

    /* Slider Container */
    .hero-slider-wrap {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .hero-slide {
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

    .hero-slide.active {
        opacity: 1;
        transform: scale(1);
    }

    /* Dark Overlay for Text Readability */
    .hero-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(17, 24, 39, 0.88) 0%, rgba(30, 41, 59, 0.75) 60%, rgba(15, 23, 42, 0.90) 100%);
        z-index: 2;
    }

    .hero-custom .container {
        position: relative;
        z-index: 3;
    }

    .hero-custom::after {
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
    .hero-slider-dots {
        position: absolute;
        bottom: 25px;
        right: 40px;
        display: flex;
        gap: 8px;
        z-index: 4;
    }

    .hero-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .hero-dot.active {
        background: #f59e0b;
        transform: scale(1.25);
    }

    .hero-badge {
        display: inline-block;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 2.5px;
        color: #f59e0b;
        text-transform: uppercase;
        background: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 20px;
        backdrop-filter: blur(4px);
    }

    .hero-title {
        font-size: 44px;
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
        margin-bottom: 20px;
        max-width: 850px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }

    .hero-intro {
        font-size: 18px;
        line-height: 1.7;
        color: #e2e8f0;
        max-width: 750px;
        margin-bottom: 35px;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.4);
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
        box-shadow: 0 4px 15px rgba(42, 143, 93, 0.45);
        transition: all 0.3s ease;
    }

    .btn-company-styled:hover {
        background-color: #23764d;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(42, 143, 93, 0.55);
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
        .hero-slider-dots {
            bottom: 15px;
            right: 20px;
        }
    }
</style>

<!-- Hero Section with Background Slider -->
<section class="hero hero-custom">
    <!-- 5 Images Background Slider -->
    <div class="hero-slider-wrap">
        <div class="hero-slide active" style="background-image: url('assets/img/bg/index1.jpeg');"></div>
        <div class="hero-slide" style="background-image: url('assets/img/bg/index2.jpeg');"></div>
        <div class="hero-slide" style="background-image: url('assets/img/bg/index3.jpeg');"></div>
        <div class="hero-slide" style="background-image: url('assets/img/bg/index4.jpeg');"></div>
        <div class="hero-slide" style="background-image: url('assets/img/bg/index5.jpeg');"></div>
    </div>

    <!-- Indicator Dots (5 Dots) -->
    <div class="hero-slider-dots">
        <span class="hero-dot active" onclick="goToSlide(0)"></span>
        <span class="hero-dot" onclick="goToSlide(1)"></span>
        <span class="hero-dot" onclick="goToSlide(2)"></span>
        <span class="hero-dot" onclick="goToSlide(3)"></span>
        <span class="hero-dot" onclick="goToSlide(4)"></span>
    </div>

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

<!-- Slider JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var slides = document.querySelectorAll('.hero-slide');
        var dots = document.querySelectorAll('.hero-dot');
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

        window.goToSlide = function (index) {
            showSlide(index);
            resetTimer();
        };

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function startTimer() {
            slideInterval = setInterval(nextSlide, 4500); // 4.5 seconds
        }

        function resetTimer() {
            clearInterval(slideInterval);
            startTimer();
        }

        startTimer();
    });
</script>

<?php require 'includes/footer.php'; ?>