<?php
require(__DIR__ . "/partials/nav.php");
?>
<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="identifier">Email or Username</label>
        <input type="text" name="identifier" required />
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
    </div>
    <input type="submit" value="Login" />
</form>
<script>
    function validate(form) {
        const identifier = form.identifier.value.trim();
        const password = form.password.value.trim();

        // Identifier (Email/Username) validation
        if (!identifier) {
            alert("Email or Username is required");
            return false;
        }

        // Password validation
        if (!password) {
            alert("Password is required");
            return false;
        }
        if (password.length < 8) {
            alert("Password must be at least 8 characters");
            return false;
        }

        return true; // All validations passed
    }
</script>
<?php
require_once(__DIR__ . "/lib/db.php"); // Include database connection

if (isset($_POST["identifier"]) && isset($_POST["password"])) {
    $identifier = se($_POST, "identifier", "", false);
    $password = se($_POST, "password", "", false);

    $hasError = false;

    // Validate identifier (email or username)
    if (empty($identifier)) {
        echo "Email or Username must not be empty<br>";
        $hasError = true;
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
        $stmt = $db->prepare("
            SELECT id, username, email, password 
            FROM Users 
            WHERE email = :identifier OR username = :identifier
        ");
        try {
            $r = $stmt->execute([":identifier" => $identifier]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    if (password_verify($password, $hash)) {
                        session_start();
                        $_SESSION["user"] = [
                            "id" => $user["id"],
                            "username" => $user["username"],
                            "email" => $user["email"]
                        ];
                        echo "Welcome " . htmlspecialchars($user["username"] ?? $user["email"]) . "<br>";
                        header("Location: home.php");
                        exit;
                    } else {
                        echo "Invalid password<br>";
                    }
                } else {
                    echo "No account found with that email or username<br>";
                }
            }
        } catch (Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage()) . "<br>";
        }
    }
}
?>
