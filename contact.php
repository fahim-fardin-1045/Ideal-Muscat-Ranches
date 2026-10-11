<?php 
require 'includes/app.php';

$error = '';
$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (!empty($_POST['website'])) {
        $error = 'Submission rejected.';
    } elseif (strlen($name) < 2 || strlen($name) > 150 || strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($message) < 10 || strlen($message) > 10000) {
        $error = 'Enter your name, a valid email, and a message between 10 and 10,000 characters.';
    } elseif (time() - ($_SESSION['last_message'] ?? 0) < 60) {
        $error = 'Please wait one minute before sending another message.';
    } else {
        $q = db()->prepare('INSERT INTO messages(name,email,message) VALUES(?,?,?)');
        $q->execute([$name, $email, $message]);
        $_SESSION['last_message'] = time();
        $_SESSION['sent'] = true;
        header('Location: contact.php');
        exit;
    }
}

$sent = !empty($_SESSION['sent']);
unset($_SESSION['sent']);

$title = 'Contact';
require 'includes/header.php'; 
?>

<style>
    /* Premium Hero Banner */
    .contact-banner-pro {
        background: radial-gradient(circle at 80% 20%, rgba(42, 143, 93, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, #0b0f19 0%, #111827 50%, #1e293b 100%);
        color: #ffffff;
        padding: 85px 0 95px 0;
        position: relative;
        text-align: center;
    }

    .contact-banner-pro::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d 0%, #f59e0b 50%, #2a8f5d 100%);
    }

    .contact-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #f59e0b;
        text-transform: uppercase;
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.25);
        padding: 6px 18px;
        border-radius: 50px;
        margin-bottom: 18px;
    }

    .contact-title-pro {
        font-size: 44px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 14px;
        letter-spacing: -0.5px;
    }

    .contact-subtitle-pro {
        font-size: 16.5px;
        color: #94a3b8;
        max-width: 620px;
        margin: 0 auto;
        line-height: 1.65;
    }

    /* Main Content Section */
    .contact-section-wrap {
        background: #f8fafc;
        padding: 80px 0;
    }

    /* Left Info Card */
    .contact-details-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 40px 32px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .section-mini-heading {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .section-mini-desc {
        font-size: 14.5px;
        color: #64748b;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    .contact-meta-list {
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
    }

    .contact-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: transform 0.2s ease;
    }

    .contact-meta-item:last-child {
        border-bottom: none;
    }

    .contact-meta-item:hover {
        transform: translateX(4px);
    }

    .contact-icon-bubble {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 1px solid #bbf7d0;
        color: #2a8f5d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(42, 143, 93, 0.08);
    }

    .contact-meta-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
        display: block;
        margin-bottom: 4px;
    }

    .contact-meta-value {
        font-size: 15.5px;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
        line-height: 1.45;
        text-decoration: none;
    }

    a.contact-meta-value:hover {
        color: #2a8f5d;
    }

    /* Working Hours Alert Card */
    .hours-card {
        background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 14px;
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .hours-card i {
        font-size: 26px;
        color: #f59e0b;
    }

    .hours-card h5 {
        font-size: 14px;
        font-weight: 700;
        margin: 0 0 3px 0;
        color: #ffffff;
    }

    .hours-card p {
        font-size: 13px;
        color: #cbd5e1;
        margin: 0;
    }

    /* Right Form Card */
    .contact-form-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 44px 38px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        position: relative;
    }

    .form-floating-label {
        margin-bottom: 22px;
    }

    .form-floating-label label {
        display: block;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 8px;
        letter-spacing: 0.2px;
    }

    .form-input-pro {
        width: 100%;
        padding: 14px 18px;
        font-size: 15px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        background-color: #fcfdfe;
        color: #0f172a;
        transition: all 0.25s ease;
        outline: none;
    }

    .form-input-pro:focus {
        background-color: #ffffff;
        border-color: #2a8f5d;
        box-shadow: 0 0 0 4px rgba(42, 143, 93, 0.12);
    }

    textarea.form-input-pro {
        resize: vertical;
        min-height: 150px;
    }

    .form-security-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
        margin: 16px 0 28px 0;
    }

    .form-security-badge i {
        color: #2a8f5d;
        font-size: 15px;
    }

    /* Gradient Submit Button */
    .btn-submit-pro {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: linear-gradient(135deg, #2a8f5d 0%, #23764d 100%);
        color: #ffffff;
        font-size: 15.5px;
        font-weight: 700;
        padding: 15px 36px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 20px rgba(42, 143, 93, 0.3);
        width: 100%;
    }

    .btn-submit-pro:hover {
        background: linear-gradient(135deg, #23764d 0%, #1b5b3a 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(42, 143, 93, 0.4);
    }

    /* Alerts */
    .notice-status-success {
        background-color: #f0fdf4;
        border: 1px solid #86efac;
        color: #166534;
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 14.5px;
        font-weight: 600;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notice-status-error {
        background-color: #fef2f2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        padding: 16px 20px;
        border-radius: 12px;
        font-size: 14.5px;
        font-weight: 600;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .honeypot {
        display: none !important;
    }

    /* Interactive Embedded Map */
    .map-card-pro {
        margin-top: 55px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }

    .map-header-bar {
        padding: 18px 24px;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .map-header-bar span {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .map-header-bar a {
        font-size: 13px;
        font-weight: 700;
        color: #f59e0b;
        text-decoration: none;
    }

    .map-header-bar a:hover {
        text-decoration: underline;
    }

    .map-card-pro iframe {
        width: 100%;
        height: 420px;
        display: block;
        border: 0;
    }

    @media (max-width: 991px) {
        .contact-details-box {
            margin-bottom: 30px;
        }
    }

    @media (max-width: 768px) {
        .contact-title-pro {
            font-size: 32px;
        }
        .contact-form-box {
            padding: 26px 20px;
        }
        .map-card-pro iframe {
            height: 320px;
        }
    }
</style>

<!-- Hero Section -->
<section class="contact-banner-pro">
    <div class="container">
        <div class="contact-badge-pill">
            <i class="fa fa-envelope-open-o"></i> We’re Here to Help
        </div>
        <h1 class="contact-title-pro">Let’s Start a Conversation</h1>
        <p class="contact-subtitle-pro">
            Have questions about our operations or looking for bespoke partnerships? Get in touch with our team today.
        </p>
    </div>
</section>

<!-- Content & Form Section -->
<section class="contact-section-wrap">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            
            <!-- Left Info Column -->
            <div class="col-lg-5">
                <div class="contact-details-box">
                    <div>
                        <h2 class="section-mini-heading">Direct Contact</h2>
                        <p class="section-mini-desc">Feel free to reach us via our official office channels below.</p>
                        
                        <ul class="contact-meta-list">
                            <!-- Address -->
                            <?php if (!empty($s['address'])): ?>
                                <li class="contact-meta-item">
                                    <div class="contact-icon-bubble">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div>
                                        <span class="contact-meta-label">Head Office</span>
                                        <p class="contact-meta-value"><?= e($s['address']) ?></p>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!-- Phone -->
                            <?php if (!empty($s['phone'])): ?>
                                <li class="contact-meta-item">
                                    <div class="contact-icon-bubble">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div>
                                        <span class="contact-meta-label">Phone Call</span>
                                        <a href="tel:<?= e($s['phone']) ?>" class="contact-meta-value">
                                            <?= e($s['phone']) ?>
                                        </a>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <!-- Email -->
                            <?php if (!empty($s['email'])): ?>
                                <li class="contact-meta-item">
                                    <div class="contact-icon-bubble">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div>
                                        <span class="contact-meta-label">Support Email</span>
                                        <a href="mailto:<?= e($s['email']) ?>" class="contact-meta-value">
                                            <?= e($s['email']) ?>
                                        </a>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- Business Hours Snippet -->
                    <div class="hours-card">
                        <i class="fa fa-clock-o"></i>
                        <div>
                            <h5>Business Hours</h5>
                            <p>Mon - Fri: 09:00 AM – 06:00 PM (GMT+0)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Column -->
            <div class="col-lg-7">
                <div class="contact-form-box">
                    <h2 class="section-mini-heading">Send Us an Enquiry</h2>
                    <p class="section-mini-desc">Please complete the form below. We typically respond within 24 hours.</p>

                    <!-- Flash Notices -->
                    <?php if ($sent): ?>
                        <div class="notice-status-success" role="status">
                            <i class="fa fa-check-circle" style="font-size: 18px;"></i>
                            <span>Thank you! Your enquiry has been received successfully. We will contact you soon.</span>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="notice-status-error" role="alert">
                            <i class="fa fa-exclamation-triangle" style="font-size: 18px;"></i>
                            <span><?= e($error) ?></span>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="contact.php">
                        <?= token() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating-label">
                                    <label for="name">Full Name *</label>
                                    <input id="name" name="name" class="form-input-pro" maxlength="150" required value="<?= e($_POST['name'] ?? '') ?>" placeholder="e.g. John Doe">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating-label">
                                    <label for="email">Work Email *</label>
                                    <input id="email" name="email" type="email" class="form-input-pro" maxlength="254" required value="<?= e($_POST['email'] ?? '') ?>" placeholder="e.g. john@company.com">
                                </div>
                            </div>
                        </div>

                        <div class="form-floating-label">
                            <label for="message">Your Message *</label>
                            <textarea id="message" name="message" class="form-input-pro" minlength="10" maxlength="10000" required placeholder="Tell us about your requirements, project, or questions..."><?= e($_POST['message'] ?? '') ?></textarea>
                        </div>

                        <!-- Anti-spam Honeypot (Invisible) -->
                        <div class="honeypot" aria-hidden="true">
                            <label>Website<input name="website" tabindex="-1" autocomplete="off"></label>
                        </div>

                        <div class="form-security-badge">
                            <i class="fa fa-shield"></i>
                            <span>Your data is encrypted and handled in accordance with privacy laws.</span>
                        </div>

                        <button class="btn-submit-pro" type="submit">
                            <span>Send Message</span>
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Interactive Google Map Frame -->
        <div class="map-card-pro">
            <div class="map-header-bar">
                <span>
                    <i class="fa fa-map-pin" style="color: #2a8f5d;"></i> 
                    Amadora Office Location
                </span>
                <a href="https://maps.app.goo.gl/43GLuAvJFXG2j6XG9" target="_blank" rel="noopener">
                    Open in Google Maps <i class="fa fa-external-link"></i>
                </a>
            </div>
            <iframe 
                src="https://maps.google.com/maps?q=R.+da+Q.ta+da+Bolacha+21,+2700-690+Amadora,+Portugal&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>
</section>

<?php require 'includes/footer.php'; ?>