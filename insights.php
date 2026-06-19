<!DOCTYPE html>
<html lang="en-AU">

<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4JD4ZCN0G8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-4JD4ZCN0G8');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story & Insights | Digital ABCs</title>
    <meta name="description" content="The Digital ABCs story hub: founder-led product notes, trustworthy AI thinking, Linguistic Decoder updates, governance, and practical lessons from building in public.">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
    <meta name="author" content="Digital ABCs">
    <link rel="canonical" href="https://digitalabcs.com.au/insights.php">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://digitalabcs.com.au/insights.php">
    <meta property="og:title" content="Story & Insights - Digital ABCs">
    <meta property="og:description" content="Founder-led notes on trustworthy AI, product decisions, governance, and building Digital ABCs in public.">
    <meta property="og:image" content="https://digitalabcs.com.au/assets/og-about.png">
    <meta property="og:locale" content="en_AU">
    <meta property="og:site_name" content="Digital ABCs">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Story & Insights - Digital ABCs">
    <meta name="twitter:description" content="The main story hub for Digital ABCs product thinking, trustworthy AI, and founder-led build notes.">
    <meta name="twitter:image" content="https://digitalabcs.com.au/assets/og-about.png">
    <link rel="icon" href="assets/brand/favicon-abc-tm.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="assets/brand/favicon-abc-tm.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        .dynamic-reports-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .blog-post-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .blog-post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .blog-card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .blog-card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .blog-post-card h3 {
            color: var(--color-navy, #1E3A8A);
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.25rem;
        }

        .post-meta {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 15px;
            font-family: 'Roboto Mono', monospace;
        }

        .blog-post-card p {
            color: #333;
            line-height: 1.5;
            flex-grow: 1;
        }

        .section-divider {
            border: 0;
            border-top: 2px solid #eee;
            margin: 40px 0;
        }

        .story-intro {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border: 1px solid rgba(91, 33, 182, 0.16);
            border-radius: 20px;
            background:
                radial-gradient(circle at top right, rgba(50, 245, 231, 0.12), transparent 34%),
                #FFFFFF;
            box-shadow: 0 18px 38px -32px rgba(15, 23, 42, 0.22);
        }

        .story-intro p {
            color: #374151;
            line-height: 1.75;
            max-width: 880px;
        }

        .story-pillars {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin: 2rem 0 3rem;
        }

        .story-map {
            margin: 0 0 3rem;
            padding: 1.4rem;
            border: 1px solid rgba(91, 33, 182, 0.16);
            border-radius: 24px;
            background:
                radial-gradient(circle at 20% 20%, rgba(45, 212, 191, 0.14), transparent 28%),
                radial-gradient(circle at 80% 12%, rgba(212, 175, 55, 0.14), transparent 30%),
                #FFFFFF;
            box-shadow: 0 22px 54px -42px rgba(15, 23, 42, 0.34);
        }

        .story-map-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr 1fr;
            gap: 1rem;
            align-items: stretch;
        }

        .story-map-panel {
            display: grid;
            align-content: center;
            min-height: 180px;
            padding: 1.15rem;
            border: 1px solid #E5E7EB;
            border-radius: 18px;
            background: #F8FAFC;
        }

        .story-map-panel.primary {
            color: #FFFFFF;
            background: linear-gradient(135deg, #0F172A, #1E3A8A 58%, #5B21B6);
        }

        .story-map-panel h3 {
            margin: 0 0 0.65rem;
        }

        .story-map-panel.primary h3,
        .story-map-panel.primary p {
            color: #FFFFFF;
        }

        .story-map-panel p {
            margin: 0;
            color: #4B5563;
            line-height: 1.65;
        }

        .story-pillar {
            padding: 1.25rem;
            border-radius: 18px;
            border: 1px solid #E5E7EB;
            background: #FFFFFF;
            box-shadow: 0 16px 34px -30px rgba(15, 23, 42, 0.3);
        }

        .story-pillar h3 {
            margin: 0 0 0.55rem;
            color: #0F172A;
            font-size: 1.05rem;
        }

        .story-pillar p {
            margin: 0;
            color: #4B5563;
            line-height: 1.65;
            font-size: 0.95rem;
        }

        @media (min-width: 768px) {
            .dynamic-reports-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 960px) {
            .story-pillars,
            .story-map-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .story-map-panel.primary {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 640px) {
            .story-pillars,
            .story-map-grid {
                grid-template-columns: 1fr;
            }
        }

        .blog-post-card {
            position: relative;
        }

        .blog-post-card h3 a {
            color: var(--color-navy, #1E3A8A);
            text-decoration: none;
        }

        .stretched-link::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            content: "";
        }
    </style>
</head>

<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <header class="site-header">
        <div class="container">
            <a href="index.html" class="logo" aria-label="Digital ABCs Home">
                <img src="assets/brand/primary-logo-fullcolour-horizontal-tm.svg" alt="Digital ABCs Logo" class="logo-img">
            </a>
            <nav class="main-nav" aria-label="Main navigation">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="apps/decoder.html">Linguistic Decoder</a></li>
                    <li><a href="apps.html">Products</a></li>
                    <li><a href="insights.php">Insights</a></li>
                    <li><a href="legal.html">Trust</a></li>
                    <li><a href="support.html">Support</a></li>
                    <li><a href="https://apps.apple.com/au/app/linguistic-decoder/id6758027843">Try it free</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main id="main-content">
        <section class="hero">
            <div class="container">
                <h1>Story & Insights</h1>
                <p class="subtitle">The core Digital ABCs story page: product thinking, trustworthy AI, governance, launch lessons, and building in public.</p>
            </div>
        </section>

        <section class="insights-grid section-padding">
            <div class="container">
                <div class="story-intro">
                    <h2>The story is part of the product.</h2>
                    <p>
                        This page will become the main content home for Digital ABCs: the place where product decisions, trust choices,
                        AI governance, launch notes, and practical lessons are explained in plain language. The goal is to help people
                        understand not only what Digital ABCs builds, but why each product is released carefully.
                    </p>
                </div>

                <div class="story-pillars" aria-label="Digital ABCs story themes">
                    <article class="story-pillar">
                        <h3>Trustworthy AI</h3>
                        <p>How Digital ABCs uses AI without pretending it can replace judgement, context, or qualified support.</p>
                    </article>
                    <article class="story-pillar">
                        <h3>Product Decisions</h3>
                        <p>Why Linguistic Decoder is first, why Contract Compass waits, and why some ideas need more trust before launch.</p>
                    </article>
                    <article class="story-pillar">
                        <h3>Governance</h3>
                        <p>Plain-English notes on privacy, safety, redaction, model choice, release readiness, and accountability.</p>
                    </article>
                    <article class="story-pillar">
                        <h3>Build Notes</h3>
                        <p>Founder-led lessons from turning constraints, research, and real user needs into practical tools.</p>
                    </article>
                </div>

                <div class="story-map" aria-label="Digital ABCs story map diagram">
                    <div class="story-map-grid">
                        <article class="story-map-panel">
                            <h3>Problem signals</h3>
                            <p>Confusing messages, fragile trust, AI uncertainty, privacy concern, and real-world constraints.</p>
                        </article>
                        <article class="story-map-panel primary">
                            <h3>Digital ABCs story spine</h3>
                            <p>What we are building, why we are building it, what we refuse to overclaim, and how each release earns trust.</p>
                        </article>
                        <article class="story-map-panel">
                            <h3>Public proof</h3>
                            <p>Release notes, governance explainers, product decisions, user education, and lessons from the build.</p>
                        </article>
                    </div>
                </div>

                <h2>Latest Story Notes</h2>
                <p>Updates and reports from the Digital ABCs build journey. Newest first.</p>

                <div class="dynamic-reports-grid">
                    <?php
                    $insightsDir = __DIR__ . '/insights';
                    $webPath = './insights';

                    $files = glob($insightsDir . '/*_article.html');

                    if ($files) {
                        rsort($files);

                        foreach ($files as $file) {
                            $doc = new DOMDocument();
                            libxml_use_internal_errors(true);
                            $doc->loadHTMLFile($file);
                            libxml_clear_errors();

                            $xpath = new DOMXPath($doc);

                            $title = 'Weekly Business Insight';
                            $h2Nodes = $doc->getElementsByTagName('h2');
                            if ($h2Nodes->length > 0) {
                                $title = $h2Nodes->item(0)->textContent;
                            }

                            $summary = 'Latest updates on Australian business compliance and automation.';
                            $pNodes = $doc->getElementsByTagName('p');
                            if ($pNodes->length > 0) {
                                $fullText = $pNodes->item(0)->textContent;
                                if (strlen($fullText) > 180) {
                                    $summary = substr($fullText, 0, 180) . '...';
                                } else {
                                    $summary = $fullText;
                                }
                            }

                            $baseName = basename($file);
                            $imageName = str_replace('_article.html', '_thumbnail.png', $baseName);

                            if (file_exists($insightsDir . '/' . $imageName)) {
                                $img_src = $webPath . '/' . $imageName;
                            }
                            elseif (file_exists($insightsDir . '/' . str_replace('.png', '.jpg', $imageName))) {
                                $img_src = $webPath . '/' . str_replace('.png', '.jpg', $imageName);
                            }
                            else {
                                $img_src = 'assets/insights/default.jpg';
                            }

                            $datePart = substr($baseName, 0, 8);
                            $published_date = date("F j, Y", strtotime($datePart));

                            $link_url = 'article.php?id=' . urlencode($baseName);

                            echo '<article class="blog-post-card">';

                            echo '<img src="' . htmlspecialchars($img_src) . '" alt="Illustration for ' . htmlspecialchars($title) . '" class="blog-card-image">';

                            echo '<div class="blog-card-content">';
                            echo '<h3><a href="' . $link_url . '" class="stretched-link">' . htmlspecialchars($title) . '</a></h3>';
                            echo '<p class="post-meta">' . htmlspecialchars($published_date) . '</p>';
                            echo '<p>' . htmlspecialchars($summary) . '</p>';
                            echo '</div>';

                            echo '</article>';
                        }
                    } else {
                        echo '<p>No weekly reports available at the moment. Please check back soon.</p>';
                    }
                    ?>
                </div>

                <hr class="section-divider">
                <h2>Coming Content Streams</h2>
                <p>Future articles will focus on Linguistic Decoder, trustworthy AI, product governance, and the practical story behind Digital ABCs.</p>
                <p style="color: #4B5563; font-style: italic; margin-top: 1rem;">Longer founder notes, release essays, and product explainers will be added here as the core story library grows.</p>
            </div>
        </section>
    </main>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <img src="assets/brand/primary-logo-white-tm.png" alt="Digital ABCs" class="footer-logo">
                    <p>Trustworthy AI tools for real-life clarity, built in New South Wales.</p>
                </div>
                <div class="footer-col">
                    <h4>Navigate</h4>
                    <ul>
                        <li><a href="apps/decoder.html">Linguistic Decoder</a></li>
<li><a href="apps.html">Products</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="insights.php">Insights</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Trust &amp; Legal</h4>
                    <ul>
                        <li><a href="legal.html">Legal Hub</a></li>
                        <li><a href="privacy.html">Privacy Policy</a></li>
                        <li><a href="terms.html">Terms of Service</a></li>
                        <li><a href="ai_transparency.html">AI Transparency</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Connect</h4>
                    <p>
                        <a href="mailto:info@digitalabcs.com.au">info@digitalabcs.com.au</a><br>
                        Toongabbie, NSW, Australia
                    </p>
                </div>
            </div>
            <div style="border-top: 1px solid #374151; padding-top: 2rem; margin-top: 2rem; text-align: center; color: #D1D5DB;">
                <p>&copy; 2026 Digital ABCs. All rights reserved. | <a href="mailto:info@digitalabcs.com.au">info@digitalabcs.com.au</a></p>
            </div>
        </div>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.getElementById('resources-toggle');
      const menu = document.getElementById('resources-menu');
      if (!toggleBtn || !menu) return;
      toggleBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        const isExpanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !isExpanded);
        menu.classList.toggle('show');
      });
      document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
          if (menu.classList.contains('show')) {
            menu.classList.remove('show');
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.focus();
          }
        }
      });
      document.addEventListener('click', function (event) {
        if (menu.classList.contains('show') && !menu.contains(event.target) && !toggleBtn.contains(event.target)) {
          menu.classList.remove('show');
          toggleBtn.setAttribute('aria-expanded', 'false');
        }
      });
    });
    </script>
</body>
</html>
