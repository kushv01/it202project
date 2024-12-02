<?php
session_start(); // Start the session to access session variables

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Optionally clear the session cookie
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

// Redirect to login page or home page
header("Location: login.php");
exit(); // Ensure no further code is executed
