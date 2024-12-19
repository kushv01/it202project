<?php
session_start(); // Start the session
require_once(__DIR__ . "/lib/user_helpers.php");
require_once(__DIR__ . "/lib/db.php"); // Include the DB connection logic

$db = getDB(); // Initialize the database connection
$user = null;

if (is_logged_in()) {
    $user_id = get_user_id();
    $stmt = $db->prepare("SELECT username, email FROM Users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VaultForge - Banking Made Secure</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Navbar styling */
        nav {
            background-color: #004085; /* Brand color */
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav .logo {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        nav .nav-links {
            display: flex;
            gap: 20px;
        }

        nav .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            padding: 8px 12px;
        }

        nav .nav-links a:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }

        /* Main content */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .hero {
            text-align: center;
            margin-bottom: 30px;
        }

        .hero h1 {
            color: #004085;
            font-size: 2rem;
        }

        .hero p {
            margin: 15px 0;
            font-size: 1.2rem;
            color: #555;
        }

        /* Video section */
        .video-section {
            text-align: center;
            margin: 40px 0;
        }

        .video-section iframe {
            width: 100%;
            max-width: 600px;
            height: 350px;
            border: none;
        }

        /* Footer */
        footer {
            background-color: #003366;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 30px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav .nav-links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">VaultForge</div>
    <div class="nav-links">
        <a href="profile.php">Profile</a>
        <a href="transactions.php">Transactions</a>
        <a href="accounts.php">Accounts</a>
        <?php if (is_logged_in()) : ?>
            <a href="logout.php">Logout</a>
        <?php else : ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    <div class="hero">
        <h1>Welcome to VaultForge</h1>
        <p>Your trusted partner in secure banking and seamless transactions.</p>
    </div>

    <?php if (is_logged_in()) : ?>
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <?php else : ?>
        <h2>Please log in to access your account and manage your finances.</h2>
    <?php endif; ?>

    <div class="video-section">
        <img src="/public/images/landing.gif"title="Banking Video"></img>
    </div>

    <div class="info-section">
        <h2>About VaultForge</h2>
        <p>VaultForge offers a modern banking experience with advanced features like real-time transactions, secure account management, and more.</p>
    </div>
</div>

<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
