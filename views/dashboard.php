<?php
// views/dashboard.php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

// Access Control: Redirect if not logged in or not an admin
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

$allUsers = $userModel->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Management</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f4; }
        .delete-btn { color: red; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div style="text-align: right; margin: 10px;">
        <span>Logged in as Admin: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span> | 
        <a href="../controllers/logout.php">Logout</a>
    </div>

    <h1>Administrative Control Panel</h1>
    <h2>User Management</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Starting IQ</th>
                <th>Final IQ</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allUsers as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo $user['is_admin'] == 1 ? '<strong>Admin</strong>' : 'Player'; ?></td>
                    <td><?php echo htmlspecialchars($user['starting_iq']); ?></td>
                    <td><?php echo $user['final_iq'] !== null ? htmlspecialchars($user['final_iq']) : 'Not Finished'; ?></td>
                    <td>
                        <a href="../controllers/edit_user.php?id=<?php echo $user['id']; ?>" style="color: blue; text-decoration: none; margin-right: 10px;">Edit</a>
                        <?php if ($user['is_admin'] == 0): ?>
                            <a class="delete-btn" href="../controllers/delete_user.php?id=<?php echo $user['id']; ?>" 
                               onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>