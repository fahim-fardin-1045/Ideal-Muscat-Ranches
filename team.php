<?php 
require 'includes/app.php';

$kind = 'team';
$title = 'Team';
$detail = '';

require 'includes/header.php'; 
?>

<style>
    /* Team Banner Section */
    .team-banner {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 70px 0 80px 0;
        position: relative;
        text-align: center;
    }

    .team-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d, #f59e0b);
    }

    .team-badge {
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

    .team-title {
        font-size: 40px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 12px;
    }

    .team-subtitle {
        font-size: 16px;
        color: #cbd5e1;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Team Grid Section */
    .team-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 55vh;
    }

    .team-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-align: center;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .team-card-item:hover {
        transform: translateY(-7px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.1);
        border-color: #2a8f5d;
    }

    /* Member Photo Container */
    .team-card-thumb {
        width: 100%;
        height: 280px;
        overflow: hidden;
        background: #1e293b;
        position: relative;
    }

    .team-card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }

    .team-card-item:hover .team-card-thumb img {
        transform: scale(1.05);
    }

    
    .team-card-avatar-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0f172a;
        color: #f59e0b;
        font-size: 64px;
    }

    .team-card-body {
        padding: 24px 20px 28px 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .team-card-item h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
        line-height: 1.3;
    }

    .team-card-role {
        font-size: 13.5px;
        font-weight: 700;
        color: #2a8f5d;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 14px;
        display: block;
    }

    .team-card-item p {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    /* Social Icons Under Member Profile */
    .team-social-links {
        display: flex;
        justify-content: center;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid #f1f5f9;
    }

    .team-social-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .team-social-btn:hover {
        background-color: #2a8f5d;
        border-color: #2a8f5d;
        color: #ffffff;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .team-title {
            font-size: 30px;
        }
        .team-section {
            padding: 45px 0;
        }
        .team-card-thumb {
            height: 240px;
        }
    }
</style>

<!-- Banner Area -->
<section class="team-banner">
    <div class="container">
        <span class="team-badge">Our Professionals</span>
        <h1 class="team-title">Meet Our Team</h1>
        <p class="team-subtitle">
            Dedicated professionals committed to delivering excellence, innovation, and client success.
        </p>
    </div>
</section>

<!-- Team Members Grid -->
<section class="team-section">
    <div class="container">
        <?php 
        $members = entries($kind); 
        if (!empty($members)): 
        ?>
            <div class="row g-4">
                <?php foreach ($members as $member): ?>
                    <?php 
                    
                    $member_img = null;
                    foreach (['image', 'img', 'photo', 'avatar', 'thumbnail'] as $field) {
                        if (!empty($member[$field])) {
                            $val = $member[$field];
                            if (strpos($val, '/') !== false) {
                                $member_img = $val;
                            } elseif (file_exists("uploads/" . $val)) {
                                $member_img = "uploads/" . $val;
                            } elseif (file_exists("assets/img/" . $val)) {
                                $member_img = "assets/img/" . $val;
                            } else {
                                $member_img = $val;
                            }
                            break;
                        }
                    }

                    
                    $member_name = $member['name'] ?? $member['title'] ?? 'Team Member';
                    $member_role = $member['designation'] ?? $member['role'] ?? $member['position'] ?? 'Specialist';
                    $member_bio  = $member['summary'] ?? $member['bio'] ?? $member['about'] ?? '';
                    ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-card-item">
                            
                            
                            <div class="team-card-thumb">
                                <?php if (!empty($member_img)): ?>
                                    <img src="<?= e($member_img) ?>" alt="<?= e($member_name) ?>">
                                <?php else: ?>
                                    <div class="team-card-avatar-fallback">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="team-card-body">
                                <div>
                                    <h3><?= e($member_name) ?></h3>
                                    <span class="team-card-role"><?= e($member_role) ?></span>
                                    <?php if (!empty($member_bio)): ?>
                                        <p><?= e($member_bio) ?></p>
                                    <?php endif; ?>
                                </div>

                               
                                <div class="team-social-links">
                                    <a href="#" class="team-social-btn" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
                                    <a href="#" class="team-social-btn" title="Facebook"><i class="fa fa-facebook"></i></a>
                                    <a href="#" class="team-social-btn" title="Twitter"><i class="fa fa-twitter"></i></a>
                                    <a href="#" class="team-social-btn" title="Email"><i class="fa fa-envelope-o"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-muted">No team members found at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require 'includes/footer.php'; ?>