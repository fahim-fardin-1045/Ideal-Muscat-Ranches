<?php 
require 'includes/app.php';

$kind = 'project';
$title = 'Projects';
$detail = 'single_project';

require 'includes/header.php'; 
?>

<style>
    /* Portfolio Banner Section with Background Slider */
    .portfolio-banner {
        position: relative;
        color: #ffffff;
        padding: 95px 0 105px 0;
        text-align: center;
        overflow: hidden;
    }

    /* Slider Container */
    .portfolio-slider-wrap {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .portfolio-slide {
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

    .portfolio-slide.active {
        opacity: 1;
        transform: scale(1);
    }

    /* Dark Overlay for Text Readability */
    .portfolio-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(17, 24, 39, 0.88) 0%, rgba(30, 41, 59, 0.78) 60%, rgba(15, 23, 42, 0.92) 100%);
        z-index: 2;
    }

    .portfolio-banner .container {
        position: relative;
        z-index: 3;
    }

    .portfolio-banner::after {
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
    .portfolio-slider-dots {
        position: absolute;
        bottom: 20px;
        right: 30px;
        display: flex;
        gap: 8px;
        z-index: 4;
    }

    .portfolio-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .portfolio-dot.active {
        background: #f59e0b;
        transform: scale(1.25);
    }

    .portfolio-badge {
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

    .portfolio-title {
        font-size: 40px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 14px;
        line-height: 1.25;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
    }

    .portfolio-subtitle {
        font-size: 16px;
        color: #e2e8f0;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.35);
    }

    /* Portfolio Grid Section */
    .portfolio-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 55vh;
    }

    .portfolio-card-item {
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

    .portfolio-card-item:hover {
        transform: translateY(-7px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.1);
        border-color: #2a8f5d;
    }

    /* Thumbnail Box */
    .portfolio-card-thumb {
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: #0f172a;
        position: relative;
    }

    .portfolio-card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }

    .portfolio-card-item:hover .portfolio-card-thumb img {
        transform: scale(1.06);
    }

    .portfolio-card-body {
        padding: 24px 24px 28px 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .portfolio-card-item h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 10px;
        line-height: 1.35;
    }

    .portfolio-card-item p {
        font-size: 14.5px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    /* Read More / View Project Link */
    .btn-view-project {
        font-size: 14px;
        font-weight: 700;
        color: #f59e0b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-view-project:hover {
        color: #d97706;
        transform: translateX(4px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .portfolio-title {
            font-size: 30px;
        }
        .portfolio-section {
            padding: 45px 0;
        }
        .portfolio-slider-dots {
            bottom: 12px;
            right: 15px;
        }
    }
</style>

<!-- Banner Area with Background Slider -->
<section class="portfolio-banner">
    <!-- 5 Images Background Slider -->
    <div class="portfolio-slider-wrap">
        <div class="portfolio-slide active" style="background-image: url('assets/img/bg/index1.jpeg');"></div>
        <div class="portfolio-slide" style="background-image: url('assets/img/bg/index2.jpeg');"></div>
        <div class="portfolio-slide" style="background-image: url('assets/img/bg/index3.jpeg');"></div>
        <div class="portfolio-slide" style="background-image: url('assets/img/bg/index4.jpeg');"></div>
        <div class="portfolio-slide" style="background-image: url('assets/img/bg/index5.jpeg');"></div>
    </div>

    <!-- Indicator Dots (5 Dots) -->
    <div class="portfolio-slider-dots">
        <span class="portfolio-dot active" onclick="goToPortfolioSlide(0)"></span>
        <span class="portfolio-dot" onclick="goToPortfolioSlide(1)"></span>
        <span class="portfolio-dot" onclick="goToPortfolioSlide(2)"></span>
        <span class="portfolio-dot" onclick="goToPortfolioSlide(3)"></span>
        <span class="portfolio-dot" onclick="goToPortfolioSlide(4)"></span>
    </div>

    <div class="container">
        <span class="portfolio-badge">Our Showcase</span>
        <h1 class="portfolio-title">Featured Projects</h1>
        <p class="portfolio-subtitle">
            Explore our latest delivered work, successful collaborations, and achievements.
        </p>
    </div>
</section>

<!-- Projects Grid -->
<section class="portfolio-section">
    <div class="container">
        <?php 
        $projects = entries($kind); 
        if (!empty($projects)): 
        ?>
            <div class="row g-4">
                <?php foreach ($projects as $item): ?>
                    <?php 
                    $project_img = null;
                    foreach (['image', 'img', 'thumbnail', 'photo', 'cover'] as $field) {
                        if (!empty($item[$field])) {
                            $val = $item[$field];
                            if (strpos($val, '/') !== false) {
                                $project_img = $val;
                            } elseif (file_exists("uploads/" . $val)) {
                                $project_img = "uploads/" . $val;
                            } elseif (file_exists("assets/img/" . $val)) {
                                $project_img = "assets/img/" . $val;
                            } else {
                                $project_img = $val;
                            }
                            break;
                        }
                    }
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="portfolio-card-item">
                            
                            <?php if (!empty($project_img)): ?>
                                <div class="portfolio-card-thumb">
                                    <a href="<?= $detail ?>.php?id=<?= $item['id'] ?>">
                                        <img src="<?= e($project_img) ?>" alt="<?= e($item['title'] ?? 'Project') ?>">
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="portfolio-card-body">
                                <div>
                                    <h3><?= e($item['title'] ?? '') ?></h3>
                                    <p><?= e($item['summary'] ?? '') ?></p>
                                </div>
                                <div>
                                    <a class="btn-view-project" href="<?= $detail ?>.php?id=<?= $item['id'] ?>">
                                        View details <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">No projects found at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Portfolio Banner Slider JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var slides = document.querySelectorAll('.portfolio-slide');
        var dots = document.querySelectorAll('.portfolio-dot');
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

        window.goToPortfolioSlide = function (index) {
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