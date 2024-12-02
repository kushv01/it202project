<?php
session_start(); // Start the session

require(__DIR__ . "/partials/nav.php");
?>
<h1>Home</h1>
<?php
if (is_logged_in()) {
    echo "Welcome, " . get_user_email();
    echo '<br><a href="logout.php">Logout</a>'; // Add a logout link
} else {
    echo "You're not logged in";
}
?>
