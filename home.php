<?php
session_start(); // Start the session

require_once(__DIR__ . "/partials/nav.php"); // Include the navigation bar
require_once(__DIR__ . "/lib/db.php");
require_once(__DIR__ . "/lib/user_helpers.php");

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$db = getDB(); // Get the database connection
$user_id = get_user_id();
$errors = [];
$success_message = "";

// Handle profile update
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

// Fetch user data
$stmt = $db->prepare("SELECT username, email FROM Users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();
?>

<!-- Dashboard Page -->
<h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

<?php if ($success_message): ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php endif; ?>

<?php if ($errors): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h2>Edit Profile</h2>
<form method="POST">
    <label>Username: 
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
    </label><br>

    <label>Email: 
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
    </label><br>

    <label>Current Password (required to change password): 
        <input type="password" name="current_password">
    </label><br>

    <label>New Password: 
        <input type="password" name="new_password">
    </label><br>

    <button type="submit">Update Profile</button>
</form>

<a href="logout.php">Logout</a>
