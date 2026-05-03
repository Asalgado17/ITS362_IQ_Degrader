<?php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

$redirect = $_GET['redirect'] ?? 'home.php';

// If already logged in, redirect immediately
if (isset($_SESSION['username'])) {
    if (!str_ends_with($redirect, '.php')) {
        $redirect .= '.php';
    }
    header('Location: ../views/' . $redirect);
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $redirect = $_POST['redirect'] ?? $redirect;

    if (empty($login)) {
        $errors[] = 'Username or Email is required.';
    }
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        $userModel = new UserModel();
        $user = $userModel->getUserByLogin($login);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['is_admin'] = (int)$user['is_admin'];
            $_SESSION['iq'] = $user['final_iq'] !== null ? (int)$user['final_iq'] : (int)$user['starting_iq'];

            // Redirect admins to dashboard, others to requested page
            if ((int)$user['is_admin'] === 1) {
                header('Location: ../views/dashboard.php');
            } else {
                if (!str_ends_with($redirect, '.php')) {
                    $redirect .= '.php';
                }
                header('Location: ../views/' . $redirect);
            }
            exit();
        }

        $errors[] = 'Invalid username/email or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<h2>Login</h2>

<?php if (!empty($errors)): ?>
    <div style="color: red; margin-bottom: 1rem;">
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">

    <label for="login">Username or Email</label><br>
    <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($login ?? ''); ?>" required><br><br>

    <label for="password">Password</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="../controllers/register.php">Create one here</a>.</p>

</body>
</html>
