<?php
session_start(); // Start the session
require_once(__DIR__ . "/lib/user_helpers.php");
require_once(__DIR__ . "/lib/db.php"); // Include database connection

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$db = getDB();
$user_id = get_user_id();
$errors = [];
$success_message = "";

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'] ?? "";
    $new_email = $_POST['email'] ?? "";
    $current_password = $_POST['current_password'] ?? "";
    $new_password = $_POST['new_password'] ?? "";

    // Validation and update logic
    if (empty($new_username)) {
        $errors[] = "Username cannot be empty.";
    } elseif (strlen($new_username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    }

    if (empty($new_email) || !filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if (!empty($new_password) && strlen($new_password) < 8) {
        $errors[] = "New password must be at least 8 characters long.";
    }

    if (empty($errors)) {
        $stmt = $db->prepare("SELECT password FROM Users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($current_password, $user['password'])) {
            $update_stmt = $db->prepare("
                UPDATE Users 
                SET username = :username, email = :email, password = :password 
                WHERE id = :id
            ");
            $hash = !empty($new_password) ? password_hash($new_password, PASSWORD_BCRYPT) : $user['password'];

            try {
                $update_stmt->execute([
                    ':username' => $new_username,
                    ':email' => $new_email,
                    ':password' => $hash,
                    ':id' => $user_id
                ]);
                $success_message = "Profile updated successfully!";
            } catch (Exception $e) {
                $errors[] = "An error occurred. Please try again.";
            }
        } else {
            $errors[] = "Incorrect current password.";
        }
    }
}

// Fetch current user details
$stmt = $db->prepare("SELECT username, email FROM Users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - VaultForge</title>
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

        /* Profile Form */
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            color: #333;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .profile-container h1 {
            color: #004085;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            width: 100%;
        }

        form .form-group {
            margin-bottom: 15px;
        }

        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
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
            width: 100%;
        }

        form button:hover {
            background-color: #003366;
        }

        /* Messages */
        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Footer */
        footer {
            background-color: #003366;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
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
        <a href="logout.php">Logout</a>
    </div>
</nav>

<!-- Profile Form -->
<div class="profile-container">
    <h1>Edit Your Profile</h1>

    <?php if (!empty($success_message)) : ?>
        <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <div class="error-message">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required minlength="3" />
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />
        </div>
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required />
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" minlength="8" />
        </div>
        <button type="submit">Update Profile</button>
    </form>
</div>

<!-- Footer -->
<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
