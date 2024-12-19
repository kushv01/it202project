<?php
session_start();
require_once(__DIR__ . "/lib/user_helpers.php");

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

// Get success message if available
$success_message = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - VaultForge</title>
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
            background-color: #003366;
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

        /* Dashboard container */
        .dashboard {
            max-width: 800px;
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .dashboard h1 {
            color: #004085;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .dashboard-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .dashboard-links a {
            display: block;
            width: 45%;
            background-color: #004085;
            color: #fff;
            text-decoration: none;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .dashboard-links a:hover {
            background-color: #0056b3;
        }

        /* GIF Section */
        .gif-section {
            margin: 30px 0;
            text-align: center;
        }

        .gif-section img {
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

            .dashboard-links a {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="logo">VaultForge</div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<!-- Dashboard Section -->
<div class="dashboard">
    <h1>Dashboard</h1>

    <?php if ($success_message) : ?>
        <?php
        // Mask account number in the success message
        $success_message = preg_replace('/\b(\d{8})(\d{4})\b/', '********$2', $success_message);
        ?>
        <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <div class="dashboard-links">
        <a href="create_account.php">Create Account</a>
        <a href="my_accounts.php">My Accounts</a>
        <a href="deposit.php">Deposit</a>
        <a href="withdraw.php">Withdraw</a>
        <a href="transfer.php">Transfer</a>
        <a href="profile.php">Profile</a>
    </div>
</div>

<!-- Placeholder for GIF -->
<div class="gif-section">
    <h2>Your Banking in Action</h2>
    <p>Here you can see your banking options in motion.</p>
    <img src="/public/images/dashboard.gif" alt="Placeholder for Banking GIF">
</div>

<!-- Footer -->
<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
