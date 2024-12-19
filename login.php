<?php
require_once(__DIR__ . "/lib/user_helpers.php");
require_once(__DIR__ . "/lib/db.php"); // Include the database connection

session_start(); // Start the session

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';
    $hasError = false;

    if (empty($identifier) || empty($password)) {
        $error_message = "Both fields are required.";
        $hasError = true;
    }

    if (!$hasError) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT id, username, email, password 
            FROM Users 
            WHERE email = :identifier OR username = :identifier
        ");
        try {
            $stmt->execute([':identifier' => $identifier]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Set session variables
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email']
                    ];
                    header("Location: home.php"); // Redirect to home page
                    exit;
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "No account found with that email or username.";
            }
        } catch (Exception $e) {
            $error_message = "An error occurred: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VaultForge</title>
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
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        /* Navbar styling */
        nav {
            background-color: #004085; /* Brand color */
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

        /* Centered container for the form */
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container h1 {
            color: #004085;
            margin-bottom: 20px;
        }

        .login-container p {
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #666;
        }

        /* Form styling */
        form {
            width: 100%;
        }

        form .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
        }

        form input[type="text"],
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

        /* Error message styling */
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Footer link */
        .login-container .footer-link {
            margin-top: 15px;
            font-size: 0.85rem;
            color: #004085;
        }

        .login-container .footer-link a {
            color: #004085;
            text-decoration: none;
        }

        .login-container .footer-link a:hover {
            text-decoration: underline;
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
        <a href="profile.php">Profile</a>
        <a href="transactions.php">Transactions</a>
        <?php if (is_logged_in()) : ?>
            <a href="logout.php">Logout</a>
        <?php else : ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Login Form -->
<div class="login-container">
    <h1>Welcome to VaultForge</h1>
    <p>Please log in to access your account.</p>

    <?php if (!empty($error_message)) : ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="identifier">Email or Username</label>
            <input type="text" id="identifier" name="identifier" required />
        </div>
        <div class="form-group">
            <label for="pw">Password</label>
            <input type="password" id="pw" name="password" required minlength="8" />
        </div>
        <button type="submit">Login</button>
    </form>

    <div class="footer-link">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</div>

</body>
</html>
