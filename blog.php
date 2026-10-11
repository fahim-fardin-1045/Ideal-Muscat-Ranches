<?php 
require 'includes/app.php';

$kind = 'blog';
$title = 'News';
$detail = 'blog_single';

require 'includes/header.php'; 
?>

<style>
    /* Blog Banner Section */
    .blog-banner {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 70px 0 80px 0;
        position: relative;
        text-align: center;
    }

    .blog-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d, #f59e0b);
    }

    .blog-badge {
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

    .blog-title {
        font-size: 40px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 12px;
    }

    .blog-subtitle {
        font-size: 16px;
        color: #cbd5e1;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Blog Grid Section */
    .blog-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 55vh;
    }

    .blog-card-item {
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
        position: relative;
    }

    .blog-card-item:hover {
        transform: translateY(-7px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.1);
        border-color: #2a8f5d;
    }

    /* Thumbnail Container */
    .blog-card-thumb {
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: #0f172a;
        position: relative;
    }

    .blog-card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }

    .blog-card-item:hover .blog-card-thumb img {
        transform: scale(1.06);
    }

    /* Date / Category Tag Over Thumbnail */
    .blog-card-tag {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #2a8f5d;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .blog-card-body {
        padding: 24px 24px 28px 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .blog-meta {
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .blog-meta i {
        color: #f59e0b;
    }

    .blog-card-item h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .blog-card-item h3 a {
        color: #0f172a;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .blog-card-item h3 a:hover {
        color: #2a8f5d;
    }

    .blog-card-item p {
        font-size: 14.5px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 22px;
    }

    /* Read More Link */
    .btn-read-more {
        font-size: 14px;
        font-weight: 700;
        color: #f59e0b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-read-more:hover {
        color: #d97706;
        transform: translateX(4px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .blog-title {
            font-size: 30px;
        }
        .blog-section {
            padding: 45px 0;
        }
    }
</style>

<!-- Banner Area -->
<section class="blog-banner">
    <div class="container">
        <span class="blog-badge">Latest Insights</span>
        <h1 class="blog-title">Company News & Articles</h1>
        <p class="blog-subtitle">
            Stay updated with our latest announcements, market insights, and industry updates.
        </p>
    </div>
</section>

<!-- Blog Grid -->
<section class="blog-section">
    <div class="container">
        <?php 
        $posts = entries($kind); 
        if (!empty($posts)): 
        ?>
            <div class="row g-4">
                <?php foreach ($posts as $item): ?>
                    <?php 
                   
                    $post_img = null;
                    foreach (['image', 'img', 'thumbnail', 'photo', 'cover'] as $field) {
                        if (!empty($item[$field])) {
                            $val = $item[$field];
                            if (strpos($val, '/') !== false) {
                                $post_img = $val;
                            } elseif (file_exists("uploads/" . $val)) {
                                $post_img = "uploads/" . $val;
                            } elseif (file_exists("assets/img/" . $val)) {
                                $post_img = "assets/img/" . $val;
                            } else {
                                $post_img = $val;
                            }
                            break;
                        }
                    }

                  
                    $post_date = !empty($item['date']) ? date('M d, Y', strtotime($item['date'])) : date('M d, Y');
                    $post_category = $item['category'] ?? 'News';
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card-item">
                            
                            <!-- ব্লগ থাম্বনেইল -->
                            <?php if (!empty($post_img)): ?>
                                <div class="blog-card-thumb">
                                    <a href="<?= $detail ?>.php?id=<?= $item['id'] ?>">
                                        <img src="<?= e($post_img) ?>" alt="<?= e($item['title'] ?? 'News') ?>">
                                    </a>
                                    <span class="blog-card-tag"><?= e($post_category) ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="blog-card-body">
                                <div>
                                    <div class="blog-meta">
                                        <span><i class="fa fa-calendar"></i> <?= e($post_date) ?></span>
                                    </div>
                                    <h3>
                                        <a href="<?= $detail ?>.php?id=<?= $item['id'] ?>">
                                            <?= e($item['title'] ?? '') ?>
                                        </a>
                                    </h3>
                                    <p><?= e($item['summary'] ?? '') ?></p>
                                </div>
                                <div>
                                    <a class="btn-read-more" href="<?= $detail ?>.php?id=<?= $item['id'] ?>">
                                        Read article <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">No news or articles published yet.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require 'includes/footer.php'; ?>