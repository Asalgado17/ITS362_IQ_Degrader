<?php
// controllers/edit_user.php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../controllers/login.php");
    exit();
}

$userModel = new UserModel();
$currentUser = $userModel->getUserByLogin($_SESSION['username']);

if (!$currentUser || (int)$currentUser['is_admin'] !== 1) {
    header("Location: ../controllers/login.php");
    exit();
}

$userId = $_GET['id'] ?? null;
$user = null;
$errors = [];

if ($userId) {
    $allUsers = $userModel->getAllUsers();
    foreach ($allUsers as $u) {
        if ($u['id'] == $userId) {
            $user = $u;
            break;
        }
    }
}

if (!$user) {
    header("Location: ../views/dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $isAdmin = isset($_POST['is_admin']) ? 1 : 0;
    $startingIq = (int)($_POST['starting_iq'] ?? 100);
    $finalIq = !empty($_POST['final_iq']) ? (int)$_POST['final_iq'] : null;

    if (empty($firstName) || empty($username) || empty($email)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $success = $userModel->updateUser($userId, $firstName, $username, $email, $isAdmin, $startingIq, $finalIq);
        if ($success) {
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            $errors[] = "Update failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<h2>Edit User: <?php echo htmlspecialchars($user['username']); ?></h2>

<?php if (!empty($errors)): ?>
    <div style="color: red; margin-bottom: 1rem;">
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <label for="first_name">First Name</label><br>
    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required><br><br>

    <label for="username">Username</label><br>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

    <label for="starting_iq">Starting IQ</label><br>
    <input type="number" id="starting_iq" name="starting_iq" value="<?php echo htmlspecialchars($user['starting_iq']); ?>" required><br><br>

    <label for="final_iq">Final IQ (leave empty if not set)</label><br>
    <input type="number" id="final_iq" name="final_iq" value="<?php echo htmlspecialchars($user['final_iq'] ?? ''); ?>"><br><br>

    <label for="is_admin">
        <input type="checkbox" id="is_admin" name="is_admin" <?php echo $user['is_admin'] == 1 ? 'checked' : ''; ?>> Admin
    </label><br><br>

    <button type="submit">Update User</button>
    <a href="../views/dashboard.php">Cancel</a>
</form>

</body>
</html>