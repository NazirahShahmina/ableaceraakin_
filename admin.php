<?php
// 1. Define your secure Username and Password
define('ADMIN_USER', 'admin_ableace'); 
define('ADMIN_PASS', 'Admin_2026'); 

// 2. Trigger Browser Authentication dialog
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    ($_SERVER['PHP_AUTH_USER'] !== ADMIN_USER) || ($_SERVER['PHP_AUTH_PW'] !== ADMIN_PASS)) {
    
    header('WWW-Authenticate: Basic realm="AbleAce Admin Panel"');
    header('HTTP/1.0 401 Unauthorized');
    echo '<h1>Authorization Required</h1>You must enter a valid username and password to access this panel.';
    exit;
}

// ... rest of your existing admin.php configuration code starts here ...

$json_file = 'links.json';

// Handle Form Submission (Update Process)
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated_data = [
        'jobstreet_url' => filter_var($_POST['jobstreet_url'], FILTER_SANITIZE_URL),
        'myfuturejobs_url' => filter_var($_POST['myfuturejobs_url'], FILTER_SANITIZE_URL)
    ];
    
    if (file_put_contents($json_file, json_encode($updated_data, JSON_PRETTY_PRINT))) {
        $message = '<div class="alert alert-success">Links updated successfully!</div>';
    } else {
        $message = '<div class="alert alert-danger">Failed to save links. Check file permissions.</div>';
    }
}

// Read current data
$current_data = json_decode(file_get_contents($json_file), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ableace Raakin</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        :root {
            --primary-dark: #001b4e;
            --accent-blue: #1a4da1;
            --light-bg: #f8fafc;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: #333;
        }
        .dashboard-container {
            max-width: 700px;
            margin: 60px auto;
        }
        .card-panel {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
        }
        .panel-header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .panel-header h2 {
            color: var(--primary-dark);
            font-weight: 700;
        }
        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
        }
        .btn-save {
            background-color: var(--accent-blue);
            color: #fff;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 10px;
            border: none;
            transition: 0.3s;
        }
        .btn-save:hover {
            background-color: #113570;
            color: #fff;
        }
        .btn-view {
            background-color: #edf2f7;
            color: var(--text-gray);
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>

<div class="container dashboard-container">
    <div class="card card-panel">
        <div class="panel-header d-flex justify-content-between align-items-center">
            <div>
                <h2>Recruitment Link Settings</h2>
                <p class="text-muted m-0">Update live job board redirect channels dynamically.</p>
            </div>
            <i class="fas fa-user-cog fa-2x text-muted"></i>
        </div>

        <?php echo $message; ?>

        <form action="admin.php" method="POST">
            <!-- JobStreet Control -->
            <div class="mb-4">
                <label for="jobstreet_url" class="form-label">
                    <i class="fas fa-link text-warning me-2"></i>JobStreet Profile URL
                </label>
                <input type="url" class="form-control form-control-lg" id="jobstreet_url" name="jobstreet_url" 
                       value="<?php echo htmlspecialchars($current_data['jobstreet_url'] ?? ''); ?>" placeholder="https://www.jobstreet.com.my/..." required>
                <div class="form-text">Paste the direct link to the AbleAce Raakin corporate page on JobStreet.</div>
            </div>

            <!-- MYFutureJobs Control -->
            <div class="mb-4">
                <label for="myfuturejobs_url" class="form-label">
                    <i class="fas fa-link text-danger me-2"></i>MYFutureJobs Profile URL
                </label>
                <input type="url" class="form-control form-control-lg" id="myfuturejobs_url" name="myfuturejobs_url" 
                       value="<?php echo htmlspecialchars($current_data['myfuturejobs_url'] ?? ''); ?>" placeholder="https://www.myfuturejobs.gov.my/..." required>
                <div class="form-text">Paste the direct link to the corporate platform layout on MYFutureJobs.</div>
            </div>

            <hr class="my-4">

            <!-- Action buttons -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="careers.html" target="_blank" class="btn-view">
                    <i class="fas fa-eye"></i> View Careers Page
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save me-2"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>