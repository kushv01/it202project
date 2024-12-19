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
$success_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = get_user_id();
    $account_type = $_POST['account_type'] ?? 'checking';
    $deposit_amount = floatval($_POST['deposit_amount'] ?? 0);

    if ($deposit_amount < 5) {
        $errors[] = "Minimum deposit amount is $5.";
    } else {
        try {
            $db->beginTransaction();

            // Generate a unique 12-character account number
            do {
                $account_number = str_pad(rand(0, 999999999999), 12, "0", STR_PAD_LEFT);
                $stmt = $db->prepare("SELECT COUNT(*) as count FROM Accounts WHERE account_number = :account_number");
                $stmt->execute([":account_number" => $account_number]);
                $exists = $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
            } while ($exists);

            // Deduct the deposit amount from the world account
            $world_account_stmt = $db->prepare("SELECT id, balance FROM Accounts WHERE account_number = '000000000000' AND account_type = 'world'");
            $world_account_stmt->execute();
            $world_account = $world_account_stmt->fetch(PDO::FETCH_ASSOC);

            if (!$world_account || $world_account['balance'] < $deposit_amount) {
                throw new Exception("Insufficient funds in the world account.");
            }

            // Insert the new account associated with the user
            $stmt = $db->prepare("INSERT INTO Accounts (account_number, user_id, account_type, created, modified) 
                                  VALUES (:account_number, :user_id, :account_type, NOW(), NOW())");
            $stmt->execute([
                ":account_number" => $account_number,
                ":user_id" => $user_id,
                ":account_type" => $account_type
            ]);

            // Get the ID of the newly created account
            $new_account_id = $db->lastInsertId();

            // Record the transaction in the Transactions table as a transaction pair
            $stmt = $db->prepare("INSERT INTO Transactions (account_src, account_dest, balance_change, transaction_type, memo, expected_total, created, modified)
                                  VALUES 
                                  (:src, :dest, :amount, 'debit', 'Initial deposit to $account_type account', :src_total, NOW(), NOW()),
                                  (:dest, :src, :amount, 'credit', 'Initial deposit from world account', :dest_total, NOW(), NOW())");

            // Update balances
            $world_balance_after = $world_account['balance'] - $deposit_amount;
            $user_balance_after = $deposit_amount;

            $stmt->execute([
                ":src" => $world_account['id'],
                ":dest" => $new_account_id,
                ":amount" => -$deposit_amount,
                ":src_total" => $world_balance_after,
                ":dest_total" => $user_balance_after,
            ]);

            $db->commit();

            $success_message = "Your $account_type account has been created successfully! Account Number: $account_number.";
            header("Location: dashboard.php?success=" . urlencode($success_message));
            exit;
        } catch (Exception $e) {
            $db->rollBack();
            $errors[] = "An error occurred: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - VaultForge</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #004085, #00aaff);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        nav, footer {
            background-color: #003366;
            color: #fff;
            text-align: center;
            width: 100%;
            padding: 10px 0;
        }

        .form-container {
            background-color: #fff;
            color: #333;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: 20px;
        }

        .form-container h1 {
            color: #004085;
        }

        .form-container p {
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .form-container table {
            margin: 15px auto;
            width: 100%;
            border-collapse: collapse;
        }

        .form-container table td, .form-container table th {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-container input, .form-container select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            background-color: #004085;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<nav>
    <h1>VaultForge</h1>
</nav>

<div class="form-container">
    <h1>Create Account</h1>

    <?php if (!empty($errors)) : ?>
        <div style="color: red; font-weight: bold;">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <p>Select account type and deposit amount.</p>
    <table>
        <thead>
            <tr>
                <th>Account Type</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Checking</td>
                <td>Used for daily transactions; no interest.</td>
            </tr>
            <tr>
                <td>Saving</td>
                <td>Primarily for saving money; offers interest.</td>
            </tr>
        </tbody>
    </table>

    <form method="POST">
        <label for="account_type">Account Type</label>
        <select name="account_type" id="account_type" required>
            <option value="checking">Checking</option>
            <option value="saving">Saving</option>
        </select>

        <label for="deposit_amount">Deposit Amount ($)</label>
        <input type="number" name="deposit_amount" id="deposit_amount" min="5" required>

        <button type="submit">Create Account</button>
    </form>
</div>

<footer>
    VaultForge &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
