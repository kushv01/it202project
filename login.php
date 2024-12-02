<?php
require(__DIR__ . "/partials/nav.php");
?>
<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required />
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
    </div>
    <input type="submit" value="Login" />
</form>
<script>
    function validate(form) {
        // Ensure form validation logic checks for proper email and password format
        const email = form.email.value.trim();
        const password = form.password.value;

        if (!email) {
            alert("Email is required");
            return false;
        }

        // Basic email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address");
            return false;
        }

        if (!password) {
            alert("Password is required");
            return false;
        }

        if (password.length < 8) {
            alert("Password must be at least 8 characters");
            return false;
        }

        return true;
    }
</script>
<?php
require_once(__DIR__ . "/common/db.php"); // Include database connection
require_once(__DIR__ . "/common/util.php"); // Include utility functions

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);

    $hasError = false;

    // Sanitize and validate email
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

    // Validate password
    if (empty($password)) {
        echo "Password must not be empty<br>";
        $hasError = true;
    } elseif (strlen($password) < 8) {
        echo "Password must be at least 8 characters<br>";
        $hasError = true;
    }

    if (!$hasError) {
        // Database connection
        $db = getDB();
        $stmt = $db->prepare("SELECT id, email, password FROM Users WHERE email = :email");
        try {
            $r = $stmt->execute([":email" => $email]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    if (password_verify($password, $hash)) {
                        session_start();
                        $_SESSION["user"] = [
                            "id" => $user["id"],
                            "email" => $user["email"]
                        ];
                        echo "Welcome " . htmlspecialchars($email) . "<br>";
                        header("Location: home.php");
                        exit;
                    } else {
                        echo "Invalid password<br>";
                    }
                } else {
                    echo "Email not found<br>";
                }
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage()) . "<br>";
        }
    }
}
?>
