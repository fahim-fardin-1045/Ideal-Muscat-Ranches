<?php 
$s = settings();
$title = $title ?? 'Home'; 
$current_page = basename($_SERVER['PHP_SELF'], '.php');
if ($current_page === '' || $current_page === 'index') {
    $current_page = 'index';
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> | <?= e($s['company_name']) ?></title>
    <meta name="description" content="<?= e($s['intro']) ?>">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/company.css">
    
    <!-- Modern Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #334155;
        }

        /* 1. Default State: Black Background */
        .company-nav {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #111827; /* Normal Black */
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: background-color 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .nav-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 15px;
            transition: padding 0.3s ease;
        }

        /* Brand Logo */
        .brand {
            font-size: 20px;
            font-weight: 800;
            color: #f8fafc;
            text-decoration: none;
            letter-spacing: -0.5px;
            line-height: 1.15;
            display: inline-block;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .brand:hover {
            color: #ef4444 !important; /* Red hover */
            text-decoration: none;
            transform: scale(1.02);
        }

        .brand small {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #f59e0b;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: color 0.3s ease;
        }

        .brand:hover small {
            color: #ef4444 !important;
        }

        /* Navigation Links */
        #navigation {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        #navigation a {
            position: relative;
            font-size: 15px;
            font-weight: 600;
            color: #e2e8f0;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 50px;
            background: transparent;
            border: 1px solid transparent;
            transition: all 0.25s ease;
        }

        #navigation a:hover {
            color: #f59e0b;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(245, 158, 11, 0.3);
        }

        #navigation a.active {
            color: #ffffff !important;
            background: #f59e0b !important;
            border-color: #f59e0b !important;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
        }

        /* 2. Scrolled State: Green Background */
        .company-nav.scrolled {
            background-color: #2a8f5d !important; /* Scrolled Green */
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        }

        .company-nav.scrolled .nav-wrap {
            padding: 10px 15px;
        }

        .company-nav.scrolled .brand {
            color: #ffffff;
        }

        .company-nav.scrolled .brand:hover {
            color: #ef4444 !important;
        }

        .company-nav.scrolled .brand:hover small {
            color: #ef4444 !important;
        }

        .company-nav.scrolled #navigation a {
            color: #f0fdf4;
        }

        .company-nav.scrolled #navigation a:hover {
            color: #ffffff;
            background: rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .company-nav.scrolled #navigation a.active {
            color: #ffffff !important;
            background: #1e6642 !important; /* Darker green active highlight */
            border-color: #1e6642 !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
        }

        /* Mobile Menu Toggle Button */
        .menu-toggle {
            display: none;
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 8px;
            padding: 7px 16px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            cursor: pointer;
        }

        .company-nav.scrolled .menu-toggle {
            background: #23764d;
            border-color: #1e6642;
        }

        @media (max-width: 991px) {
            .menu-toggle {
                display: block;
            }

            #navigation {
                display: none;
                flex-direction: column;
                align-items: stretch;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: #111827;
                padding: 16px 20px;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.35);
                border-top: 1px solid #1f2937;
                gap: 8px;
            }

            .company-nav.scrolled #navigation {
                background: #2a8f5d;
                border-top: 1px solid rgba(255, 255, 255, 0.15);
            }

            #navigation.active {
                display: flex;
            }

            #navigation a {
                border-radius: 8px;
                padding: 11px 16px;
            }
        }
    </style>
</head>

<body>
    <header class="company-nav" id="mainHeader">
        <div class="container nav-wrap">
            <a class="brand" href="index.php">
                <?= !empty($s['company_name']) ? e($s['company_name']) : 'IDEAL MUSCAT RANCHES, UNIPESSOAL LDA' ?> <small>RANCHES</small>
            </a>
            <button class="menu-toggle" aria-expanded="false" aria-controls="navigation">Menu</button>
            <nav id="navigation">
                <?php 
                $menu_list = ['index' => 'Home', 'about' => 'About', 'service' => 'Services', 'portfolio' => 'Projects', 'team' => 'Team', 'blog' => 'News', 'faq' => 'FAQ', 'contact' => 'Contact'];
                foreach ($menu_list as $url => $label): 
                    $is_active = ($current_page === $url) ? 'active' : '';
                ?>
                    <a class="<?= $is_active ?>" href="<?= $url ?>.php"><?= e($label) ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggleBtn = document.querySelector('.menu-toggle');
            var nav = document.getElementById('navigation');
            var header = document.getElementById('mainHeader');

            // Mobile menu toggle
            if (toggleBtn && nav) {
                toggleBtn.addEventListener('click', function () {
                    var expanded = this.getAttribute('aria-expanded') === 'true' || false;
                    this.setAttribute('aria-expanded', !expanded);
                    nav.classList.toggle('active');
                });
            }

            // Scroll down background color change
            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        });
    </script>
    <main>