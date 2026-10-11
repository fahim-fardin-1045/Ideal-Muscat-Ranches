<?php 
require 'includes/app.php';

$kind = 'faq';
$title = 'Frequently Asked Questions';
$detail = '';

require 'includes/header.php'; 
?>

<style>
    /* FAQ Banner Section */
    .faq-banner {
        background: linear-gradient(135deg, #111827 0%, #1e293b 60%, #0f172a 100%);
        color: #ffffff;
        padding: 70px 0 80px 0;
        position: relative;
        text-align: center;
    }

    .faq-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a8f5d, #f59e0b);
    }

    .faq-badge {
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

    .faq-title {
        font-size: 40px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 12px;
    }

    .faq-subtitle {
        font-size: 16px;
        color: #cbd5e1;
        max-width: 620px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* FAQ Content Section */
    .faq-section {
        background-color: #f8fafc;
        padding: 70px 0;
        min-height: 55vh;
    }

    /* Accordion Item Styling */
    .faq-accordion-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        margin-bottom: 16px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.03);
        transition: all 0.25s ease;
    }

    .faq-accordion-item:hover {
        border-color: #cbd5e1;
    }

    .faq-accordion-item.active {
        border-color: #2a8f5d;
        box-shadow: 0 6px 22px rgba(42, 143, 93, 0.08);
    }

    .faq-question-btn {
        width: 100%;
        padding: 20px 24px;
        background: none;
        border: none;
        text-align: left;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        cursor: pointer;
        outline: none;
    }

    .faq-question-text {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        line-height: 1.4;
        transition: color 0.2s ease;
    }

    .faq-accordion-item.active .faq-question-text {
        color: #2a8f5d;
    }

    .faq-toggle-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #f1f5f9;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .faq-accordion-item.active .faq-toggle-icon {
        background-color: #2a8f5d;
        color: #ffffff;
        transform: rotate(180deg);
    }

    .faq-answer-collapse {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s cubic-bezier(0, 1, 0, 1);
    }

    .faq-accordion-item.active .faq-answer-collapse {
        max-height: 1000px;
        transition: max-height 0.45s ease-in-out;
    }

    .faq-answer-inner {
        padding: 0 24px 24px 24px;
        font-size: 15.5px;
        line-height: 1.8;
        color: #475569;
        border-top: 1px dashed #f1f5f9;
        margin-top: 5px;
        padding-top: 16px;
    }

    /* Help & Support CTA Box */
    .faq-help-box {
        background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 16px;
        padding: 34px 26px;
        text-align: center;
        position: sticky;
        top: 100px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.1);
    }

    .faq-help-box i {
        font-size: 38px;
        color: #f59e0b;
        margin-bottom: 16px;
    }

    .faq-help-box h4 {
        font-size: 21px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .faq-help-box p {
        font-size: 14.5px;
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .btn-faq-contact {
        display: inline-block;
        background: #2a8f5d;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(42, 143, 93, 0.4);
    }

    .btn-faq-contact:hover {
        background: #23764d;
        color: #ffffff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .faq-title {
            font-size: 30px;
        }
        .faq-question-text {
            font-size: 15.5px;
        }
    }
</style>

<!-- Banner Area -->
<section class="faq-banner">
    <div class="container">
        <span class="faq-badge">Help Center</span>
        <h1 class="faq-title">Frequently Asked Questions</h1>
        <p class="faq-subtitle">
            Find answers to common queries regarding our services, procedures, and support.
        </p>
    </div>
</section>

<!-- FAQ Accordion Section -->
<section class="faq-section">
    <div class="container">
        <div class="row g-4">
            
            <!-- Left: FAQ Accordion List -->
            <div class="col-lg-8">
                <?php 
                $faqs = entries($kind); 
                if (!empty($faqs)): 
                ?>
                    <div class="faq-accordion-container">
                        <?php foreach ($faqs as $index => $item): ?>
                            <?php 
                           
                            $question = $item['title'] ?? $item['question'] ?? 'Question';
                            $answer = $item['content'] ?? $item['answer'] ?? $item['summary'] ?? $item['description'] ?? '';
                            
                            $is_first = ($index === 0) ? 'active' : '';
                            ?>
                            <div class="faq-accordion-item <?= $is_first ?>">
                                <button type="button" class="faq-question-btn" onclick="toggleFaq(this)">
                                    <span class="faq-question-text"><?= e($question) ?></span>
                                    <span class="faq-toggle-icon">
                                        <i class="fa fa-chevron-down"></i>
                                    </span>
                                </button>
                                <div class="faq-answer-collapse">
                                    <div class="faq-answer-inner">
                                        <?= nl2br(e($answer)) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-white p-5 rounded-4 text-center border">
                        <p class="text-muted mb-0">No questions found at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Support / Contact Widget -->
            <div class="col-lg-4">
                <div class="faq-help-box">
                    <i class="fa fa-question-circle-o"></i>
                    <h4>Still Have Questions?</h4>
                    <p>Can't find the answer you're looking for? Reach out to our dedicated team anytime.</p>
                    <a href="contact.php" class="btn-faq-contact">Contact Support</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Accordion Toggle JavaScript -->
<script>
    function toggleFaq(button) {
        var currentItem = button.parentElement;
        var allItems = document.querySelectorAll('.faq-accordion-item');

        
        allItems.forEach(function(item) {
            if (item !== currentItem) {
                item.classList.remove('active');
            }
        });

       
        currentItem.classList.toggle('active');
    }
</script>

<?php require 'includes/footer.php'; ?>