<?php
// Check if the session is not already started
if (session_status() === PHP_SESSION_NONE) {
    // Resolve cookie issues with port numbers
    $domain = $_SERVER["HTTP_HOST"];
    if (strpos($domain, ":")) {
        $domain = explode(":", $domain)[0];
    }
    $localWorks = true; // Flag for handling localhost issues

    // Set cookie parameters only if the session is not active
    if (($localWorks && $domain == "localhost") || $domain != "localhost") {
        session_set_cookie_params([
            "lifetime" => 60 * 60,
            "path" => "/Project",
            "domain" => $domain,
            "secure" => false, // Change to true if using HTTPS
            "httponly" => true,
            "samesite" => "lax"
        ]);
    }

    // Start the session
    session_start();
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
