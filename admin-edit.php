<?php
// --- START SECURE SESSION ENGINE ---
session_start();

// GATEKEEPER: If the session variable is NOT set, redirect immediately to login.php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
// --- END SECURE SESSION ENGINE ---

// --- 1. DATABASE CONNECTION CONFIGURATION ---
$host = 'localhost';
$dbname = 'website_db';
$username = 'root';
$password = ''; // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$message = ""; // Container for success/error alerts

// --- 2. HANDLE FORM SUBMISSION (UPDATE ACTION) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_article'])) {
    $id = 1; // Directing edits specifically to our target baseline article
    $category = $_POST['category'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $image_url = $_POST['image_url'];
    $content = $_POST['content'];

    $sql = "UPDATE articles SET category = :category, title = :title, author = :author, image_url = :image_url, content = :content WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([
        ':category' => $category,
        ':title' => $title,
        ':author' => $author,
        ':image_url' => $image_url,
        ':content' => $content,
        ':id' => $id
    ])) {
        $message = "<div class='alert alert-success shadow-sm mb-4'><i class='fas fa-check-circle me-2'></i>Article updated successfully! View changes on your public site.</div>";
    } else {
        $message = "<div class='alert alert-danger shadow-sm mb-4'><i class='fas fa-exclamation-circle me-2'></i>Something went wrong. Please check your data.</div>";
    }
}

// --- 3. FETCH CURRENT CONTENT TO POPULATE THE CHANNELS ---
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = 1");
$stmt->execute();
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Error: Base article record missing. Please seed the database using the SQL query provided.");
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Admin Dashboard - Edit Article</title>
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
            /* --- Custom Admin Workspace Overlays --- */
            .admin-container {
                max-width: 950px;
                margin: 0 auto;
                background: #ffffff;
                padding: 3rem;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.05);
                border-top: 5px solid var(--bs-primary);
            }
            .form-label {
                font-weight: 600;
                color: #2d3748;
                margin-top: 1rem;
            }
            .admin-header-badge {
                background-color: #e2e8f0;
                color: #4a5568;
                font-size: 0.85rem;
                letter-spacing: 0.05em;
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
                        <div class="d-flex flex-wrap"></div>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end">
                        <div class="d-flex align-items-center justify-content-end"></div>
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
                                    <a href="blog.html" class="dropdown-item">Media Exposure</a>
                                    <a href="faqs.html" class="dropdown-item">FAQs</a>
                                </div>
                            </div>
                            <a href="#" class="nav-item nav-link active text-danger fw-bold"><i class="fas fa-lock me-1"></i>Admin Gate</a>
                            <!-- Secure Session Exit Control -->
                            <a href="logout.php" class="nav-item nav-link text-muted fw-bold ms-2"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
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
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Content Management System</h4>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active text-primary">Admin Control Panel</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->


        <!-- ================= ADMINISTRATIVE WORKSPACE CONTROL PANEL ================= -->
        <div class="container-fluid py-5 bg-light">
            <div class="container py-3">
                
                <div class="admin-container wow fadeInUp" data-wow-delay="0.1s">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <div>
                            <span class="badge admin-header-badge text-uppercase px-3 py-2 mb-2">Internal Operations Portal</span>
                            <h2 class="fw-bold text-dark m-0">Edit Media Exposure Article</h2>
                        </div>
                        <a href="media-exposure.php" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-external-link-alt me-1"></i> Live Preview Site
                        </a>
                    </div>

                    <!-- Execution Confirmation and Error Banners -->
                    <?php echo $message; ?>

                    <form action="" method="POST">
                        <div class="row g-3">
                            
                            <!-- Category Assignment -->
                            <div class="col-md-6">
                                <label class="form-label">Article Category Tag</label>
                                <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($article['category']); ?>" required>
                            </div>

                            <!-- Author Desk Assignment -->
                            <div class="col-md-6">
                                <label class="form-label">Author / Attributed Desk</label>
                                <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($article['author']); ?>" required>
                            </div>

                            <!-- Title Management -->
                            <div class="col-12">
                                <label class="form-label">Main Headline Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($article['title']); ?>" required>
                            </div>

                            <!-- Featured Visual asset URL -->
                            <div class="col-12">
                                <label class="form-label">Featured Image URL</label>
                                <input type="url" name="image_url" class="form-control" value="<?php echo htmlspecialchars($article['image_url']); ?>" required>
                                <div class="form-text text-muted">Provide a valid web path or locally mapped URL string (e.g. assets/img/hero.jpg).</div>
                            </div>

                            <!-- Core HTML Content Canvas Engine -->
                            <div class="col-12">
                                <label class="form-label">Article Body Content (Accepts raw HTML structure)</label>
                                <textarea name="content" class="form-control" rows="12" required style="font-family: 'Courier New', monospace; font-size: 0.95rem;"><?php echo htmlspecialchars($article['content']); ?></textarea>
                                <div class="form-text text-muted">You can write standard HTML elements such as <code>&lt;p&gt;</code>, <code>&lt;h3&gt;</code>, or <code>&lt;blockquote&gt;</code> to style the article text layouts directly.</div>
                            </div>

                            <!-- Dispatch Controls -->
                            <div class="col-12 pt-3">
                                <button type="submit" name="update_article" class="btn btn-primary px-4 py-2 me-2">
                                    <i class="fas fa-save me-2"></i>Publish Live Changes
                                </button>
                                <a href="media-exposure.php" class="btn btn-light px-4 py-2">Discard Changes</a>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
        <!-- ================= ADMINISTRATIVE WORKSPACE CONTROL PANEL END ================= -->


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