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

<h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

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

<a href="logout.php">Logout</a>
