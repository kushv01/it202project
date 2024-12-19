<?php
session_start();
require_once(__DIR__ . "/lib/user_helpers.php");
require_once(__DIR__ . "/lib/db.php");

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$db = getDB();
$user_id = get_user_id();
$accounts = [];

// Fetch the user's accounts (limit 5)
$stmt = $db->prepare("
    SELECT 
        account_number, 
        account_type, 
        modified, 
        (
            SELECT IFNULL(SUM(balance_change), 0) 
            FROM Transactions 
            WHERE account_dest = Accounts.id
        ) - (
            SELECT IFNULL(SUM(balance_change), 0) 
            FROM Transactions 
            WHERE account_src = Accounts.id
        ) AS balance
    FROM Accounts
    WHERE user_id = :user_id
    ORDER BY modified DESC
    LIMIT 5
");
$stmt->execute([":user_id" => $user_id]);
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Accounts - VaultForge</title>
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

        /* Content Container */
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .container h1 {
            color: #004085;
            margin-bottom: 20px;
            font-size: 2rem;
            text-align: center;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #004085;
            color: #fff;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table td {
            color: #333;
        }

        table .learn-more {
            background-color: #004085;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }

        table .learn-more:hover {
            background-color: #0056b3;
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

<!-- Content Section -->
<div class="container">
    <h1>My Accounts</h1>

    <?php if (count($accounts) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Account Number</th>
                    <th>Account Type</th>
                    <th>Last Modified</th>
                    <th>Balance ($)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($account['account_number']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($account['account_type'])); ?></td>
                        <td><?php echo htmlspecialchars($account['modified']); ?></td>
                        <td><?php echo number_format($account['balance'], 2); ?></td>
                        <td>
                            <a 
                                class="learn-more" 
                                href="transaction_history.php?account_number=<?php echo urlencode($account['account_number']); ?>">
                                Learn More
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No accounts found. <a href="create_account.php" style="color: #004085; text-decoration: underline;">Create an account</a> to get started.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
