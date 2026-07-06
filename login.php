<?php
session_start();

// If already logged in, skip this page and go straight to the admin panel
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-edit.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $dbname = 'website_db';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed.");
    }

    $input_user = $_POST['username'];
    $input_pass = $_POST['password'];

    // Verify credentials
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username AND password = :password");
    $stmt->execute([':username' => $input_user, ':password' => $input_pass]);
    $admin = $stmt->fetch();

    if ($admin) {
        // SUCCESS: Tell PHP to remember the login session
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $admin['username'];
        
        // Redirect to your admin editor page
        header("Location: admin-edit.php");
        exit;
    } else {
        $error = "<div class='alert alert-danger'>Invalid Username or Password!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Login - AbleAce Raakin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <style>
        .login-container {
            max-width: 450px;
            margin: 80px auto;
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body class="bg-light">

    <div class="container">
        <div class="login-container">
            <div class="text-center mb-4">
                <img src="assets/img/AAR.svg" alt="Logo" style="max-height: 40px;" class="mb-3">
                <h4 class="fw-bold text-dark">Portal Authorization</h4>
                <p class="text-muted small">Please log in to manage your website content</p>
            </div>

            <?php echo $error; ?>
			
			<?php
    if (isset($_GET['status']) && $_GET['status'] == 'logged_out') {
        echo "<div class='alert alert-info shadow-sm mb-4'><i class='fas fa-info-circle me-2'></i>You have been securely logged out.</div>";
    }
    ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold small">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    <i class="fas fa-sign-in-alt me-2"></i>Secure Login
                </button>
            </form>
        </div>
    </div>

</body>
</html>