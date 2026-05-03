<?php
// controllers/register.php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

$errors = [];
$first_name = '';
$user_username = '';
$user_email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //  Capture and sanitize form data
    $first_name = trim($_POST['first_name'] ?? '');
    $user_username = trim($_POST['username'] ?? '');
    $user_email = trim($_POST['email'] ?? '');
    $user_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    //  Validate form input
    if (empty($first_name)) {
        $errors[] = "First Name is required.";
    }
    if (empty($user_username)) {
        $errors[] = "Username is required.";
    }
    if (empty($user_email)) {
        $errors[] = "Email is required.";
    }
    if (empty($user_password)) {
        $errors[] = "Password is required.";
    }

    // Validate Email
    if (!empty($user_email) && !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Check that Passwords match
    if ($user_password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    //  If validation passes, check database & register
    if (empty($errors)) {
        $userModel = new UserModel();

        // Check if username/email already exists
        if ($userModel->userExists($user_username, $user_email)) {
            $errors[] = "Username or Email is already in use.";
        } else {
            // Register user via the Model
            $success = $userModel->registerUser($first_name, $user_username, $user_email, $user_password);

            if ($success) {
                // Success: redirect to the login Controller
                header("Location: ../controllers/login.php");
                exit();
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        }
    }
}

// Show the registration form
include __DIR__ . '/../views/register.html';
?>