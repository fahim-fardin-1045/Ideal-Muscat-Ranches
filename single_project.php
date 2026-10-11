<?php 
require 'includes/app.php';

$kind = 'project';
$id = $_GET['id'] ?? null;
$all_projects = entries($kind);


$item = null;
if ($id && !empty($all_projects)) {
    foreach ($all_projects as $proj) {
        if ($proj['id'] == $id) {
            $item = $proj;
            break;
        }
    }
}

if (!$item && !empty($all_projects)) {
    $item = $all_projects[0];
}

$title = !empty($item['title']) ? $item['title'] : 'Project Details';


$project_img = null;
foreach (['image', 'img', 'photo', 'thumbnail', 'cover'] as $field) {
    if (!empty($item[$field])) {
        $img_val = $item[$field];
        if (strpos($img_val, '/') !== false) {
            $project_img = $img_val;
        } elseif (file_exists("uploads/" . $img_val)) {
            $project_img = "uploads/" . $img_val;
        } elseif (file_exists("assets/img/" . $img_val)) {
            $project_img = "assets/img/" . $img_val;
        } else {
            $project_img = $img_val;
        }
        break;
    }
}


$client_name = $item['client'] ?? 'Private Client';
$project_category = $item['category'] ?? 'Development';
$project_date = !empty($item['date']) ? date('M Y', strtotime($item['date'])) : date('M Y');

require 'includes/header.php'; 
?>

<style>
    /* Single Project Banner */
    .project-detail-banner {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 70px 0 80px 0;
        position: relative;
    }

    .project-detail-banner::after {
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

    .project-detail-title {
        font-size: 38px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.3;
        margin: 0;
        max-width: 900px;
    }

    /* Content Area */
    .project-detail-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 55vh;
    }

    /* Main Project Box */
    .project-article-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 42px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 30px;
    }

    /* Featured Project Image */
    .project-featured-media {
        width: 100%;
        max-height: 460px;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 28px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    }

    .project-featured-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Summary Callout */
    .project-summary-highlight {
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

    .project-body-text {
        font-size: 16px;
        line-height: 1.9;
        color: #475569;
        margin-bottom: 35px;
        white-space: pre-line;
    }

    /* Back Button */
    .btn-back-projects {
        border-radius: 50px;
        padding: 9px 24px;
        font-weight: 600;
        font-size: 14px;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #334155;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s ease;
    }

    .btn-back-projects:hover {
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

    /* Project Meta List */
    .project-meta-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .project-meta-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
        font-size: 14.5px;
    }

    .project-meta-item:last-child {
        border-bottom: none;
    }

    .project-meta-label {
        color: #64748b;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .project-meta-label i {
        color: #2a8f5d;
    }

    .project-meta-value {
        color: #0f172a;
        font-weight: 700;
    }

    /* Other Projects Nav */
    .other-projects-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .other-projects-list li {
        margin-bottom: 10px;
    }

    .other-projects-list li a {
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

    .other-projects-list li a:hover,
    .other-projects-list li a.active {
        background: #2a8f5d;
        color: #ffffff;
        border-color: #2a8f5d;
        padding-left: 20px;
    }

    .other-projects-list li a i {
        font-size: 12px;
        opacity: 0.7;
    }

    /* CTA Card */
    .sidebar-cta-card {
        background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
    }

    .sidebar-cta-card i {
        font-size: 34px;
        color: #f59e0b;
        margin-bottom: 16px;
    }

    .sidebar-cta-card h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .sidebar-cta-card p {
        font-size: 14px;
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 22px;
    }

    .btn-project-contact {
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

    .btn-project-contact:hover {
        background: #23764d;
        color: #ffffff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .project-detail-title {
            font-size: 28px;
        }
        .project-article-card {
            padding: 24px;
        }
    }
</style>

<!-- Banner Area -->
<section class="project-detail-banner">
    <div class="container">
        <div class="banner-breadcrumb">
            <a href="index.php">Home</a> <span>/</span> 
            <a href="portfolio.php">Projects</a> <span>/</span> 
            <span>Details</span>
        </div>
        <h1 class="project-detail-title"><?= e($item['title'] ?? 'Project Details') ?></h1>
    </div>
</section>

<!-- Content Area -->
<section class="project-detail-section">
    <div class="container">
        <div class="row g-4">
            
            <!-- Left: Main Project Body -->
            <div class="col-lg-8">
                <article class="project-article-card">
                    
                    <!-- Featured Project Media -->
                    <?php if (!empty($project_img)): ?>
                        <div class="project-featured-media">
                            <img src="<?= e($project_img) ?>" alt="<?= e($item['title'] ?? 'Project Image') ?>">
                        </div>
                    <?php endif; ?>

                    <!-- Summary Highlight -->
                    <?php if (!empty($item['summary'])): ?>
                        <div class="project-summary-highlight">
                            <?= e($item['summary']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Body Content -->
                    <div class="project-body-text">
                        <?php if (!empty($item['content'])): ?>
                            <?= e($item['content']) ?>
                        <?php elseif (!empty($item['description'])): ?>
                            <?= e($item['description']) ?>
                        <?php else: ?>
                            <p>This project reflects our dedication to superior execution, attention to detail, and customer-first delivery. Our comprehensive approach ensures seamless implementation from concept to completion.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Back Action -->
                    <div>
                        <a href="portfolio.php" class="btn-back-projects">
                            ← Back to all projects
                        </a>
                    </div>
                </article>
            </div>

            <!-- Right: Sidebar -->
            <div class="col-lg-4">
                
                <!-- Project Overview Widget -->
                <div class="sidebar-widget">
                    <h4 class="widget-title">Project Info</h4>
                    <ul class="project-meta-list">
                        <li class="project-meta-item">
                            <span class="project-meta-label"><i class="fa fa-folder-open-o"></i> Category</span>
                            <span class="project-meta-value"><?= e($project_category) ?></span>
                        </li>
                        <li class="project-meta-item">
                            <span class="project-meta-label"><i class="fa fa-user-o"></i> Client</span>
                            <span class="project-meta-value"><?= e($client_name) ?></span>
                        </li>
                        <li class="project-meta-item">
                            <span class="project-meta-label"><i class="fa fa-calendar-check-o"></i> Completed</span>
                            <span class="project-meta-value"><?= e($project_date) ?></span>
                        </li>
                    </ul>
                </div>

                <!-- Other Projects Navigation -->
                <?php if (!empty($all_projects)): ?>
                    <div class="sidebar-widget">
                        <h4 class="widget-title">Other Projects</h4>
                        <ul class="other-projects-list">
                            <?php foreach ($all_projects as $p_item): ?>
                                <?php $is_active = ($item && $item['id'] == $p_item['id']) ? 'active' : ''; ?>
                                <li>
                                    <a href="single_project.php?id=<?= $p_item['id'] ?>" class="<?= $is_active ?>">
                                        <span><?= e($p_item['title'] ?? 'Untitled') ?></span>
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Start a Project CTA -->
                <div class="sidebar-cta-card">
                    <i class="fa fa-lightbulb-o"></i>
                    <h4>Have a Similar Project?</h4>
                    <p>Discuss your goals and requirements with our specialists to get started.</p>
                    <a href="contact.php" class="btn-project-contact">Start a Project</a>
                </div>

            </div>

        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>