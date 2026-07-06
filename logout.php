<?php
// 1. Initialize or join the current active session
session_start();

// 2. Unset all session variables to wipe out user data in memory
$_SESSION = array();

// 3. Completely delete the session cookie from the user's browser if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. Destroy the session registration files on the server
session_destroy();

// 5. Send the logged-out admin back to the login portal with a clear exit status
header("Location: login.php?status=logged_out");
exit;
?>

