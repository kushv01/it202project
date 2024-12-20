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
$world_account_id = -1; // Assuming the world account ID is -1

// Fetch user's accounts
$stmt = $db->prepare("
    SELECT id, account_number, balance 
    FROM Accounts
    WHERE user_id = :user_id
");
$stmt->execute([":user_id" => $user_id]);
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_id = $_POST['account_id'] ?? null;
    $amount = floatval($_POST['amount'] ?? 0);
    $memo = $_POST['memo'] ?? "";

    if ($amount <= 0) {
        $error_message = "Please enter a positive amount.";
    } elseif (!$account_id) {
        $error_message = "Please select an account.";
    } else {
        try {
            $db->beginTransaction();

            // Fetch current balance of the user account
            $stmt = $db->prepare("SELECT balance FROM Accounts WHERE id = :account_id");
            $stmt->execute([":account_id" => $account_id]);
            $current_balance = $stmt->fetchColumn();

            if ($current_balance < $amount) {
                throw new Exception("Insufficient funds.");
            }

            $expected_user_balance = $current_balance - $amount;

            // Fetch current balance of the world account
            $stmt = $db->prepare("SELECT balance FROM Accounts WHERE id = :world_account_id");
            $stmt->execute([":world_account_id" => $world_account_id]);
            $world_balance = $stmt->fetchColumn();

            $expected_world_balance = $world_balance + $amount;

            // Record withdrawal from user account
            $stmt = $db->prepare("
                INSERT INTO Transactions (account_src, account_dest, transaction_type, balance_change, expected_total, memo)
                VALUES (:src, :dest, :type, :amount, :expected_total, :memo)
            ");
            $stmt->execute([
                ":src" => $account_id,
                ":dest" => $world_account_id,
                ":type" => 'withdraw',
                ":amount" => -$amount,
                ":expected_total" => $expected_user_balance,
                ":memo" => $memo
            ]);

            // Record deposit to world account
            $stmt->execute([
                ":src" => $world_account_id,
                ":dest" => $account_id,
                ":type" => 'deposit',
                ":amount" => $amount,
                ":expected_total" => $expected_world_balance,
                ":memo" => $memo
            ]);

            // Update account balances
            $stmt = $db->prepare("UPDATE Accounts SET balance = :expected_total WHERE id = :account_id");
            $stmt->execute([":expected_total" => $expected_user_balance, ":account_id" => $account_id]);

            $stmt->execute([":expected_total" => $expected_world_balance, ":account_id" => $world_account_id]);

            $db->commit();
            $success_message = "Withdrawal of $amount successful.";
        } catch (Exception $e) {
            $db->rollBack();
            $error_message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw - VaultForge</title>
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
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #004085;
        }

        form input, form select, form button {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        form button {
            background-color: #004085;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        form button:hover {
            background-color: #0056b3;
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
    <h1>Withdraw</h1>
    <?php if ($success_message) : ?>
        <p style="color: green;"><?php echo htmlspecialchars($success_message); ?></p>
    <?php elseif ($error_message) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="account_id">Select Account</label>
        <select name="account_id" required>
            <?php foreach ($accounts as $account) : ?>
                <option value="<?php echo htmlspecialchars($account['id']); ?>">
                    <?php echo htmlspecialchars($account['account_number']); ?> - $<?php echo number_format($account['balance'], 2); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="amount">Amount</label>
        <input type="number" name="amount" required>
        <label for="memo">Memo (optional)</label>
        <input type="text" name="memo">
        <button type="submit">Withdraw</button>
    </form>
</div>

<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>
</body>
</html>
