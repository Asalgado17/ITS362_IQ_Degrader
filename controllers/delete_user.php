<?php
// controllers/delete_user.php
session_start();
require_once __DIR__ . '/../models/UserModel.php';

//  only logged-in admins can hit this file
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
if ($userId) {
    $userModel->deleteUserById($userId, $currentUser['id']);
}

// Redirect back to the admin dashboard view
header("Location: ../views/dashboard.php");
exit();