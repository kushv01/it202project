<?php
session_start();
require_once(__DIR__ . "/lib/user_helpers.php");
require_once(__DIR__ . "/lib/db.php");

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$db = getDB();
$errors = [];
$account_details = null;
$transactions = [];

// Get the account number from the query string
$account_number = $_GET['account_number'] ?? null;

if ($account_number) {
    // Fetch account details
    $stmt = $db->prepare("
        SELECT 
            account_number, 
            account_type, 
            created, 
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
        WHERE account_number = :account_number AND user_id = :user_id
    ");
    $stmt->execute([
        ":account_number" => $account_number,
        ":user_id" => get_user_id()
    ]);
    $account_details = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch transaction history
    $stmt = $db->prepare("
        SELECT 
            t.account_src, 
            t.account_dest, 
            t.transaction_type, 
            t.balance_change, 
            t.memo, 
            t.expected_total, 
            t.created
        FROM Transactions t
        JOIN Accounts a ON t.account_src = a.id OR t.account_dest = a.id
        WHERE a.account_number = :account_number
        ORDER BY t.created DESC
        LIMIT 10
    ");
    $stmt->execute([":account_number" => $account_number]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $errors[] = "Invalid account number.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - VaultForge</title>
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

        .error-message {
            color: red;
            font-weight: bold;
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
    <h1>Transaction History</h1>

    <?php if ($errors) : ?>
        <div class="error-message">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <h2>Account Details</h2>
        <p><strong>Account Number:</strong> <?php echo htmlspecialchars($account_details['account_number']); ?></p>
        <p><strong>Account Type:</strong> <?php echo ucfirst(htmlspecialchars($account_details['account_type'])); ?></p>
        <p><strong>Balance:</strong> $<?php echo number_format($account_details['balance'], 2); ?></p>
        <p><strong>Opened:</strong> <?php echo htmlspecialchars($account_details['created']); ?></p>

        <h2>Recent Transactions</h2>
        <?php if (count($transactions) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Source Account</th>
                        <th>Destination Account</th>
                        <th>Transaction Type</th>
                        <th>Change ($)</th>
                        <th>Memo</th>
                        <th>Expected Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaction['account_src']); ?></td>
                            <td><?php echo htmlspecialchars($transaction['account_dest']); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($transaction['transaction_type'])); ?></td>
                            <td><?php echo number_format($transaction['balance_change'], 2); ?></td>
                            <td><?php echo htmlspecialchars($transaction['memo']); ?></td>
                            <td><?php echo number_format($transaction['expected_total'], 2); ?></td>
                            <td><?php echo htmlspecialchars($transaction['created']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No transactions found for this account.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
