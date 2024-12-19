<?php
session_start(); // Start the session
require_once(__DIR__ . "/lib/user_helpers.php");
require_once(__DIR__ . "/lib/db.php"); // Include the DB connection logic

$db = getDB(); // Initialize the database connection
$user = null;

// Check if the user is logged in
if (is_logged_in()) {
    $user_id = get_user_id();
    $stmt = $db->prepare("SELECT username, email FROM Users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();
} else {
    header("Location: login.php"); // Redirect if not logged in
    exit;
}

// Fetch the world account balance
$stmt = $db->prepare("SELECT balance FROM Accounts WHERE account_number = '000000000000' AND account_type = 'world'");
$stmt->execute();
$world_account = $stmt->fetch(PDO::FETCH_ASSOC);
$world_balance = $world_account['balance'] ?? 0.00;
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
            background: linear-gradient(135deg, #004085, #00aaff);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar styling */
        nav {
            background-color: #003366; /* Slightly darker */
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
            font-size: 2rem;
        }

        .hero p {
            margin: 15px 0;
            font-size: 1.2rem;
            color: #ddd;
        }

        .info-section {
            margin: 30px 0;
        }

        .info-section h2 {
            margin-bottom: 15px;
        }

        /* World Balance Section */
        .world-balance {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border: 1px solid #fff;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }

        .world-balance h2 {
            margin-bottom: 10px;
        }

        .world-balance p {
            font-size: 1.2rem;
        }

        /* Video Section */
        .video-section {
            text-align: center;
            margin: 40px 0;
        }

        .video-section img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        /* Footer */
        footer {
            background-color: #002244;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
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
        <a href="dashboard.php">Dashboard</a> <!-- Added Dashboard Link -->
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

    <div class="world-balance">
        <h2>World Account Balance</h2>
        <p><strong>$<?php echo number_format($world_balance, 2); ?></strong></p>
    </div>

    <div class="video-section">
        <img src="/public/images/landing.gif" alt="Banking Video">
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
