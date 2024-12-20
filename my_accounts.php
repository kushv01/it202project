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

// Fetch user's accounts with balances
$stmt = $db->prepare("
    SELECT 
        account_number, 
        account_type, 
        balance, 
        modified 
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
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #004085, #00aaff);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav, footer {
            background-color: #003366;
            color: #fff;
            padding: 10px 20px;
        }

        nav .nav-links, nav .logo {
            display: flex;
            align-items: center;
        }

        nav .nav-links {
            justify-content: flex-end;
            gap: 15px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
        }

        nav a:hover {
            background-color: #0056b3;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 10px;
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

        footer {
            text-align: center;
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">VaultForge</div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <h1>My Accounts</h1>
    <?php if (count($accounts) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Account Number</th>
                    <th>Account Type</th>
                    <th>Balance ($)</th>
                    <th>Last Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($account['account_number']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($account['account_type'])); ?></td>
                        <td><?php echo number_format($account['balance'], 2); ?></td>
                        <td><?php echo htmlspecialchars($account['modified']); ?></td>
                        <td>
                            <a href="transaction_history.php?account_number=<?php echo urlencode($account['account_number']); ?>" style="color: #004085;">Learn More</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No accounts found. <a href="create_account.php" style="color: #004085;">Create an account</a> to get started.</p>
    <?php endif; ?>
</div>

<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
