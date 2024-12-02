<?php
require(__DIR__ . "/partials/nav.php");
?>
<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" required minlength="3" />
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required />
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
    </div>
    <div>
        <label for="confirm">Confirm</label>
        <input type="password" name="confirm" required minlength="8" />
    </div>
    <input type="submit" value="Register" />
</form>
<script>
    function validate(form) {
        const username = form.username.value.trim();
        const email = form.email.value.trim();
        const password = form.password.value.trim();
        const confirm = form.confirm.value.trim();

        // Username validation
        if (!username) {
            alert("Username must not be empty");
            return false;
        }
        if (username.length < 3) {
            alert("Username must be at least 3 characters long");
            return false;
        }

        // Email validation
        if (!email) {
            alert("Email must not be empty");
            return false;
        }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Invalid email address");
            return false;
        }

        // Password validation
        if (!password) {
            alert("Password must not be empty");
            return false;
        }
        if (password.length < 8) {
            alert("Password must be at least 8 characters long");
            return false;
        }

        // Confirm password validation
        if (!confirm) {
            alert("Confirm password must not be empty");
            return false;
        }
        if (password !== confirm) {
            alert("Passwords do not match");
            return false;
        }

        return true; // Return true if all validations pass
    }
</script>
<?php
require_once(__DIR__ . "/lib/db.php"); // Include database connection

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    $username = se($_POST, "username", "", false);
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);

    $hasError = false;

    // Validate username
    if (empty($username)) {
        echo "Username must not be empty<br>";
        $hasError = true;
    } elseif (strlen($username) < 3) {
        echo "Username must be at least 3 characters<br>";
        $hasError = true;
    }

    // Validate email
    if (empty($email)) {
        echo "Email must not be empty<br>";
        $hasError = true;
    } else {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email address<br>";
            $hasError = true;
        }
    }

    // Validate password and confirmation
    if (empty($password)) {
        echo "Password must not be empty<br>";
        $hasError = true;
    }
    if (empty($confirm)) {
        echo "Confirm password must not be empty<br>";
        $hasError = true;
    }
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters<br>";
        $hasError = true;
    }
    if ($password !== $confirm) {
        echo "Passwords do not match<br>";
        $hasError = true;
    }

    if (!$hasError) {
        // Hash the password
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Insert into database
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (username, email, password) VALUES(:username, :email, :password)");

        try {
            $stmt->execute([":username" => $username, ":email" => $email, ":password" => $hash]);
            echo "Successfully registered!<br>";
        } catch (Exception $e) {
            if ($e->getCode() == 23000) { // Duplicate entry (username or email already exists)
                echo "Username or Email already registered<br>";
            } else {
                echo "There was a problem registering<br>";
                echo "<pre>" . var_export($e, true) . "</pre>";
            }
        }
    }
}
?>
