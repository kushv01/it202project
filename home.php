<?php
session_start(); // Start the session

require(__DIR__ . "/partials/nav.php");
require_once(__DIR__ . "/lib/user_helpers.php");
require_once(__DIR__ . "/lib/db.php"); // Include the DB connection logic

if (!is_logged_in()) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$db = getDB(); // Initialize the database connection

$user_id = get_user_id(); // Fetch the logged-in user's ID
$errors = [];
$success_message = "";

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'] ?? "";
    $new_email = $_POST['email'] ?? "";
    $current_password = $_POST['current_password'] ?? "";
    $new_password = $_POST['new_password'] ?? "";

    $errors = validate_and_update_profile($user_id, $new_username, $new_email, $current_password, $new_password);

    if (empty($errors)) {
        $success_message = "Profile updated successfully!";
    }
}

// Fetch user details for displaying in the form
$stmt = $db->prepare("SELECT username, email FROM Users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking App</title>
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
            background-color: #f4f7fc;
            color: #333;
            line-height: 1.6;
        }

        /* Header styling */
        header {
            background-color: #004085; /* Deep blue for trust */
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Navigation bar */
        nav {
            background-color: #003366; /* Darker shade of blue */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
        }

        nav a {
            color: #fff;
            margin: 0 20px;
            text-decoration: none;
            font-size: 1rem;
            padding: 10px 15px;
        }

        nav a:hover {
            background-color: #0056b3; /* Light blue hover */
            border-radius: 5px;
        }

        /* Main container */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        /* Form styling for Profile Update */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        form h2 {
            color: #004085;
            margin-bottom: 15px;
        }

        form label {
            font-weight: bold;
            margin-bottom: 8px;
            display: inline-block;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        form button {
            background-color: #004085;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #003366;
        }

        /* Success and Error Message */
        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Admin Dashboard Section */
        .admin-dashboard {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .admin-dashboard h2 {
            color: #004085;
            margin-bottom: 15px;
        }

        .admin-dashboard ul {
            list-style-type: none;
        }

        .admin-dashboard ul li {
            margin: 10px 0;
        }

        .admin-dashboard ul li a {
            color: #003366;
            font-weight: bold;
            text-decoration: none;
        }

        .admin-dashboard ul li a:hover {
            color: #004085;
        }

        /* Footer */
        footer {
            background-color: #003366;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            nav a {
                margin: 10px 0;
            }

            .container {
                padding: 0 10px;
            }

            form {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<header>
    Banking App
</header>

<nav>
    <a href="profile.php">Profile</a>
    <a href="transactions.php">Transactions</a>
    <a href="accounts.php">Accounts</a>
</nav>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

    <!-- Profile Update Section -->
    <h2>Update Your Profile</h2>

    <?php if (!empty($success_message)) : ?>
        <p style="color: green;"><?php echo htmlspecialchars($success_message); ?></p>
    <?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
        <br>

        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password">
        <br>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password">
        <br>

        <button type="submit">Update Profile</button>
    </form>

    <!-- Admin Dashboard Section -->
    <?php if (has_role('Admin')) : ?>
        <hr>
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin! Here are your options:</p>
        <div class="admin-dashboard">
            <ul>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="view_reports.php">View Reports</a></li>
                <li><a href="system_logs.php">View System Logs</a></li>
            </ul>
        </div>
    <?php endif; ?>

    <a href="logout.php">Logout</a>
</div>

<footer>
    Banking App - © 2024
</footer>

</body>
</html>
