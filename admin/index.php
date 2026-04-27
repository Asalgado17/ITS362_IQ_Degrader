<?php
require_once('../model/database.php');
require_once('../model/admin_db.php');

session_start();

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        if (isset($_SESSION['admin'])) {    // Skip login if admin is in the session
            $action = 'view_menu';
        } else {
            $action = 'view_login';
        }
    }
}

switch ($action) {
    case 'view_login':
        include 'admin_login.php';
        break;
    case 'view_menu':
        include 'admin_menu.php';
        break;
    case 'login':
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // If valid username/password, login
        if (is_valid_admin_login($username, $password)) {
            $_SESSION['admin'] = $username;
        } else {
            $error_message = 'Login failed. Invalid email or password.';
        }
        include 'admin_menu.php';
        break;
    case 'logout':
        unset($_SESSION['admin']);
        header('Location: ..' );
        break;
    default:
        echo 'Unknown action: ' . $action;
        break;
}
?>