<?php
// Connect to the database
$host = 'localhost';
$dbname = 'website_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch the article details we saved from the admin page
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = 1");
$stmt->execute();
$article = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>ARIIMS 2.0 Transformation - AbleAce Raakin</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">

        <style>
            /* --- Premium Reading Interface Custom CSS --- */
            .reading-container {
                max-width: 850px; /* Limits width to improve text readability */
                margin: 0 auto;
                background: #ffffff;
                padding: 2.5rem;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            }
            @media (max-width: 768px) {
                .reading-container {
                    padding: 1.5rem;
                }
            }
            .article-main-img {
                width: 100%;
                max-height: 480px;
                object-fit: cover;
                border-radius: 12px;
                margin-bottom: 2.5rem;
            }
            .article-meta-info {
                font-size: 0.9rem;
                color: #74818c;
                display: flex;
                gap: 20px;
                flex-wrap: wrap;
                border-bottom: 1px solid #edf2f7;
                padding-bottom: 1.25rem;
                margin-bottom: 2rem;
            }
            .article-meta-info i {
                color: var(--bs-primary);
            }
            .article-body-text {
                font-size: 1.1rem;
                line-height: 1.85;
                color: #333c4d;
            }
            .article-body-text p {
                margin-bottom: 1.75rem;
            }
            .article-body-text h3 {
                font-weight: 700;
                margin-top: 2.5rem;
                margin-bottom: 1.25rem;
                color: #1a202c;
            }
            .article-body-text blockquote {
                font-size: 1.2rem;
                font-style: italic;
                border-left: 4px solid var(--bs-primary);
                padding: 0.5rem 0 0.5rem 1.5rem;
                margin: 2.5rem 0;
                color: #4a5568;
                background-color: #f8f9fa;
                border-radius: 0 8px 8px 0;
            }
            .share-box {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 1rem 1.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 3.5rem;
            }
            .share-btn {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #fff !important;
                margin-left: 8px;
                transition: opacity 0.2s;
            }
            .share-btn:hover {
                opacity: 0.85;
            }
        </style>
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Topbar Start -->
        <div class="container-fluid topbar px-0 d-none d-lg-block">
            <div class="container px-0">
                <div class="row gx-0 align-items-center" style="height: 45px;">
                    <div class="col-lg-8 text-center text-lg-start mb-lg-0">
                        <div class="d-flex flex-wrap">
                        </div>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end">
                        <div class="d-flex align-items-center justify-content-end">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

        <!-- Navbar & Hero Start -->
        <div class="container-fluid sticky-top px-0">
            <div class="position-absolute bg-dark" style="left: 0; top: 0; width: 100%; height: 100%;"></div>
            <div class="container px-0">
                <nav class="navbar navbar-expand-lg navbar-dark bg-white py-3 px-4">
                    <a href="index.html" class="navbar-brand p-0">
                        <img src="assets/img/AAR.svg" alt="AbleAce Raakin Logo" class="logo-img">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav ms-auto py-0">
                            <a href="index.html" class="nav-item nav-link">Home</a>
                            <a href="about.html" class="nav-item nav-link">About Us</a>
                            <a href="service.html" class="nav-item nav-link">ARIIMS</a>
                            <a href="project.html" class="nav-item nav-link">Commodities</a>
                            <a href="404.html" class="nav-item nav-link">Governance</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Insights</a>
                                <div class="dropdown-menu m-0">
                                    <a href="blog.html" class="dropdown-item active">Media Exposure</a>
                                    <a href="faqs.html" class="dropdown-item">FAQs</a>
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Contact Us</a>
                                <div class="dropdown-menu m-0">
                                    <a href="contact.html" class="dropdown-item">Contact Us</a>
                                    <a href="careers.html" class="dropdown-item">Careers</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="bg-breadcrumb-single"></div>
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">ARIIMS Technology Focus</h4>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="blog.html">Media Exposure</a></li>
                    <li class="breadcrumb-item active text-primary">Tech Insights</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->


      <div class="container-fluid py-5 bg-light">
            <div class="container py-3">
                
                <div class="reading-container shadow-sm wow fadeInUp" data-wow-delay="0.1s">
                    
                    <span class="badge bg-primary mb-3 px-3 py-2 text-uppercase font-weight-bold">
                        <?php echo htmlspecialchars($article['category']); ?>
                    </span>
                    <h1 class="display-6 fw-bold text-dark mb-3">
                        <?php echo htmlspecialchars($article['title']); ?>
                    </h1>
                    
                    <div class="article-meta-info">
                        <span><i class="fas fa-calendar-alt me-2"></i>
                            <?php 
                            // This formats the database timestamp neatly (e.g., June 5, 2026)
                            echo date('F j, Y', strtotime($article['updated_at'])); 
                            ?>
                        </span>
                        <span><i class="fas fa-user me-2"></i>By <?php echo htmlspecialchars($article['author']); ?></span>
                    </div>

                    <img src="<?php echo htmlspecialchars($article['image_url']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-main-img">

                    <div class="article-body-text">
                        <?php 
                        // We use direct echo here (no htmlspecialchars) because your admin panel 
                        // textarea saves formatted HTML elements like <p>, <h3>, and <blockquote>
                        echo $article['content']; 
                        ?>
                    </div>

                    <div class="share-box">
                        <a href="latest-news.html" class="btn btn-outline-primary btn-sm"><i class="fas fa-arrow-left me-2"></i>Back to Articles</a>
                        <div class="d-flex align-items-center">
                            <span class="small text-muted me-2 fw-bold d-none d-sm-inline">Share This Post:</span>
                            <a href="#" class="share-btn bg-dark"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="share-btn bg-dark"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="share-btn bg-dark"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        ```

      <!-- ================= ARTICLE INTERFACE END ================= -->


        <!-- Footer Start -->
        <div class="container-fluid footer py-3 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-2">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4 col-lg-4">
                        <div class="footer-item d-flex flex-column">
                            <h6 class="text-white mb-2">AbleAce Raakin</h6>
                            <p class="text-white-50 small mb-2" style="font-size: 0.8rem;">Delivering Shariah-Based Commodity Trade solutions connecting global markets with ethical, sustainable products.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 ps-md-5">
                        <div class="footer-item d-flex flex-column">
                            <h6 class="text-white mb-2">Explore</h6>
                            <div class="row g-0" style="font-size: 0.8rem;">
                                <div class="col-6 d-flex flex-column gap-1">
                                    <a href="index.html"><i class="fas fa-angle-right me-1"></i>Home</a>
                                    <a href="about.html"><i class="fas fa-angle-right me-1"></i>About Us</a>
                                    <a href="service.html"><i class="fas fa-angle-right me-1"></i>ARIIMS</a>
                                </div>
                                <div class="col-6 d-flex flex-column gap-1">
                                    <a href="project.html"><i class="fas fa-angle-right me-1"></i>Commodities</a>
                                    <a href="404.html"><i class="fas fa-angle-right me-1"></i>Governance</a>
                                    <a href="contact.html"><i class="fas fa-angle-right me-1"></i>Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="footer-item d-flex flex-column">
                            <h6 class="text-white mb-2">Contact Info</h6>
                            <div class="d-flex flex-column gap-1" style="font-size: 0.8rem;">
                                <a href="contact.html"><i class="fa fa-map-marker-alt me-2"></i>AbleAce Raakin Sdn Bhd, Kuala Lumpur</a>
                                <a href="contact.html"><i class="fas fa-envelope me-2"></i>service@ableace.com</a>
                                <a href="contact.html"><i class="fas fa-phone me-2"></i>+603 2161 5166</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="text-white-50 mt-2 mb-0">
            </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <span class="text-body" style="font-size: 0.8rem;">&copy; 2026 AbleAce Raakin. All Rights Reserved.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end" style="font-size: 0.8rem;">
                        Designed By <a class="border-bottom text-primary" href="https://htmlcodex.com">HTML Codex</a> &nbsp;|&nbsp;
                        Distributed By <a class="border-bottom text-primary" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>
        <script src="js/main.js"></script>

    </body>
</html>