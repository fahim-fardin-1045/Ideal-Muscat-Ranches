</main>

<!-- Modern Custom Wave Footer -->
<footer class="company-footer">
    <!-- Top Wave Curve -->
    <div class="footer-wave-shape">
        <svg viewBox="0 0 1440 120" fill="none" preserveAspectRatio="none">
            <path d="M0,40 C320,120 420,0 720,40 C1020,80 1120,10 1440,50 L1440,120 L0,120 Z" fill="#2d3748"></path>
        </svg>
    </div>

    <div class="footer-content-area">
        <div class="container text-center">
            
            <!-- Company Brand Name -->
            <h3 class="footer-brand-title">
                <?= e($s['company_name']) ?>
            </h3>

            <!-- Address & NIPC -->
            <div class="footer-info-wrap">
                <?php if (!empty($s['address'])): ?>
                    <p class="footer-info-item">
                        <i class="fa fa-map-marker"></i> <?= e($s['address']) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($s['nipc'])): ?>
                    <p class="footer-info-item">
                        <span class="nipc-badge">NIPC</span> <?= e($s['nipc']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Divider Line -->
            <div class="footer-divider"></div>

            <!-- Copyright & Credit Links -->
            <div class="footer-bottom-text">
                <p class="mb-1">
                    &copy; <?= date('Y') ?> <?= e($s['company_name']) ?>. All Rights Reserved.
                </p>
                
            </div>

        </div>
    </div>
</footer>

<style>
    /* Footer Styling */
    .company-footer {
        background-color: transparent;
        position: relative;
        margin-top: 60px;
        font-family: inherit;
    }

    .footer-wave-shape {
        line-height: 0;
        width: 100%;
        overflow: hidden;
    }

    .footer-wave-shape svg {
        width: 100%;
        height: 60px;
        display: block;
    }

    .footer-content-area {
        background-color: #2a8f5d;
        padding: 30px 0 35px 0;
        color: #1c4479;
    }

    /* Company Name Typography */
    .footer-brand-title {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #f6ad55; /* Warm golden-orange look */
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    /* Info Section (Address & NIPC) */
    .footer-info-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .footer-info-item {
        font-size: 15px;
        color: #cbd5e0;
        margin-bottom: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .footer-info-item i {
        color: #f6ad55;
    }

    .nipc-badge {
        background: rgba(229, 197, 159, 0.15);
        color: #f6ad55;
        border: 1px solid rgba(246, 173, 85, 0.3);
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* Divider */
    .footer-divider {
        width: 100%;
        max-width: 450px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        margin: 0 auto 20px auto;
    }

    /* Copyright & Credits */
    .footer-bottom-text {
        font-size: 14px;
        color: #a0aec0;
    }

    .footer-credit {
        font-size: 13px;
        color: #718096;
    }

    .footer-credit a {
        color: #63b3ed;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-credit a:hover {
        color: #90cdf4;
        text-decoration: underline;
    }
</style>

<script src="assets/js/company.js"></script>
</body>

</html>