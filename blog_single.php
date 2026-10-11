<?php 
require 'includes/app.php';

$kind = 'blog';
$id = $_GET['id'] ?? null;
$all_posts = entries($kind);


$item = null;
if ($id && !empty($all_posts)) {
    foreach ($all_posts as $post) {
        if ($post['id'] == $id) {
            $item = $post;
            break;
        }
    }
}


if (!$item && !empty($all_posts)) {
    $item = $all_posts[0];
}

$title = !empty($item['title']) ? $item['title'] : 'Article Details';


$blog_img = null;
foreach (['image', 'img', 'photo', 'thumbnail', 'cover'] as $field) {
    if (!empty($item[$field])) {
        $img_val = $item[$field];
        if (strpos($img_val, '/') !== false) {
            $blog_img = $img_val;
        } elseif (file_exists("uploads/" . $img_val)) {
            $blog_img = "uploads/" . $img_val;
        } elseif (file_exists("assets/img/" . $img_val)) {
            $blog_img = "assets/img/" . $img_val;
        } else {
            $blog_img = $img_val;
        }
        break;
    }
}

$post_date = !empty($item['date']) ? date('M d, Y', strtotime($item['date'])) : date('M d, Y');
$post_category = $item['category'] ?? 'Insights';

require 'includes/header.php'; 
?>

