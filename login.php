<?php
require_once(__DIR__ . "/lib/user_helpers.php");
require_once(__DIR__ . "/lib/db.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';
    $error_message = '';

    if (empty($identifier) || empty($password)) {
        $error_message = "Both fields are required.";
    } else {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT id, username, email, password 
            FROM Users 
            WHERE email = :identifier OR username = :identifier
        ");
        try {
            $stmt->execute([':identifier' => $identifier]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email']
                ];
                header("Location: home.php");
                exit;
            } else {
                $error_message = "Invalid email, username, or password.";
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

        /* Login container */
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            color: #333;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container h1 {
            color: #004085;
            margin-bottom: 20px;
        }

        .login-container p {
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

<div class="login-container">
    <h1>Welcome to VaultForge</h1>
    <p>Please log in to access your account.</p>

    <?php if (!empty($error_message)) : ?>
        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="identifier">Email or Username</label>
        <input type="text" id="identifier" name="identifier" required />
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required minlength="8" />
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php" style="color: #004085;">Register here</a></p>
</div>

<footer>
    VaultForge - Banking Made Secure &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>
