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
    <title>Insights | Digital ABCs</title>
    <meta name="description" content="Practical insights on workflow automation, business efficiency, and technology for Australian small businesses. From Digital ABCs.">
    <link rel="canonical" href="https://digitalabcs.com.au/insights.php">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
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

        @media (min-width: 768px) {
            .dynamic-reports-grid {
                grid-template-columns: repeat(2, 1fr);
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
                <img src="assets/logo.png" alt="Digital ABCs Logo" class="logo-img">
            </a>
            <nav class="main-nav" aria-label="Main navigation">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="apps.html">Apps We've Built</a></li>
                    <li><a href="insights.php" class="active">Insights</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="portal.html" class="btn-login">Client Login</a></li>
                </ul>
            </nav>
        </div>
        <script async src="https://tally.so/widgets/embed.js"></script>
    </header>
    <main id="main-content">
        <section class="hero">
            <div class="container">
                <h1>Insights</h1>
                <p class="subtitle">Practical thoughts on workflow efficiency, automation, and building tech that actually works for small businesses.</p>
            </div>
        </section>

        <nav class="secondary-nav" aria-label="Secondary site resources">
            <div class="container">
                <div class="resources-dropdown">
                    <button
                        id="resources-toggle"
                        class="resources-toggle"
                        aria-expanded="false"
                        aria-controls="resources-menu"
                    >
                        Resources
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" width="20" height="20">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div id="resources-menu" class="resources-menu">
                        <ul>
                            <li><a href="prompt_refinement.html">Prompt Builder</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <section class="insights-grid section-padding">
            <div class="container">

                <h2>Weekly Reports</h2>
                <p>Auto-generated insights on Australian business, compliance, and automation. Newest first.</p>

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
                <h2>From the Blog</h2>
                <p>Foundational articles on workflow efficiency, automation, and building useful technology.</p>
                </div>
        </section>
    </main>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Digital ABCs</h4>
                    <p>Finding workflow bottlenecks and building the apps that fix them.</p>
                </div>
                <div class="footer-col">
                    <h4>Navigate</h4>
                    <ul>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="apps.html">Apps</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="insights.php">Insights</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="privacy.html">Privacy Policy</a></li>
                        <li><a href="terms.html">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Connect</h4>
                    <p>info@digitalabcs.com.au<br>Toongabbie, NSW, Australia</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Digital ABCs. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <style>
        .tally-float-btn {
            position: fixed; bottom: 20px; right: 20px; background-color: #5B21B6; color: #fff; border: none; border-radius: 50px; padding: 14px 22px; font-size: 16px; font-weight: 600; cursor: pointer; z-index: 9999; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); display: flex; align-items: center; gap: 8px; transition: all 0.2s ease-in-out;
        }
        .tally-float-btn:hover { background-color: #065F46; transform: translateY(-2px); }
        @media (max-width: 600px) { .tally-float-btn { padding: 12px 18px; font-size: 14px; bottom: 15px; right: 15px; } }
    </style>
    <button class="tally-float-btn" data-tally-open="wkDaP1" data-tally-layout="modal" data-tally-width="700" data-tally-overlay="true" data-tally-hide-title="false" data-tally-emoji-text="💡" data-tally-emoji-animation="tada">Got a workflow problem?</button>

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