<style>
    /* Single Blog Banner */
    .blog-detail-banner {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 70px 0 80px 0;
        position: relative;
    }

    .blog-detail-banner::after {
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

    .blog-detail-title {
        font-size: 38px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.3;
        margin: 0;
        max-width: 900px;
    }

    /* Content Area */
    .blog-detail-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 55vh;
    }

    /* Main Article Box */
    .blog-article-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 42px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 30px;
    }

    /* Featured Image */
    .blog-featured-media {
        width: 100%;
        max-height: 440px;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 28px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    }

    .blog-featured-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Meta Badges (Date & Category) */
    .blog-article-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 22px;
        font-size: 14px;
        color: #64748b;
    }

    .meta-category-badge {
        background: rgba(42, 143, 93, 0.12);
        color: #2a8f5d;
        border: 1px solid rgba(42, 143, 93, 0.25);
        padding: 4px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .meta-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }

    .meta-date i {
        color: #f59e0b;
    }

    /* Summary Callout */
    .blog-summary-highlight {
        background: #f0fdf4;
        border-left: 4px solid #2a8f5d;
        padding: 18px 22px;
        border-radius: 0 10px 10px 0;
        font-size: 16px;
        color: #1e3a29;
        font-weight: 500;
        margin-bottom: 28px;
        line-height: 1.65;
    }

    .blog-body-text {
        font-size: 16px;
        line-height: 1.9;
        color: #475569;
        margin-bottom: 35px;
        white-space: pre-line;
    }

    /* Article Footer (Navigation & Share) */
    .blog-article-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        padding-top: 24px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-back-blogs {
        border-radius: 50px;
        padding: 9px 24px;
        font-weight: 600;
        font-size: 14px;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #334155;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back-blogs:hover {
        background-color: #2a8f5d;
        border-color: #2a8f5d;
        color: #ffffff;
    }

    /* Sidebar Widgets */
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
        margin-bottom: 20px;
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

    /* Recent Posts List */
    .recent-posts-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .recent-post-item {
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .recent-post-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .recent-post-link {
        font-size: 14.5px;
        font-weight: 600;
        color: #1e293b;
        text-decoration: none;
        display: block;
        line-height: 1.45;
        margin-bottom: 5px;
        transition: color 0.2s ease;
    }

    .recent-post-link:hover,
    .recent-post-link.active {
        color: #2a8f5d;
    }

    .recent-post-date {
        font-size: 12px;
        color: #94a3b8;
        display: block;
    }

    /* Newsletter / Contact Promo */
    .sidebar-newsletter-card {
        background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
    }

    .sidebar-newsletter-card i {
        font-size: 34px;
        color: #f59e0b;
        margin-bottom: 16px;
    }

    .sidebar-newsletter-card h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .sidebar-newsletter-card p {
        font-size: 14px;
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 22px;
    }

    .btn-newsletter-contact {
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

    .btn-newsletter-contact:hover {
        background: #23764d;
        color: #ffffff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .blog-detail-title {
            font-size: 26px;
        }
        .blog-article-card {
            padding: 24px;
        }
    }
</style>

<!-- Banner Area -->
<section class="blog-detail-banner">
    <div class="container">
        <div class="banner-breadcrumb">
            <a href="index.php">Home</a> <span>/</span> 
            <a href="blog.php">News</a> <span>/</span> 
            <span>Article</span>
        </div>
        <h1 class="blog-detail-title"><?= e($item['title'] ?? 'Article Details') ?></h1>
    </div>
</section>

<!-- Content & Sidebar Area -->
<section class="blog-detail-section">
    <div class="container">
        <div class="row g-4">
            
            <!-- Left: Main Article Body -->
            <div class="col-lg-8">
                <article class="blog-article-card">
                    
                    <!-- Featured Article Image -->
                    <?php if (!empty($blog_img)): ?>
                        <div class="blog-featured-media">
                            <img src="<?= e($blog_img) ?>" alt="<?= e($item['title'] ?? 'Article Image') ?>">
                        </div>
                    <?php endif; ?>

                    <!-- Meta Tags -->
                    <div class="blog-article-meta">
                        <span class="meta-category-badge"><?= e($post_category) ?></span>
                        <span class="meta-date"><i class="fa fa-calendar"></i> <?= e($post_date) ?></span>
                    </div>

                    <!-- Article Headline Summary -->
                    <?php if (!empty($item['summary'])): ?>
                        <div class="blog-summary-highlight">
                            <?= e($item['summary']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Full Body Content -->
                    <div class="blog-body-text">
                        <?php if (!empty($item['content'])): ?>
                            <?= e($item['content']) ?>
                        <?php elseif (!empty($item['description'])): ?>
                            <?= e($item['description']) ?>
                        <?php else: ?>
                            <p>Stay tuned for more updates, industry analysis, and in-depth stories from our team. We continuously share insights to keep our clients and partners informed.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Article Footer Action -->
                    <div class="blog-article-footer">
                        <a href="blog.php" class="btn-back-blogs">
                            ← Back to all articles
                        </a>
                    </div>
                </article>
            </div>

            <!-- Right: Sidebar -->
            <div class="col-lg-4">
                
                <!-- Recent Articles List -->
                <?php if (!empty($all_posts)): ?>
                    <div class="sidebar-widget">
                        <h4 class="widget-title">Recent Articles</h4>
                        <ul class="recent-posts-list">
                            <?php foreach (array_slice($all_posts, 0, 5) as $p_item): ?>
                                <?php 
                                $is_active = ($item && $item['id'] == $p_item['id']) ? 'active' : ''; 
                                $r_date = !empty($p_item['date']) ? date('M d, Y', strtotime($p_item['date'])) : '';
                                ?>
                                <li class="recent-post-item">
                                    <a href="blog_single.php?id=<?= $p_item['id'] ?>" class="recent-post-link <?= $is_active ?>">
                                        <?= e($p_item['title'] ?? 'Untitled') ?>
                                    </a>
                                    <?php if ($r_date): ?>
                                        <span class="recent-post-date"><i class="fa fa-clock-o"></i> <?= e($r_date) ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Stay Informed CTA Box -->
                <div class="sidebar-newsletter-card">
                    <i class="fa fa-envelope-open-o"></i>
                    <h4>Stay Updated</h4>
                    <p>Have questions regarding our announcements or want more information?</p>
                    <a href="contact.php" class="btn-newsletter-contact">Contact Us</a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>