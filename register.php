<?php
require_once(__DIR__ . "/lib/db.php");
require_once(__DIR__ . "/lib/user_helpers.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    $hasError = false;
    $error_message = "";

    // Validate inputs
    if (empty($username) || strlen($username) < 3) {
        $error_message = "Username must be at least 3 characters long.";
        $hasError = true;
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email address.";
        $hasError = true;
    }
    if (empty($password) || strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
        $hasError = true;
    }
    if ($password !== $confirm) {
        $error_message = "Passwords do not match.";
        $hasError = true;
    }

    if (!$hasError) {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Insert into database
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)");

        try {
            $stmt->execute([":username" => $username, ":email" => $email, ":password" => $hash]);
            header("Location: login.php?message=Registration successful!");
            exit;
        } catch (Exception $e) {
            if ($e->getCode() == 23000) { // Duplicate entry (username or email already exists)
                $error_message = "Username or Email already registered.";
            } else {
                $error_message = "An error occurred. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VaultForge</title>
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

        /* Navbar */
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
        }

        nav .nav-links {
            display: flex;
            gap: 15px;
        }

        nav .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            padding: 8px 12px;
            border-radius: 4px;
        }

        nav .nav-links a:hover {
            background-color: #0056b3;
        }

        /* Registration container */
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            color: #333;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .register-container h1 {
            color: #004085;
            margin-bottom: 20px;
        }

        .register-container p {
            margin-bottom: 20px;
        }

        /* Form styling */
        form {
            text-align: left;
        }

        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
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

        /* Error message */
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

<nav>
    <div class="logo">VaultForge</div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="transactions.php">Transactions</a>
        <a href="login.php">Login</a>
    </div>
</nav>

<div class="register-container">
    <h1>Create an Account</h1>
    <p>Fill in the details below to register for VaultForge.</p>

    <?php if (!empty($error_message)) : ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required minlength="3" />
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required minlength="8" />
        <label for="confirm">Confirm Password</label>
        <input type="password" id="confirm" name="confirm" required minlength="8" />
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php" style="color: #004085;">Login here</a></p>
</div>

<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
