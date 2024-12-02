<?php
// Note: this is to resolve cookie issues with port numbers
$domain = $_SERVER["HTTP_HOST"];
if (strpos($domain, ":")) {
    $domain = explode(":", $domain)[0];
}

$localWorks = true; // Some people have issues with localhost for the cookie params
// If you're one of those people, make this false

// Check if the session is already started
if (session_status() === PHP_SESSION_NONE) {
    // Set session cookie parameters only if the session hasn't started
    if (($localWorks && $domain == "localhost") || $domain != "localhost") {
        session_set_cookie_params([
            "lifetime" => 60 * 60, // 1 hour
            "path" => "/Project",
            "domain" => $domain,
            "secure" => true, // Use true if HTTPS is enabled
            "httponly" => true,
            "samesite" => "Lax"
        ]);
    }
    session_start(); // Start the session
}

require_once(__DIR__ . "/../lib/functions.php");
?>
<nav>
    <ul>
        <?php if (is_logged_in()) : ?>
            <li><a href="home.php">Home</a></li>
        <?php endif; ?>
        <?php if (!is_logged_in()) : ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
        <?php if (is_logged_in()) : ?>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
