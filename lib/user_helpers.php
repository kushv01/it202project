<?php
if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        return isset($_SESSION["user"]); //se($_SESSION, "user", false, false);
    }
}

if (!function_exists('has_role')) {
    function has_role($role) {
        if (is_logged_in() && isset($_SESSION["user"]["roles"])) {
            foreach ($_SESSION["user"]["roles"] as $r) {
                if ($r["name"] === $role) {
                    return true;
                }
            }
        }
        return false;
    }
}

if (!function_exists('get_username')) {
    function get_username() {
        if (is_logged_in()) { //we need to check for login first because "user" key may not exist
            return se($_SESSION["user"], "username", "", false);
        }
        return "";
    }
}

if (!function_exists('get_user_email')) {
    function get_user_email() {
        if (is_logged_in()) { //we need to check for login first because "user" key may not exist
            return se($_SESSION["user"], "email", "", false);
        }
        return "";
    }
}

if (!function_exists('get_user_id')) {
    function get_user_id() {
        if (is_logged_in()) { //we need to check for login first because "user" key may not exist
            return se($_SESSION["user"], "id", false, false);
        }
        return false;
    }
}

if (!function_exists('is_username_available')) {
    function is_username_available($username) {
        global $db;
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetchColumn() == 0;
    }
}

if (!function_exists('is_email_available')) {
    function is_email_available($email) {
        global $db;
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() == 0;
    }
}

if (!function_exists('update_user_field')) {
    function update_user_field($user_id, $field, $value) {
        global $db;
        $valid_fields = ['username', 'email', 'password']; // Specify valid fields to update
        if (!in_array($field, $valid_fields)) {
            throw new Exception("Invalid field specified");
        }

        $stmt = $db->prepare("UPDATE users SET $field = :value, modified = NOW() WHERE id = :id");
        $stmt->execute(['value' => $value, 'id' => $user_id]);
    }
}

if (!function_exists('update_user_session')) {
    function update_user_session($key, $value) {
        if (is_logged_in() && isset($_SESSION["user"])) {
            $_SESSION["user"][$key] = $value;
        }
    }
}

if (!function_exists('validate_and_update_profile')) {
    function validate_and_update_profile($user_id, $new_username, $new_email, $current_password, $new_password) {
        global $db;
        $errors = [];

        // Validate username
        if (!empty($new_username)) {
            if (strlen($new_username) < 3 || strlen($new_username) > 50) {
                $errors[] = "Username must be between 3 and 50 characters.";
            } elseif (!is_username_available($new_username)) {
                $errors[] = "Username is already taken.";
            } else {
                update_user_field($user_id, 'username', $new_username);
                update_user_session('username', $new_username);
            }
        }

        // Validate email
        if (!empty($new_email)) {
            if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            } elseif (!is_email_available($new_email)) {
                $errors[] = "Email is already in use.";
            } else {
                update_user_field($user_id, 'email', $new_email);
                update_user_session('email', $new_email);
            }
        }

        // Validate and update password
        if (!empty($current_password) && !empty($new_password)) {
            $stmt = $db->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->execute(['id' => $user_id]);
            $hashed_password = $stmt->fetchColumn();

            if (!password_verify($current_password, $hashed_password)) {
                $errors[] = "Current password is incorrect.";
            } elseif (strlen($new_password) < 8) {
                $errors[] = "New password must be at least 8 characters long.";
            } else {
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                update_user_field($user_id, 'password', $new_hashed_password);
            }
        }

        return $errors;
    }
}

if (!function_exists('logout')) {
    function logout() {
        session_unset(); // Remove all session variables
        session_destroy(); // Destroy the session
    }
}

if (!function_exists('se')) {
    function se($array, $key, $default = "", $sanitize = true) {
        if (isset($array[$key])) {
            return $sanitize ? htmlspecialchars($array[$key]) : $array[$key];
        }
        return $default;
    }
}
?>
