<?php
// article.php - The Wrapper

// 1. SECURITY: Get the requested file ID
$requested_file = $_GET['id'] ?? '';
$clean_name = basename($requested_file); 
$file_path = __DIR__ . '/insights/' . $clean_name;

// 2. VALIDATION & DATA EXTRACTION
$content = "";
$title = "Article Not Found";
$subtitle = "Insights";

if (!empty($clean_name) && file_exists($file_path) && str_ends_with($clean_name, '_article.html')) {
    // Load the raw HTML content
    $content = file_get_contents($file_path);
    
    // Extract Title (H2) to promote to Hero H1
    if (preg_match('/<h2>(.*?)<\/h2>/', $content, $matches)) {
        $title = strip_tags($matches[1]);
        // Optional: Remove the H2 from the content body so it doesn't appear twice
        // $content = str_replace($matches[0], '', $content); 
    } else {
        $title = "Digital ABCs Insight";
    }

    // Extract Date from Filename (YYYYMMDD)
    if (preg_match('/^(\d{8})_/', $clean_name, $date_matches)) {
        $subtitle = date("F j, Y", strtotime($date_matches[1]));
    }
} else {
    // Handle 404
    header("HTTP/1.0 404 Not Found");
    $title = "Page Not Found";
    $content = "<p>The article you are looking for does not exist or has been moved.</p><a href='insights.php' class='btn-read-more'>Return to Insights</a>";
}
?>
<!DOCTYPE html>
<html lang="en-AU">

<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4JD4ZCN0G8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-4JD4ZCN0G8');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - Digital ABCs</title>
    <meta name="description" content="Read the latest insights on AI, automation, and compliance from Digital ABCs.">
    
    <link rel="canonical" href="https://digitalabcs.com.au/article.php?id=<?php echo htmlspecialchars($clean_name); ?>">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        /* FIX: Ensure full width */
        body, html {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Article Specific Layout */
        .article-container {
            max-width: 800px; /* Keeps text readable */
            margin: 0 auto;   /* Centers the container */
            padding: 40px 20px;
        }

        /* Typography Fixes for Generated Content */
        .article-content h2 {
            color: var(--color-navy, #1E3A8A);
            font-size: 1.8rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        
        .article-content p {
            line-height: 1.8;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .article-content ul {
            margin-bottom: 1.5rem;
            padding-left: 20px;
        }

        .article-content li {
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .article-content strong {
            color: var(--color-purple, #5B21B6);
        }

        .breadcrumb {
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .breadcrumb a {
            color: var(--color-purple, #5B21B6);
            text-decoration: none;
            font-weight: 500;
        }

        .article-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Hero Overrides for Article Page if needed */
        .hero {
            text-align: center;
            padding: 60px 20px;
            background-color: var(--color-navy, #1E3A8A); /* Fallback */
            /* Ensure style.css hero styles apply here */
        }
        
        .hero h1 {
            max-width: 900px;
            margin: 0 auto 10px auto;
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
                    <li><a href="apps.html">Current Projects</a></li>
                    <li><a href="insights.php" class="active">Insights</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main-content">
        
        <section class="hero">
            <div class="container">
                <h1><?php echo htmlspecialchars($title); ?></h1>
                <p class="subtitle"><?php echo htmlspecialchars($subtitle); ?></p>
            </div>
        </section>

        <article class="article-container">
            
            <div class="breadcrumb">
                <a href="insights.php">&larr; Back to Insights</a>
            </div>

            <?php
                $thumb_name = str_replace('_article.html', '_thumbnail.png', $clean_name);
                $thumb_path = __DIR__ . '/insights/' . $thumb_name;
                // Fallback for JPG/PNG check
                if(file_exists($thumb_path)) {
                    echo '<img src="insights/' . htmlspecialchars($thumb_name) . '" class="article-image" alt="Illustration for ' . htmlspecialchars($title) . '">';
                } elseif(file_exists(str_replace('.png', '.jpg', $thumb_path))) {
                    $jpg_name = str_replace('.png', '.jpg', $thumb_name);
                    echo '<img src="insights/' . htmlspecialchars($jpg_name) . '" class="article-image" alt="Illustration for ' . htmlspecialchars($title) . '">';
                }
            ?>

            <div class="article-content">
                <?php echo $content; ?>
            </div>

            <div class="section-divider"></div>
            <div style="background: #f0f9ff; padding: 30px; border-radius: 8px; margin-top: 40px; border-left: 5px solid var(--color-purple, #5B21B6);">
                <h3 style="margin-top:0; color: var(--color-navy, #1E3A8A);">Want to talk to Digital ABCs?</h3>
                <p style="margin-bottom: 20px;">Use the contact form for a written enquiry first, or open the call booking from the contact page if you know you need a conversation.</p>
                <a href="contact.html" class="btn-read-more">Go to Contact</a>
            </div>

        </article>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Powered by <span class="footer-brand">Digital ABCs</span></h4>
                    <p>Founder-led self-quantification and educational apps built in Western Sydney.</p>
                </div>
                <div class="footer-col">
                    <h4>Navigate</h4>
                    <ul>
                        <li><a href="apps.html">Current Projects</a></li>
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
</body>
</html>
